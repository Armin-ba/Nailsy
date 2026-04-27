<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <div class="mb-4">
        <h1 class="fw-bold mb-1">Admin dashboard</h1>
        <p class="text-muted mb-0">
          Felhasználók, körmösök és jelentett hozzászólások kezelése egy helyen.
        </p>
      </div>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-if="success" class="alert alert-success">
        {{ success }}
      </div>

      <div class="row g-4 mb-4">
        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
              <h5 class="fw-bold">Felhasználók</h5>
              <p class="display-6 fw-bold mb-0">{{ users.length }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
              <h5 class="fw-bold">Körmösök</h5>
              <p class="display-6 fw-bold mb-0">{{ artists.length }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
              <h5 class="fw-bold">Jelentések</h5>
              <p class="display-6 fw-bold mb-0">{{ reports.length }}</p>
            </div>
          </div>
        </div>
      </div>

      <ul class="nav nav-pills mb-4">
        <li class="nav-item">
          <button
              class="nav-link"
              :class="{ active: activeTab === 'users' }"
              @click="activeTab = 'users'"
          >
            Felhasználók
          </button>
        </li>

        <li class="nav-item">
          <button
              class="nav-link"
              :class="{ active: activeTab === 'artists' }"
              @click="activeTab = 'artists'"
          >
            Körmösök
          </button>
        </li>

        <li class="nav-item">
          <button
              class="nav-link"
              :class="{ active: activeTab === 'reports' }"
              @click="activeTab = 'reports'"
          >
            Jelentett hozzászólások
          </button>
        </li>
      </ul>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark"></div>
        <p class="text-muted mt-3">Admin adatok betöltése...</p>
      </div>

      <div v-else>
        <!-- USERS -->
        <div v-if="activeTab === 'users'" class="card border-0 shadow-sm rounded-4">
          <div class="card-body">
            <h4 class="fw-bold mb-3">Felhasználók kezelése</h4>

            <table class="table align-middle">
              <thead>
              <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-end">Műveletek</th>
              </tr>
              </thead>

              <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <span class="badge text-bg-dark">{{ user.role }}</span>
                </td>

                <td class="text-end">
                  <button
                      class="btn btn-outline-dark btn-sm me-2"
                      @click="loadUserRatings(user)"
                  >
                    Hozzászólások
                  </button>

                  <button
                      class="btn btn-danger btn-sm"
                      :disabled="user.role === 'admin'"
                      @click="deleteUser(user.id)"
                  >
                    Törlés
                  </button>
                </td>
              </tr>
              </tbody>
            </table>

            <div v-if="selectedUser" class="border rounded-4 p-3 mt-4 bg-light">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                  <h5 class="fw-bold mb-0">
                    {{ selectedUser.name }} hozzászólásai
                  </h5>
                  <small class="text-muted">{{ selectedUser.email }}</small>
                </div>

                <button class="btn btn-outline-secondary btn-sm" @click="closeRatings">
                  Bezárás
                </button>
              </div>

              <div v-if="ratingsLoading" class="text-center py-3">
                <div class="spinner-border text-dark"></div>
              </div>

              <div v-else-if="userRatings.length === 0" class="alert alert-warning">
                Ennek a felhasználónak nincs hozzászólása.
              </div>

              <div
                  v-for="rating in userRatings"
                  v-else
                  :key="rating.id"
                  class="bg-white border rounded-4 p-3 mb-2"
              >
                <div class="d-flex justify-content-between">
                  <div>
                    <div class="mb-1">
                      <i
                          v-for="i in rating.star"
                          :key="i"
                          class="bi bi-star-fill text-warning"
                      ></i>
                    </div>

                    <p class="mb-1">
                      {{ rating.comment || "Nincs szöveges hozzászólás." }}
                    </p>

                    <small class="text-muted">
                      Körmös: {{ rating.nail_artist?.name || "Ismeretlen" }}
                    </small>
                  </div>

                  <button
                      class="btn btn-outline-danger btn-sm"
                      @click="deleteRating(rating.id)"
                  >
                    Törlés
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- ARTISTS -->
        <div v-if="activeTab === 'artists'" class="card border-0 shadow-sm rounded-4">
          <div class="card-body">
            <h4 class="fw-bold mb-3">Körmösök kezelése</h4>

            <table class="table align-middle">
              <thead>
              <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Email</th>
                <th>Város</th>
                <th>Státusz</th>
                <th class="text-end">Műveletek</th>
              </tr>
              </thead>

              <tbody>
              <tr v-for="artist in artists" :key="artist.id">
                <td>{{ artist.id }}</td>
                <td>{{ artist.name }}</td>
                <td>{{ artist.user?.email || "Nincs email" }}</td>
                <td>{{ artist.city }}</td>
                <td>
                    <span
                        class="badge"
                        :class="artist.approved ? 'text-bg-success' : 'text-bg-warning'"
                    >
                      {{ artist.approved ? "Hitelesítve" : "Jóváhagyásra vár" }}
                    </span>
                </td>

                <td class="text-end">
                  <button
                      v-if="!artist.approved"
                      class="btn btn-success btn-sm me-2"
                      @click="approveArtist(artist.id)"
                  >
                    Jóváhagyás
                  </button>

                  <button
                      class="btn btn-danger btn-sm"
                      @click="deleteArtist(artist.id)"
                  >
                    Törlés
                  </button>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- REPORTS -->
        <div v-if="activeTab === 'reports'" class="card border-0 shadow-sm rounded-4">
          <div class="card-body">
            <h4 class="fw-bold mb-3">Jelentett hozzászólások</h4>

            <div v-if="reports.length === 0" class="alert alert-warning">
              Nincs aktív jelentés.
            </div>

            <div
                v-for="report in reports"
                :key="report.id"
                class="border rounded-4 p-3 mb-3"
            >
              <div class="mb-2">
                <strong>Komment:</strong>
                {{ report.rating?.comment || "A komment már nem elérhető." }}
              </div>

              <div class="text-muted small mb-2">
                Írta:
                {{ report.rating?.user?.name || "Ismeretlen" }}
                |
                Jelentette:
                {{ report.reporter?.name || "Ismeretlen" }}
              </div>

              <div class="mb-3">
                <strong>Indok:</strong>
                {{ report.reason || "Nincs megadott indok." }}
              </div>

              <button
                  v-if="report.rating"
                  class="btn btn-danger btn-sm me-2"
                  @click="deleteRating(report.rating.id)"
              >
                Komment törlése
              </button>

              <button
                  class="btn btn-outline-secondary btn-sm"
                  @click="dismissReport(report.id)"
              >
                Jelentés elutasítása
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { onMounted, ref } from "vue";
import api from "../../../api/axios";

const activeTab = ref("users");

const users = ref([]);
const artists = ref([]);
const reports = ref([]);

const selectedUser = ref(null);
const userRatings = ref([]);

const loading = ref(true);
const ratingsLoading = ref(false);
const error = ref("");
const success = ref("");

const loadDashboard = async () => {
  loading.value = true;
  error.value = "";

  try {
    const [usersRes, artistsRes, reportsRes] = await Promise.all([
      api.get("/admin/users"),
      api.get("/admin/artists"),
      api.get("/admin/reports"),
    ]);

    users.value = usersRes.data;
    artists.value = artistsRes.data;
    reports.value = reportsRes.data;
  } catch (err) {
    error.value =
        err.response?.data?.message || "Nem sikerült betölteni az admin adatokat.";
    console.error(err);
  } finally {
    loading.value = false;
  }
};

const deleteUser = async (id) => {
  if (!confirm("Biztosan törölni szeretnéd ezt a felhasználót?")) return;

  success.value = "";
  error.value = "";

  try {
    await api.delete(`/admin/users/${id}`);
    success.value = "Felhasználó törölve.";
    await loadDashboard();
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült törölni.";
  }
};

const loadUserRatings = async (user) => {
  selectedUser.value = user;
  userRatings.value = [];
  ratingsLoading.value = true;

  try {
    const res = await api.get(`/admin/users/${user.id}/ratings`);
    userRatings.value = res.data.ratings;
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült lekérni a hozzászólásokat.";
  } finally {
    ratingsLoading.value = false;
  }
};

const closeRatings = () => {
  selectedUser.value = null;
  userRatings.value = [];
};

const approveArtist = async (id) => {
  success.value = "";
  error.value = "";

  try {
    await api.patch(`/admin/artists/${id}/approve`);
    success.value = "Körmös jóváhagyva.";
    await loadDashboard();
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült jóváhagyni.";
  }
};

const deleteArtist = async (id) => {
  if (!confirm("Biztosan törölni szeretnéd ezt a körmöst?")) return;

  success.value = "";
  error.value = "";

  try {
    await api.delete(`/admin/artists/${id}`);
    success.value = "Körmös törölve.";
    await loadDashboard();
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült törölni.";
  }
};

const deleteRating = async (id) => {
  if (!confirm("Biztosan törölni szeretnéd ezt a hozzászólást?")) return;

  success.value = "";
  error.value = "";

  try {
    await api.delete(`/admin/ratings/${id}`);
    success.value = "Hozzászólás törölve.";
    await loadDashboard();

    if (selectedUser.value) {
      await loadUserRatings(selectedUser.value);
    }
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült törölni a hozzászólást.";
  }
};

const dismissReport = async (id) => {
  success.value = "";
  error.value = "";

  try {
    await api.patch(`/admin/reports/${id}/dismiss`);
    success.value = "Jelentés elutasítva.";
    await loadDashboard();
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült elutasítani.";
  }
};

onMounted(loadDashboard);
</script>