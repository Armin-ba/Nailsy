<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <h2 class="fw-bold mb-4">Felhasználók kezelése</h2>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-if="success" class="alert alert-success">
        {{ success }}
      </div>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark"></div>
        <p class="text-muted mt-3">Felhasználók betöltése...</p>
      </div>

      <div v-else class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
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
                  <span class="badge text-bg-dark">
                    {{ user.role }}
                  </span>
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
        </div>
      </div>

      <div v-if="selectedUser" class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h4 class="fw-bold mb-1">
                {{ selectedUser.name }} hozzászólásai
              </h4>
              <p class="text-muted mb-0">
                {{ selectedUser.email }}
              </p>
            </div>

            <button class="btn btn-outline-secondary btn-sm" @click="closeRatings">
              Bezárás
            </button>
          </div>

          <div v-if="ratingsLoading" class="text-center py-4">
            <div class="spinner-border text-dark"></div>
          </div>

          <div v-else-if="userRatings.length === 0" class="alert alert-warning">
            Ennek a felhasználónak még nincs hozzászólása.
          </div>

          <div v-else>
            <div
                v-for="rating in userRatings"
                :key="rating.id"
                class="border rounded-4 p-3 mb-3 bg-white"
            >
              <div class="d-flex justify-content-between align-items-start">
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
                    Körmös:
                    {{ rating.nail_artist?.name || "Ismeretlen körmös" }}
                  </small>
                </div>

                <button
                    class="btn btn-outline-danger btn-sm"
                    @click="deleteRating(rating.id)"
                >
                  Hozzászólás törlése
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
import api from "../../../api/axios";

const users = ref([]);
const selectedUser = ref(null);
const userRatings = ref([]);

const loading = ref(true);
const ratingsLoading = ref(false);

const error = ref("");
const success = ref("");

const loadUsers = async () => {
  loading.value = true;
  error.value = "";

  try {
    const res = await api.get("/admin/users");
    users.value = res.data;
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült betölteni a felhasználókat.";
  } finally {
    loading.value = false;
  }
};

const deleteUser = async (id) => {
  if (!confirm("Biztosan törölni szeretnéd ezt a felhasználót?")) return;

  error.value = "";
  success.value = "";

  try {
    await api.delete(`/admin/users/${id}`);
    success.value = "Felhasználó törölve.";

    if (selectedUser.value?.id === id) {
      closeRatings();
    }

    await loadUsers();
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült törölni a felhasználót.";
  }
};

const loadUserRatings = async (user) => {
  selectedUser.value = user;
  userRatings.value = [];
  ratingsLoading.value = true;
  error.value = "";

  try {
    const res = await api.get(`/admin/users/${user.id}/ratings`);
    userRatings.value = res.data.ratings;
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült lekérni a hozzászólásokat.";
  } finally {
    ratingsLoading.value = false;
  }
};

const deleteRating = async (id) => {
  if (!confirm("Biztosan törölni szeretnéd ezt a hozzászólást?")) return;

  error.value = "";
  success.value = "";

  try {
    await api.delete(`/admin/ratings/${id}`);
    success.value = "Hozzászólás törölve.";

    if (selectedUser.value) {
      await loadUserRatings(selectedUser.value);
    }
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült törölni a hozzászólást.";
  }
};

const closeRatings = () => {
  selectedUser.value = null;
  userRatings.value = [];
};

onMounted(loadUsers);
</script>