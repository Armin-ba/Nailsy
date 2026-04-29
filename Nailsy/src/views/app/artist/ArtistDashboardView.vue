<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">

      <div class="mb-4">
        <h1 class="fw-bold mb-1">Körmös dashboard</h1>
        <p class="text-muted mb-0">
          Kezeld a szolgáltatásaidat és a szabad időpontjaidat.
        </p>
      </div>

      <div v-if="globalError" class="alert alert-danger">
        {{ globalError }}
      </div>

      <div class="row g-4">

        <!-- SERVICE PANEL -->
        <div class="col-lg-5">

          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">

              <h4 class="fw-bold mb-3">
                <i class="bi bi-brush me-2"></i>
                Szolgáltatások
              </h4>

              <div v-if="serviceSuccess" class="alert alert-success">
                {{ serviceSuccess }}
              </div>

              <div v-if="serviceError" class="alert alert-danger">
                {{ serviceError }}
              </div>

              <div class="mb-3">
                <label class="form-label">Szolgáltatás neve</label>
                <input
                    v-model="serviceForm.name"
                    class="form-control"
                    placeholder="pl. Gél lakkozás"
                />
              </div>

              <div class="row g-2">
                <div class="col-md-6">
                  <label class="form-label">Ár</label>
                  <input
                      v-model="serviceForm.price"
                      type="number"
                      class="form-control"
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Időtartam</label>
                  <input
                      v-model="serviceForm.duration_min"
                      type="number"
                      class="form-control"
                  />
                </div>
              </div>

              <button
                  class="btn btn-dark w-100 mt-3"
                  :disabled="serviceLoading"
                  @click="handleCreateService"
              >
                Szolgáltatás hozzáadása
              </button>

              <hr class="my-4" />

              <h5 class="fw-bold mb-3">Saját szolgáltatások</h5>

              <div
                  v-for="service in services"
                  :key="service.id"
                  class="service-item d-flex justify-content-between align-items-center mb-2"
              >
                <div>
                  <strong>{{ service.name }}</strong>
                  <div class="text-muted small">
                    {{ service.price }} Ft · {{ service.duration_min }} perc
                  </div>
                </div>

                <button
                    class="btn btn-sm btn-outline-danger"
                    @click="handleDeleteService(service.id)"
                >
                  <i class="bi bi-trash"></i>
                </button>

              </div>

            </div>
          </div>

        </div>


        <!-- SLOT PANEL -->
        <div class="col-lg-7">

          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-4">

              <h4 class="fw-bold mb-3">
                <i class="bi bi-calendar-plus me-2"></i>
                Szabad időpont hozzáadása
              </h4>

              <div v-if="slotSuccess" class="alert alert-success">
                {{ slotSuccess }}
              </div>

              <div v-if="slotError" class="alert alert-danger">
                {{ slotError }}
              </div>

              <div class="row g-3">
                <div class="col-md-4">
                  <input v-model="slotForm.slot_date" type="date" class="form-control" />
                </div>

                <div class="col-md-4">
                  <input v-model="slotForm.start_time" type="time" class="form-control" />
                </div>

                <div class="col-md-4">
                  <input v-model="slotForm.end_time" type="time" class="form-control" />
                </div>
              </div>

              <button
                  class="btn btn-dark w-100 mt-3"
                  :disabled="slotLoading"
                  @click="handleCreateSlot"
              >
                Időpont hozzáadása
              </button>

              <hr class="my-4" />

              <!-- WEEK NAV -->

              <div class="d-flex justify-content-between mb-3">

                <button class="btn btn-outline-dark btn-sm" @click="previousWeek">
                  ← Előző hét
                </button>

                <strong>
                  {{ formatDate(weekDays[0]) }} - {{ formatDate(weekDays[6]) }}
                </strong>

                <button class="btn btn-outline-dark btn-sm" @click="nextWeek">
                  Következő hét →
                </button>

              </div>

              <!-- CALENDAR -->

              <div class="table-responsive">

                <table class="table table-bordered calendar-table">

                  <thead>
                  <tr>
                    <th
                        v-for="day in weekDays"
                        :key="day"
                        class="calendar-head text-center"
                    >
                      {{ getDayName(day) }}
                      <br />
                      <small>{{ formatDate(day) }}</small>
                    </th>
                  </tr>
                  </thead>

                  <tbody>

                  <tr>

                    <td
                        v-for="day in weekDays"
                        :key="day + '-slots'"
                        class="calendar-cell"
                    >

                      <div
                          v-if="getSlotsForDay(day).length === 0"
                          class="text-muted small text-center py-3"
                      >
                        Nincs időpont
                      </div>

                      <div
                          v-for="slot in getSlotsForDay(day)"
                          :key="slot.id"
                          class="slot-card"
                          :class="{ booked: slot.is_booked }"
                      >

                        <div class="fw-semibold">
                          {{ normalizeTime(slot.start_time) }}
                          -
                          {{ normalizeTime(slot.end_time) }}
                        </div>

                        <small>
                          {{ slot.is_booked ? "Foglalt" : "Szabad" }}
                        </small>

                        <button
                            v-if="!slot.is_booked"
                            class="btn btn-sm btn-outline-danger w-100 mt-2"
                            @click="handleDeleteSlot(slot.id)"
                        >
                          Törlés
                        </button>

                      </div>

                    </td>

                  </tr>

                  </tbody>

                </table>

              </div>

            </div>
          </div>

        </div>

      </div>

    </div>
  </section>
