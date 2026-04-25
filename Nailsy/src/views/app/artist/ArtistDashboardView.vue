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
        <!-- SZOLGÁLTATÁSOK -->
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
                    type="text"
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
                      placeholder="pl. 8000"
                  />
                </div>

                <div class="col-md-6">
                  <label class="form-label">Időtartam / perc</label>
                  <input
                      v-model="serviceForm.duration_min"
                      type="number"
                      class="form-control"
                      placeholder="pl. 60"
                  />
                </div>
              </div>

              <button
                  class="btn btn-dark w-100 mt-3"
                  :disabled="serviceLoading"
                  @click="handleCreateService"
              >
                <span
                    v-if="serviceLoading"
                    class="spinner-border spinner-border-sm me-2"
                ></span>
                Szolgáltatás hozzáadása
              </button>

              <hr class="my-4" />

              <h5 class="fw-bold mb-3">Saját szolgáltatásaim</h5>

              <div v-if="services.length === 0" class="text-muted">
                Még nincs felvett szolgáltatásod.
              </div>

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

        <!-- IDŐPONT FELVÉTEL -->
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
                  <label class="form-label">Dátum</label>
                  <input
                      v-model="slotForm.slot_date"
                      type="date"
                      class="form-control"
                  />
                </div>

                <div class="col-md-4">
                  <label class="form-label">Kezdés</label>
                  <input
                      v-model="slotForm.start_time"
                      type="time"
                      class="form-control"
                  />
                </div>

                <div class="col-md-4">
                  <label class="form-label">Befejezés</label>
                  <input
                      v-model="slotForm.end_time"
                      type="time"
                      class="form-control"
                  />
                </div>
              </div>

              <button
                  class="btn btn-dark w-100 mt-3"
                  :disabled="slotLoading"
                  @click="handleCreateSlot"
              >
                <span
                    v-if="slotLoading"
                    class="spinner-border spinner-border-sm me-2"
                ></span>
                Időpont hozzáadása
              </button>

              <hr class="my-4" />

              <h5 class="fw-bold mb-3">
                <i class="bi bi-calendar-week me-2"></i>
                Szabad időpontok naptárnézetben
              </h5>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-outline-dark btn-sm" @click="previousWeek">
                  <i class="bi bi-chevron-left"></i>
                  Előző hét
                </button>

                <strong>
                  {{ formatDate(weekDays[0]) }} - {{ formatDate(weekDays[6]) }}
                </strong>

                <button class="btn btn-outline-dark btn-sm" @click="nextWeek">
                  Következő hét
                  <i class="bi bi-chevron-right"></i>
                </button>
              </div>

              <div v-if="slotsLoading" class="text-center py-4">
                <div class="spinner-border text-dark"></div>
              </div>

              <div v-else class="table-responsive">
                <table class="table table-bordered calendar-table align-middle bg-white">
                  <thead>
                  <tr>
                    <th
                        v-for="day in weekDays"
                        :key="day.toISOString()"
                        class="text-center calendar-head"
                    >
                      <div class="fw-bold">{{ getDayName(day) }}</div>
                      <small class="text-muted">{{ formatDate(day) }}</small>
                    </th>
                  </tr>
                  </thead>

                  <tbody>
                  <tr>
                    <td
                        v-for="day in weekDays"
                        :key="day.toISOString() + '-body'"
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
                          class="slot-card mb-2"
                          :class="{ booked: slot.is_booked }"
                      >
                        <div class="fw-semibold">
                          {{ normalizeTime(slot.start_time) }} -
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

              <div class="mt-3 text-muted small">
                <i class="bi bi-info-circle me-1"></i>
                A foglalt időpontokat nem lehet törölni.
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import {
  getMyServices,
  createService,
  deleteService,
} from "../../../services/serviceService";
import {
  getMySlots,
  createSlot,
  deleteSlot,
} from "../../../services/slotService";

const services = ref([]);
const slots = ref([]);

const globalError = ref("");

const serviceLoading = ref(false);
const serviceSuccess = ref("");
const serviceError = ref("");

const slotLoading = ref(false);
const slotsLoading = ref(false);
const slotSuccess = ref("");
const slotError = ref("");

const currentWeekStart = ref(getStartOfWeek(new Date()));

const serviceForm = reactive({
  name: "",
  price: "",
  duration_min: "",
});

const slotForm = reactive({
  slot_date: "",
  start_time: "",
  end_time: "",
});

const weekDays = computed(() => {
  const days = [];

  for (let i = 0; i < 7; i++) {
    const date = new Date(currentWeekStart.value);
    date.setDate(currentWeekStart.value.getDate() + i);
    days.push(date);
  }

  return days;
});

function getStartOfWeek(date) {
  const copied = new Date(date);
  const day = copied.getDay();
  const diff = day === 0 ? -6 : 1 - day;

  copied.setDate(copied.getDate() + diff);
  copied.setHours(0, 0, 0, 0);

  return copied;
}

