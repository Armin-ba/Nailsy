<script setup>
import { onMounted, ref } from "vue";
import { getApprovedArtists } from "../../services/artistService";

const artists = ref([]);
const loading = ref(true);
const error = ref("");

onMounted(async () => {
  try {
    artists.value = await getApprovedArtists();
  } catch (err) {
    error.value = "Nem sikerült betölteni a körmösöket.";
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <div class="mb-4">
        <h1 class="fw-bold">Körmösök</h1>
        <p class="text-muted mb-0">
          Böngéssz a jóváhagyott körmösök között.
        </p>
      </div>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark" role="status"></div>
        <p class="text-muted mt-3">Betöltés...</p>
      </div>

      <div v-else-if="error" class="alert alert-danger">
        {{ error }}
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

              <p class="text-muted">
                {{ artist.description || "Nincs megadott leírás." }}
              </p>

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
                Részletek
              </RouterLink>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

