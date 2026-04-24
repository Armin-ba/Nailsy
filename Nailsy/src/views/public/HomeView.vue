<script setup>
import { onMounted, ref } from "vue";
import { getApprovedArtists } from "../../services/artistService";

const artists = ref([]);
const loading = ref(true);
const error = ref("");

onMounted(async () => {
  try {
    const data = await getApprovedArtists();


    artists.value = data.slice(0, 3);
  } catch (err) {
    error.value = "Nem sikerült betölteni a körmösöket.";
    console.error(err);
  } finally {
    loading.value = false;
  }
});
</script>


<template>
  <div>
    <section class="hero-section py-5">
      <div class="container">
        <div class="row align-items-center gy-4">
          <div class="col-lg-6">
            <span class="badge rounded-pill text-bg-light mb-3">
              <i class="bi bi-heart-fill me-1"></i>
              Körmösfoglalás egyszerűen
            </span>

            <h1 class="display-5 fw-bold mb-3">
              Találd meg a kedvenc körmösödet a
              <span class="text-brand">Nailsy</span> segítségével
            </h1>

            <p class="lead text-muted mb-4">
              Böngéssz körmösök között, nézd meg a szolgáltatásokat,
              értékeléseket és foglalj időpontot könnyedén.
            </p>

            <div class="d-flex gap-2 flex-wrap">
              <RouterLink to="/artists" class="btn btn-dark btn-lg">
                Körmösök megtekintése
              </RouterLink>

              <RouterLink to="/auth/register" class="btn btn-outline-dark btn-lg">
                Regisztráció
              </RouterLink>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="hero-card shadow-lg">
              <i class="bi bi-calendar-heart display-1 text-brand"></i>
              <h3 class="mt-3">Gyors időpontfoglalás</h3>
              <p class="text-muted mb-0">
                Válassz körmöst, szolgáltatást és szabad időpontot.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="search" class="py-5 bg-light">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="fw-bold mb-1">Kiemelt körmösök</h2>
            <p class="text-muted mb-0">
              Jóváhagyott körmösök az adatbázisból.
            </p>
          </div>

          <RouterLink to="/artists" class="btn btn-outline-dark">
            Összes körmös
          </RouterLink>
        </div>

        <div v-if="loading" class="text-center py-5">
          <div class="spinner-border text-dark" role="status"></div>
          <p class="text-muted mt-3">Körmösök betöltése...</p>
        </div>

        <div v-else-if="error" class="alert alert-danger">
          {{ error }}
        </div>

        <div v-else-if="artists.length === 0" class="alert alert-warning">
          Jelenleg nincs megjeleníthető körmös.
        </div>

        <div v-else class="row g-4">
          <div
              v-for="artist in artists"
              :key="artist.id"
              class="col-md-6 col-lg-4"
          >
            <div class="card h-100 border-0 shadow-sm artist-card">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <div class="avatar me-3">
                    <i class="bi bi-person-heart"></i>
                  </div>

                  <div>
                    <h5 class="card-title mb-0">
                      {{ artist.name }}
                    </h5>

                    <small class="text-muted">
                      <i class="bi bi-geo-alt me-1"></i>
                      {{ artist.city }}
                    </small>
                  </div>
                </div>

                <p class="card-text text-muted artist-description">
                  {{ artist.description || "Nincs megadott leírás." }}
                </p>

                <div class="d-flex justify-content-between align-items-center">
                  <span class="badge text-bg-light">
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
  </div>
</template>



<style scoped>
.hero-section {
  background: linear-gradient(135deg, #fff5f9, #ffffff);
}

.text-brand {
  color: #c15c8a;
}

.hero-card {
  background: white;
  border-radius: 28px;
  padding: 60px 40px;
  text-align: center;
}

.artist-card {
  border-radius: 22px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.artist-card:hover {
  transform: translateY(-4px);
}

.avatar {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background: #ffe3ef;
  color: #c15c8a;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
}

.artist-description {
  min-height: 72px;
}
</style>