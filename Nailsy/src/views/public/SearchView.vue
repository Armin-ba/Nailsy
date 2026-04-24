<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <div class="mb-4">
        <h1 class="fw-bold">Keresés</h1>
        <p class="text-muted mb-0">
          Szűrj város, szolgáltatás és értékelés alapján.
        </p>
      </div>

      <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
          <div class="row g-3 align-items-end">
            <div class="col-md-4">
              <label class="form-label">Város</label>
              <input
                  v-model="filters.city"
                  type="text"
                  class="form-control"
                  placeholder="pl. Budapest"
              />
            </div>

            <div class="col-md-4">
              <label class="form-label">Szolgáltatás</label>
              <input
                  v-model="filters.service"
                  type="text"
                  class="form-control"
                  placeholder="pl. Gél lakkozás"
              />
            </div>

            <div class="col-md-2">
              <label class="form-label">Minimum értékelés</label>
              <select v-model="filters.min_rating" class="form-select">
                <option value="">Mindegy</option>
                <option value="5">5 csillag</option>
                <option value="4">4+ csillag</option>
                <option value="3">3+ csillag</option>
              </select>
            </div>

            <div class="col-md-2 d-grid">
              <button class="btn btn-dark" @click="handleSearch">
                <i class="bi bi-search me-1"></i>
                Keresés
              </button>
            </div>
          </div>

          <button class="btn btn-link text-muted px-0 mt-3" @click="clearFilters">
            Szűrők törlése
          </button>
        </div>
      </div>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark"></div>
        <p class="text-muted mt-3">Keresés...</p>
      </div>

      <div v-else-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-else-if="artists.length === 0" class="alert alert-warning">
        Nincs találat a megadott szűrőkkel.
      </div>

      <div v-else class="row g-4">
        <div
            v-for="artist in artists"
            :key="artist.id"
            class="col-md-6 col-lg-4"
        >
          <div class="card h-100 border-0 shadow-sm rounded-4">
            <div class="card-body">
              <h5 class="fw-bold">{{ artist.name }}</h5>

              <p class="text-muted mb-2">
                <i class="bi bi-geo-alt me-1"></i>
                {{ artist.city }}
              </p>

              <p class="text-muted artist-description">
                {{ artist.description || "Nincs megadott leírás." }}
              </p>

              <div class="mb-3">
                <span
                    v-for="service in artist.services?.slice(0, 3)"
                    :key="service.id"
                    class="badge text-bg-light me-1 mb-1"
                >
                  {{ service.name }}
                </span>
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <span>
                  <i class="bi bi-star-fill text-warning me-1"></i>
                  {{ artist.rating ?? 0 }}
                </span>

                <span class="fw-semibold">
                  {{ artist.price_range }}
                </span>
              </div>
            </div>

            <div class="card-footer bg-white border-0">
              <RouterLink
                  :to="`/artists/${artist.id}`"
                  class="btn btn-dark w-100"
              >
                Profil megtekintése
              </RouterLink>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import { searchArtists } from "../../services/artistService";

const artists = ref([]);
const loading = ref(false);
const error = ref("");

const filters = reactive({
  city: "",
  service: "",
  min_rating: "",
});

const handleSearch = async () => {
  loading.value = true;
  error.value = "";

  try {
    artists.value = await searchArtists({
      city: filters.city || undefined,
      service: filters.service || undefined,
      min_rating: filters.min_rating || undefined,
    });
  } catch (err) {
    error.value = "Nem sikerült lefuttatni a keresést.";
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const clearFilters = async () => {
  filters.city = "";
  filters.service = "";
  filters.min_rating = "";
  await handleSearch();
};

onMounted(() => {
  handleSearch();
});
</script>

<style scoped>
.artist-description {
  min-height: 70px;
}
</style>