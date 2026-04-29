<script setup>
import { onMounted, reactive, ref } from "vue";
import { useRoute } from "vue-router";
import {
  getArtistById,
  getArtistServices,
  getArtistSlots,
  getArtistRatings,
} from "../../services/artistService";
import { createRating } from "../../services/ratingService";
import { createReport } from "../../services/reportService";
import { useAuthStore } from "../../stores/auth";

const route = useRoute();
const auth = useAuthStore();

const artist = ref(null);
const services = ref([]);
const slots = ref([]);
const ratings = ref([]);
const loading = ref(true);
const error = ref("");

const ratingLoading = ref(false);
const ratingError = ref("");
const ratingSuccess = ref("");

const reportLoadingId = ref(null);
const reportError = ref("");
const reportSuccess = ref("");

const ratingForm = reactive({
  star: 5,
  comment: "",
});

const reportReasons = [
  "Nem releváns hozzászólás",
  "Sértő vagy zaklató tartalom",
  "Spam vagy reklám",
  "Hamis információ",
  "Közösségi irányelvek megsértése",
];

const loadArtistData = async () => {
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
  ratings.value = ratingData.map((rating) => ({
    ...rating,
    report_reason: reportReasons[0],
  }));
};

const submitRating = async () => {
  ratingError.value = "";
  ratingSuccess.value = "";
  ratingLoading.value = true;

  try {
    await createRating({
      nail_artist_id: artist.value.id,
      star: ratingForm.star,
      comment: ratingForm.comment,
    });

    ratingSuccess.value = "Értékelés sikeresen elküldve.";
    ratingForm.star = 5;
    ratingForm.comment = "";

    await loadArtistData();
  } catch (err) {
    ratingError.value =
        err.response?.data?.message || "Nem sikerült elküldeni az értékelést.";
  } finally {
    ratingLoading.value = false;
  }
};

const submitReport = async (rating) => {
  reportError.value = "";
  reportSuccess.value = "";
  reportLoadingId.value = rating.id;

  try {
    await createReport({
      rating_id: rating.id,
      reason: rating.report_reason,
    });

    reportSuccess.value = "Jelentés sikeresen elküldve.";
  } catch (err) {
    reportError.value =
        err.response?.data?.message || "Nem sikerült elküldeni a jelentést.";
  } finally {
    reportLoadingId.value = null;
  }
};

onMounted(async () => {
  try {
    await loadArtistData();
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
        <div class="spinner-border text-dark"></div>
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

              <div v-if="auth.isLoggedIn" class="rating-box rounded-4 p-3 mb-4">
                <h5 class="fw-bold mb-3">Értékelés írása</h5>

                <div v-if="ratingSuccess" class="alert alert-success">
                  {{ ratingSuccess }}
                </div>

                <div v-if="ratingError" class="alert alert-danger">
                  {{ ratingError }}
                </div>

                <div class="mb-3">
                  <label class="form-label">Csillag</label>
                  <select v-model="ratingForm.star" class="form-select">
                    <option :value="5">5 csillag</option>
                    <option :value="4">4 csillag</option>
                    <option :value="3">3 csillag</option>
                    <option :value="2">2 csillag</option>
                    <option :value="1">1 csillag</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Vélemény</label>
                  <textarea
                      v-model="ratingForm.comment"
                      class="form-control"
                      rows="3"
                      placeholder="Írd le a véleményed..."
                  ></textarea>
                </div>

                <button
                    class="btn btn-dark"
                    :disabled="ratingLoading"
                    @click="submitRating"
                >
                  <span
                      v-if="ratingLoading"
                      class="spinner-border spinner-border-sm me-2"
                  ></span>
                  Értékelés küldése
                </button>
              </div>

              <div v-else class="alert alert-light border">
                Értékelés írásához és jelentéshez jelentkezz be.
                <RouterLink to="/auth/login">Bejelentkezés</RouterLink>
              </div>

              <div v-if="reportSuccess" class="alert alert-success">
                {{ reportSuccess }}
              </div>

              <div v-if="reportError" class="alert alert-danger">
                {{ reportError }}
              </div>

              <div v-if="ratings.length === 0" class="text-muted">
                Még nincs értékelés.
              </div>

              <div
                  v-for="rating in ratings"
                  :key="rating.id"
                  class="border-bottom py-3"
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

                <div v-if="auth.isLoggedIn" class="mt-3">
                  <div class="row g-2">
                    <div class="col-md-8">
                      <select v-model="rating.report_reason" class="form-select form-select-sm">
                        <option
                            v-for="reason in reportReasons"
                            :key="reason"
                            :value="reason"
                        >
                          {{ reason }}
                        </option>
                      </select>
                    </div>

                    <div class="col-md-4">
                      <button
                          class="btn btn-outline-danger btn-sm w-100"
                          :disabled="reportLoadingId === rating.id"
                          @click="submitReport(rating)"
                      >
                        <span
                            v-if="reportLoadingId === rating.id"
                            class="spinner-border spinner-border-sm me-1"
                        ></span>
                        Jelentés
                      </button>
                    </div>
                  </div>
                </div>
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

.rating-box {
  background: #fff5f9;
  border: 1px solid #ffd6e7;
}
</style>