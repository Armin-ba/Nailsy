<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
          <h1 class="fw-bold mb-1">Saját foglalásaim</h1>
          <p class="text-muted mb-0">
            Itt láthatod az összes eddigi és közelgő foglalásodat.
          </p>
        </div>

        <RouterLink to="/artists" class="btn btn-dark">
          <i class="bi bi-plus-circle me-1"></i>
          Új foglalás
        </RouterLink>
      </div>

      <div v-if="success" class="alert alert-success">
        {{ success }}
      </div>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark"></div>
        <p class="text-muted mt-3">Foglalások betöltése...</p>
      </div>

      <div v-else-if="bookings.length === 0" class="card border-0 shadow-sm rounded-4">
        <div class="card-body text-center p-5">
          <i class="bi bi-calendar-x display-3 text-muted"></i>
          <h3 class="fw-bold mt-3">Még nincs foglalásod</h3>
          <p class="text-muted">
            Böngéssz a körmösök között, és foglalj időpontot.
          </p>

          <RouterLink to="/artists" class="btn btn-dark">
            Körmösök megtekintése
          </RouterLink>
        </div>
      </div>

      <div v-else class="row g-4">
        <div
            v-for="booking in bookings"
            :key="booking.id"
            class="col-md-6 col-lg-4"
        >
          <div class="card h-100 border-0 shadow-sm rounded-4 booking-card">
            <div class="card-body p-4">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                  <h5 class="fw-bold mb-1">
                    {{ booking.nail_artist?.name || "Körmös" }}
                  </h5>

                  <p class="text-muted mb-0">
                    <i class="bi bi-geo-alt me-1"></i>
                    {{ booking.nail_artist?.city || "Nincs megadva" }}
                  </p>
                </div>

                <span class="badge" :class="statusClass(booking.status)">
                  {{ statusText(booking.status) }}
                </span>
              </div>

              <div class="mb-3">
                <small class="text-muted">Szolgáltatás</small>
                <div class="fw-semibold">
                  {{ booking.service?.name || "Nincs megadva" }}
                </div>
                <div v-if="booking.service" class="text-muted small">
                  {{ booking.service.price }} Ft ·
                  {{ booking.service.duration_min }} perc
                </div>
              </div>

              <div class="row g-2 mb-3">
                <div class="col-6">
                  <div class="info-box">
                    <small class="text-muted">Dátum</small>
                    <div class="fw-semibold">
                      {{ booking.booking_date }}
                    </div>
                  </div>
                </div>

                <div class="col-6">
                  <div class="info-box">
                    <small class="text-muted">Időpont</small>
                    <div class="fw-semibold">
                      {{ normalizeTime(booking.booking_time) }}
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="booking.available_slot" class="mb-3 text-muted small">
                <i class="bi bi-clock me-1"></i>
                {{ normalizeTime(booking.available_slot.start_time) }}
                -
                {{ normalizeTime(booking.available_slot.end_time) }}
              </div>

              <div class="d-flex gap-2">
                <RouterLink
                    v-if="booking.nail_artist"
                    :to="`/artists/${booking.nail_artist.id}`"
                    class="btn btn-outline-dark w-100"
                >
                  Körmös profil
                </RouterLink>

                <button
                    class="btn btn-outline-danger w-100"
                    :disabled="deletingId === booking.id || booking.status === 'accepted'"
                    @click="cancelBooking(booking.id)"
                >
                  <span
                      v-if="deletingId === booking.id"
                      class="spinner-border spinner-border-sm me-1"
                  ></span>
                  Lemondás
                </button>
              </div>

              <small
                  v-if="booking.status === 'accepted'"
                  class="text-muted d-block mt-2"
              >
                Elfogadott foglalást csak telefonon lehet módosítani.
              </small>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import {
  getMyBookings,
  deleteBooking,
} from "../../../services/bookingService";

const bookings = ref([]);
const loading = ref(true);
const deletingId = ref(null);
const error = ref("");
const success = ref("");

const loadBookings = async () => {
  loading.value = true;
  error.value = "";

  try {
    bookings.value = await getMyBookings();
  } catch (err) {
    error.value = "Nem sikerült betölteni a foglalásokat.";
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const cancelBooking = async (id) => {
  const confirmed = confirm("Biztosan le szeretnéd mondani ezt a foglalást?");

  if (!confirmed) return;

  error.value = "";
  success.value = "";
  deletingId.value = id;

  try {
    await deleteBooking(id);
    success.value = "Foglalás sikeresen lemondva.";
    await loadBookings();
  } catch (err) {
    error.value =
        err.response?.data?.message || "Nem sikerült lemondani a foglalást.";
  } finally {
    deletingId.value = null;
  }
};

const normalizeTime = (time) => {
  if (!time) return "Nincs megadva";
  return time.slice(0, 5);
};

const statusText = (status) => {
  switch (status) {
    case "pending":
      return "Függőben";
    case "accepted":
      return "Elfogadva";
    case "rejected":
      return "Elutasítva";
    case "cancelled":
      return "Lemondva";
    default:
      return status;
  }
};

const statusClass = (status) => {
  switch (status) {
    case "pending":
      return "text-bg-warning";
    case "accepted":
      return "text-bg-success";
    case "rejected":
      return "text-bg-danger";
    case "cancelled":
      return "text-bg-secondary";
    default:
      return "text-bg-light";
  }
};

onMounted(() => {
  loadBookings();
});
</script>

<style scoped>
.booking-card {
  transition: 0.2s ease;
}

.booking-card:hover {
  transform: translateY(-3px);
}

.info-box {
  background: #fff5f9;
  border: 1px solid #ffd6e7;
  border-radius: 14px;
  padding: 10px;
}

.btn-dark {
  background-color: #222;
}
</style>