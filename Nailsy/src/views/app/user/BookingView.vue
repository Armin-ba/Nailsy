<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <RouterLink :to="`/artists/${artistId}`" class="btn btn-outline-dark mb-4">
        <i class="bi bi-arrow-left me-1"></i>
        Vissza a profilhoz
      </RouterLink>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
              <h2 class="fw-bold mb-3">Időpont foglalása</h2>

              <div v-if="success" class="alert alert-success">
                {{ success }}
              </div>

              <div v-if="error" class="alert alert-danger">
                {{ error }}
              </div>

              <div v-if="loading" class="text-center py-5">
                <div class="spinner-border text-dark"></div>
                <p class="text-muted mt-3">Adatok betöltése...</p>
              </div>

              <div v-else>
                <div class="mb-3">
                  <label class="form-label">Szolgáltatás</label>
                  <select v-model="selectedServiceId" class="form-select">
                    <option value="">Válassz szolgáltatást</option>
                    <option
                        v-for="service in services"
                        :key="service.id"
                        :value="service.id"
                    >
                      {{ service.name }} - {{ service.price }} Ft -
                      {{ service.duration_min }} perc
                    </option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Szabad időpont</label>
                  <select v-model="selectedSlotId" class="form-select">
                    <option value="">Válassz időpontot</option>
                    <option
                        v-for="slot in slots"
                        :key="slot.id"
                        :value="slot.id"
                    >
                      {{ slot.slot_date }} | {{ slot.start_time }} -
                      {{ slot.end_time }}
                    </option>
                  </select>
                </div>

                <button
                    class="btn btn-dark w-100"
                    :disabled="submitting"
                    @click="submitBooking"
                >
                  <span
                      v-if="submitting"
                      class="spinner-border spinner-border-sm me-2"
                  ></span>
                  Foglalás elküldése
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
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

const selectedServiceId = ref("");
const selectedSlotId = ref("");

const loading = ref(true);
const submitting = ref(false);
const error = ref("");
const success = ref("");

onMounted(async () => {
  try {
    const [serviceData, slotData] = await Promise.all([
      getArtistServices(artistId),
      getArtistSlots(artistId),
    ]);

    services.value = serviceData;
    slots.value = slotData;
  } catch (err) {
    error.value = "Nem sikerült betölteni a foglalási adatokat.";
    console.error(err);
  } finally {
    loading.value = false;
  }
});

const submitBooking = async () => {
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

    setTimeout(() => {
      router.push("/app/my-bookings");
    }, 1000);
  } catch (err) {
    error.value =
        err.response?.data?.message || "Nem sikerült létrehozni a foglalást.";
  } finally {
    submitting.value = false;
  }
};
</script>