function toDateString(date) {
  return date.toISOString().split("T")[0];
}

function formatDate(date) {
  return date.toLocaleDateString("hu-HU", {
    month: "2-digit",
    day: "2-digit",
  });
}

function getDayName(date) {
  return date.toLocaleDateString("hu-HU", {
    weekday: "long",
  });
}

function normalizeTime(time) {
  if (!time) return "";
  return time.slice(0, 5);
}

function getSlotsForDay(day) {
  const dateString = toDateString(day);

  return slots.value
      .filter((slot) => slot.slot_date === dateString)
      .sort((a, b) => a.start_time.localeCompare(b.start_time));
}

const previousWeek = () => {
  const date = new Date(currentWeekStart.value);
  date.setDate(date.getDate() - 7);
  currentWeekStart.value = date;
};

const nextWeek = () => {
  const date = new Date(currentWeekStart.value);
  date.setDate(date.getDate() + 7);
  currentWeekStart.value = date;
};

const loadServices = async () => {
  services.value = await getMyServices();
};

const loadSlots = async () => {
  slotsLoading.value = true;

  try {
    slots.value = await getMySlots();
  } catch (error) {
    globalError.value = "Nem sikerült betölteni az időpontokat.";
  } finally {
    slotsLoading.value = false;
  }
};

const loadDashboard = async () => {
  try {
    await Promise.all([loadServices(), loadSlots()]);
  } catch (error) {
    globalError.value = "Nem sikerült betölteni a dashboard adatait.";
  }
};

const resetServiceForm = () => {
  serviceForm.name = "";
  serviceForm.price = "";
  serviceForm.duration_min = "";
};

const resetSlotForm = () => {
  slotForm.slot_date = "";
  slotForm.start_time = "";
  slotForm.end_time = "";
};

const handleCreateService = async () => {
  serviceSuccess.value = "";
  serviceError.value = "";

  if (!serviceForm.name || !serviceForm.price || !serviceForm.duration_min) {
    serviceError.value = "Minden mező kitöltése kötelező.";
    return;
  }

  serviceLoading.value = true;

  try {
    await createService({
      name: serviceForm.name,
      price: Number(serviceForm.price),
      duration_min: Number(serviceForm.duration_min),
    });

    serviceSuccess.value = "Szolgáltatás sikeresen hozzáadva.";
    resetServiceForm();
    await loadServices();
  } catch (error) {
    serviceError.value =
        error.response?.data?.message || "Nem sikerült létrehozni a szolgáltatást.";
  } finally {
    serviceLoading.value = false;
  }
};

const handleDeleteService = async (id) => {
  serviceSuccess.value = "";
  serviceError.value = "";

  try {
    await deleteService(id);
    serviceSuccess.value = "Szolgáltatás törölve.";
    await loadServices();
  } catch (error) {
    serviceError.value =
        error.response?.data?.message || "Nem sikerült törölni a szolgáltatást.";
  }
};

const handleCreateSlot = async () => {
  slotSuccess.value = "";
  slotError.value = "";

  if (!slotForm.slot_date || !slotForm.start_time || !slotForm.end_time) {
    slotError.value = "Minden időpont mező kitöltése kötelező.";
    return;
  }

  slotLoading.value = true;

  try {
    await createSlot({
      slot_date: slotForm.slot_date,
      start_time: slotForm.start_time,
      end_time: slotForm.end_time,
    });

    slotSuccess.value = "Szabad időpont sikeresen hozzáadva.";
    resetSlotForm();
    await loadSlots();
  } catch (error) {
    slotError.value =
        error.response?.data?.message || "Nem sikerült létrehozni az időpontot.";
  } finally {
    slotLoading.value = false;
  }
};

const handleDeleteSlot = async (id) => {
  slotSuccess.value = "";
  slotError.value = "";

  try {
    await deleteSlot(id);
    slotSuccess.value = "Időpont törölve.";
    await loadSlots();
  } catch (error) {
    slotError.value =
        error.response?.data?.message || "Nem sikerült törölni az időpontot.";
  }
};

onMounted(() => {
  loadDashboard();
});
</script>

<style scoped>
.service-item {
  background: #fff;
  border: 1px solid #eeeeee;
  border-radius: 16px;
  padding: 12px 14px;
}

.calendar-table {
  min-width: 900px;
}

.calendar-head {
  background: #fff5f9;
  color: #333;
  width: 14.28%;
}

.calendar-cell {
  min-width: 130px;
  height: 210px;
  vertical-align: top;
  background: #ffffff;
}

.slot-card {
  border: 1px solid #ffd6e7;
  background: #fff5f9;
  color: #333;
  border-radius: 14px;
  padding: 10px;
  font-size: 0.9rem;
}

.slot-card.booked {
  background: #f1f1f1;
  border-color: #dddddd;
  color: #777;
}

.btn-dark {
  background-color: #222;
}
</style>