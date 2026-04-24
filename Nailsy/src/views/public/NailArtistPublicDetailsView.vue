<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import {
  getArtistById,
  getArtistServices,
  getArtistSlots,
  getArtistRatings,
} from "../../services/artistService";

const route = useRoute();

const artist = ref(null);
const services = ref([]);
const slots = ref([]);
const ratings = ref([]);
const loading = ref(true);
const error = ref("");

onMounted(async () => {
  try {
    const artistId = route.params.id;

    const [artistData, serviceData, slotData, ratingData] = await Promise.all([
      getArtistById(artistId),
      getArtistServices(artistId),
      getArtistSlots(artistId),
      getArtistRatings(artistId),
    ]);

    artist.value = artistData;
    services.value = serviceData;
    slots.value = slotData;
    ratings.value = ratingData;
  } catch (err) {
    error.value = "Nem sikerült betölteni a körmös adatait.";
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>
<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <RouterLink to="/artists" class="btn btn-outline-dark mb-4">
        <i class="bi bi-arrow-left me-1"></i>
        Vissza a körmösökhöz
      </RouterLink>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark" role="status"></div>
        <p class="text-muted mt-3">Adatok betöltése...</p>
      </div>

      <div v-else-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-else-if="artist" class="row g-4">
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <h1 class="fw-bold mb-2">{{ artist.name }}</h1>

              <p class="text-muted mb-3">
                <i class="bi bi-geo-alt me-1"></i>
                {{ artist.city }}
              </p>

              <p>{{ artist.description }}</p>

              <div class="d-flex gap-3 flex-wrap">
                <span class="badge text-bg-light">
                  <i class="bi bi-star-fill text-warning me-1"></i>
                  {{ artist.rating ?? 0 }}
                </span>

                <span class="badge text-bg-light">
                  {{ artist.price_range }}
                </span>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
              <h3 class="fw-bold mb-3">Szolgáltatások</h3>

              <div v-if="services.length === 0" class="text-muted">
                Nincs megadott szolgáltatás.
              </div>

              <div
                  v-for="service in services"
                  :key="service.id"
                  class="d-flex justify-content-between border-bottom py-2"
              >
                <div>
                  <strong>{{ service.name }}</strong>
                  <div class="text-muted small">
                    {{ service.duration_min }} perc
                  </div>
                </div>

                <div class="fw-semibold">
                  {{ service.price }} Ft
                </div>
              </div>
            </div>
          </div>

          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
              <h3 class="fw-bold mb-3">Értékelések</h3>

              <div v-if="ratings.length === 0" class="text-muted">
                Még nincs értékelés.
              </div>

              <div
                  v-for="rating in ratings"
                  :key="rating.id"
                  class="border-bottom py-2"
              >
                <div class="mb-1">
                  <i
                      v-for="i in rating.star"
                      :key="i"
                      class="bi bi-star-fill text-warning"
                  ></i>
                </div>

                <p class="mb-1">{{ rating.comment }}</p>

                <small class="text-muted">
                  {{ rating.user?.name || "Felhasználó" }}
                </small>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card border-0 shadow-sm rounded-4 sticky-card">
            <div class="card-body p-4">
              <h4 class="fw-bold mb-3">Szabad időpontok</h4>

              <div v-if="slots.length === 0" class="text-muted">
                Nincs elérhető időpont.
              </div>

              <div
                  v-for="slot in slots"
                  :key="slot.id"
                  class="border rounded-3 p-3 mb-2 bg-white"
              >
                <div class="fw-semibold">
                  {{ slot.slot_date }}
                </div>

                <div class="text-muted">
                  {{ slot.start_time }} - {{ slot.end_time }}
                </div>
              </div>

              <RouterLink
                  :to="`/app/booking/${artist.id}`"
                  class="btn btn-dark w-100 mt-3"
              >
                Időpont foglalása
              </RouterLink>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>



<style scoped>
.sticky-card {
  position: sticky;
  top: 90px;
}
</style>