</template>



<script setup>

import { ref, reactive, computed, onMounted } from "vue"
import {
  getMyServices,
  createService,
  deleteService
} from "../../../services/serviceService"

import {
  getMySlots,
  createSlot,
  deleteSlot
} from "../../../services/slotService"



const services = ref([])
const slots = ref([])

const globalError = ref("")

const serviceLoading = ref(false)
const serviceSuccess = ref("")
const serviceError = ref("")

const slotLoading = ref(false)
const slotSuccess = ref("")
const slotError = ref("")



const serviceForm = reactive({
  name: "",
  price: "",
  duration_min: ""
})

const slotForm = reactive({
  slot_date: "",
  start_time: "",
  end_time: ""
})



const currentWeekStart = ref(getStartOfWeek(new Date()))



const weekDays = computed(() => {
  return [...Array(7)].map((_, i) => {
    const d = new Date(currentWeekStart.value)
    d.setDate(d.getDate() + i)
    return d
  })
})



function getStartOfWeek(date) {

  const d = new Date(date)
  const day = d.getDay()
  const diff = day === 0 ? -6 : 1 - day

  d.setDate(d.getDate() + diff)
  d.setHours(0,0,0,0)

  return d
}



function toDateString(date) {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");

  return `${year}-${month}-${day}`;
}



function formatDate(date){
  return date.toLocaleDateString("hu-HU",{month:"2-digit",day:"2-digit"})
}



function getDayName(date){
  return date.toLocaleDateString("hu-HU",{weekday:"long"})
}



function normalizeTime(time){
  return time?.slice(0,5)
}



const getSlotsForDay = (date)=>{

  const dateString = toDateString(date)

  return slots.value
      .filter(slot => slot.slot_date === dateString)
      .sort((a,b)=>a.start_time.localeCompare(b.start_time))

}



const previousWeek = ()=>{
  const d=new Date(currentWeekStart.value)
  d.setDate(d.getDate()-7)
  currentWeekStart.value=d
}



const nextWeek = ()=>{
  const d=new Date(currentWeekStart.value)
  d.setDate(d.getDate()+7)
  currentWeekStart.value=d
}



const loadServices = async()=>{
  services.value = await getMyServices()
}



const loadSlots = async()=>{
  slots.value = await getMySlots()
}



const loadDashboard = async()=>{
  try{
    await Promise.all([loadServices(),loadSlots()])
  }
  catch{
    globalError.value="Nem sikerült betölteni a dashboard adatokat"
  }
}



const handleCreateService = async()=>{

  serviceLoading.value=true

  try{

    await createService(serviceForm)

    serviceSuccess.value="Szolgáltatás hozzáadva"

    serviceForm.name=""
    serviceForm.price=""
    serviceForm.duration_min=""

    await loadServices()

  }catch(err){

    serviceError.value="Nem sikerült létrehozni"

  }

  serviceLoading.value=false

}



const handleDeleteService = async(id)=>{
  await deleteService(id)
  await loadServices()
}



const handleCreateSlot = async()=>{

  slotLoading.value=true

  try{

    await createSlot(slotForm)

    slotSuccess.value="Időpont hozzáadva"

    slotForm.slot_date=""
    slotForm.start_time=""
    slotForm.end_time=""

    await loadSlots()

  }
  catch{
    slotError.value="Nem sikerült létrehozni"
  }

  slotLoading.value=false

}



const handleDeleteSlot = async(id)=>{
  await deleteSlot(id)
  await loadSlots()
}



onMounted(loadDashboard)

</script>



<style scoped>

.service-item{
  background:white;
  border:1px solid #eee;
  border-radius:14px;
  padding:10px
}

.calendar-head{
  background:#fff5f9
}

.calendar-cell{
  height:210px;
  vertical-align:top
}

.slot-card{
  background:#fff5f9;
  border:1px solid #ffd6e7;
  border-radius:12px;
  padding:8px;
  margin-bottom:6px
}

.slot-card.booked{
  background:#f1f1f1;
  border-color:#ddd
}

</style>