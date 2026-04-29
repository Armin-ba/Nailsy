<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <RouterLink :to="`/artists/${artistId}`" class="btn btn-outline-dark mb-4">
        <i class="bi bi-arrow-left me-1"></i>
        Vissza a körmös profiljához
      </RouterLink>

      <div class="mb-4">
        <h1 class="fw-bold mb-1">Időpont foglalása</h1>
        <p class="text-muted mb-0">
          Válassz szolgáltatást, majd kattints egy szabad időpontra a naptárban.
        </p>
      </div>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-if="success" class="alert alert-success">
        {{ success }}
      </div>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark"></div>
        <p class="text-muted mt-3">Foglalási adatok betöltése...</p>
      </div>

      <div v-else class="row g-4">
        <div class="col-lg-4">
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3">
                <i class="bi bi-brush me-2"></i>
                Szolgáltatás kiválasztása
              </h4>

              <div v-if="services.length === 0" class="alert alert-warning">
                Ennél a körmösnél még nincs elérhető szolgáltatás.
              </div>

              <div
                  v-for="service in services"
                  :key="service.id"
                  class="service-card mb-2"
                  :class="{ active: selectedServiceId === service.id }"
                  @click="selectService(service)"
              >
                <div>
                  <strong>{{ service.name }}</strong>
                  <div class="text-muted small">
                    {{ service.duration_min }} perc
                  </div>
                </div>

                <div class="fw-bold">
                  {{ service.price }} Ft
                </div>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3">
                <i class="bi bi-check2-circle me-2"></i>
                Kiválasztott foglalás
              </h4>

              <div v-if="!selectedService && !selectedSlot" class="text-muted">
                Még nincs kiválasztva szolgáltatás és időpont.
              </div>

              <div v-if="selectedService" class="mb-3">
                <small class="text-muted">Szolgáltatás</small>
                <div class="fw-bold">{{ selectedService.name }}</div>
                <div class="text-muted">
                  {{ selectedService.price }} Ft · {{ selectedService.duration_min }} perc
                </div>
              </div>

              <div v-if="selectedSlot" class="mb-3">
                <small class="text-muted">Időpont</small>
                <div class="fw-bold">{{ selectedSlot.slot_date }}</div>
                <div class="text-muted">
                  {{ normalizeTime(selectedSlot.start_time) }} -
                  {{ normalizeTime(selectedSlot.end_time) }}
                </div>
              </div>

              <button
                  class="btn btn-dark w-100"
                  :disabled="!canSubmit || submitting"
                  @click="submitBooking"
              >
                <span
                    v-if="submitting"
                    class="spinner-border spinner-border-sm me-2"
                ></span>
                Foglalás véglegesítése
              </button>

              <button
                  v-if="selectedSlot || selectedService"
                  class="btn btn-link text-muted w-100 mt-2"
                  @click="clearSelection"
              >
                Kiválasztás törlése
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
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

              <div v-if="slots.length === 0" class="alert alert-warning">
                Ennél a körmösnél jelenleg nincs szabad időpont.
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

                      <button
                          v-for="slot in getSlotsForDay(day)"
                          :key="slot.id"
                          class="slot-card mb-2 w-100 text-start"
                          :class="{ active: selectedSlotId === slot.id }"
                          @click="selectSlot(slot)"
                      >
                        <div class="fw-semibold">
                          {{ normalizeTime(slot.start_time) }} -
                          {{ normalizeTime(slot.end_time) }}
                        </div>

                        <small>Szabad</small>
                      </button>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>

              <div class="text-muted small mt-3">
                <i class="bi bi-info-circle me-1"></i>
                Csak szabad időpontok jelennek meg. A foglalás után az időpont
                foglalttá válik.
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import {
  getArtistServices,
  getArtistSlots,
} from "../../../services/artistService";
import { createBooking } from "../../../services/bookingService";

const route = useRoute();
const router = useRouter();

const artistId = route.params.artistId;

const services = ref([]);
const slots = ref([]);

const selectedServiceId = ref(null);
const selectedSlotId = ref(null);

const selectedService = ref(null);
const selectedSlot = ref(null);

const loading = ref(true);
const submitting = ref(false);
const error = ref("");
const success = ref("");

const currentWeekStart = ref(getStartOfWeek(new Date()));

const weekDays = computed(() => {
  const days = [];

  for (let i = 0; i < 7; i++) {
    const date = new Date(currentWeekStart.value);
    date.setDate(currentWeekStart.value.getDate() + i);
    days.push(date);
  }

  return days;
});

const canSubmit = computed(() => {
  return selectedServiceId.value && selectedSlotId.value;
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
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");

  return `${year}-${month}-${day}`;
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
      .filter((slot) => slot.slot_date === dateString && !slot.is_booked)
      .sort((a, b) => a.start_time.localeCompare(b.start_time));
}

function previousWeek() {
  const date = new Date(currentWeekStart.value);
  date.setDate(date.getDate() - 7);
  currentWeekStart.value = date;
}

function nextWeek() {
  const date = new Date(currentWeekStart.value);
  date.setDate(date.getDate() + 7);
  currentWeekStart.value = date;
}

function selectService(service) {
  selectedService.value = service;
  selectedServiceId.value = service.id;
}

function selectSlot(slot) {
  selectedSlot.value = slot;
  selectedSlotId.value = slot.id;
}

function clearSelection() {
  selectedService.value = null;
  selectedServiceId.value = null;
  selectedSlot.value = null;
  selectedSlotId.value = null;
}

async function loadBookingData() {
  loading.value = true;
  error.value = "";

  try {
    const [serviceData, slotData] = await Promise.all([
      getArtistServices(artistId),
      getArtistSlots(artistId),
    ]);

    services.value = serviceData;
    slots.value = slotData;

    if (slotData.length > 0) {
      currentWeekStart.value = getStartOfWeek(new Date(slotData[0].slot_date));
    }
  } catch (err) {
    error.value = "Nem sikerült betölteni a foglalási adatokat.";
    console.error(err);
  } finally {
    loading.value = false;
  }
}

async function submitBooking() {
  error.value = "";
  success.value = "";

  if (!selectedServiceId.value || !selectedSlotId.value) {
    error.value = "Válassz szolgáltatást és időpontot.";
    return;
  }

  submitting.value = true;

  try {
    await createBooking({
      service_id: selectedServiceId.value,
      available_slot_id: selectedSlotId.value,
    });

    success.value = "Foglalás sikeresen létrehozva.";

    await loadBookingData();
    clearSelection();

    setTimeout(() => {
      router.push("/app/my-bookings");
    }, 1000);
  } catch (err) {
    error.value =
        err.response?.data?.message || "Nem sikerült létrehozni a foglalást.";
  } finally {
    submitting.value = false;
  }
}

onMounted(() => {
  loadBookingData();
});
</script>

<style scoped>
.service-card {
  display: flex;
  justify-content: space-between;
  gap: 12px;
  padding: 14px;
  border: 1px solid #eeeeee;
  border-radius: 16px;
  background: white;
  cursor: pointer;
  transition: 0.2s ease;
}

.service-card:hover {
  border-color: #c15c8a;
  background: #fff5f9;
}

.service-card.active {
  border-color: #c15c8a;
  background: #fff5f9;
  box-shadow: 0 0 0 2px rgba(193, 92, 138, 0.15);
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
  height: 260px;
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
  transition: 0.2s ease;
}

.slot-card:hover {
  border-color: #c15c8a;
  background: #ffe3ef;
}

.slot-card.active {
  border-color: #c15c8a;
  background: #c15c8a;
  color: white;
}

.btn-dark {
  background-color: #222;
}
</style>