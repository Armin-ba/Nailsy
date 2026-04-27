<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <h2 class="fw-bold mb-4">Körmös hitelesítés</h2>

      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-dark"></div>
        <p class="text-muted mt-3">Körmösök betöltése...</p>
      </div>

      <div v-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <div v-if="success" class="alert alert-success">
        {{ success }}
      </div>

      <div v-if="!loading && artists.length === 0" class="alert alert-warning">
        Nincs megjeleníthető körmös.
      </div>

      <div v-if="!loading && artists.length > 0" class="card border-0 shadow-sm rounded-4">
        <div class="card-body">
          <table class="table align-middle">
            <thead>
            <tr>
              <th>ID</th>
              <th>Név</th>
              <th>Email</th>
              <th>Város</th>
              <th>Approved</th>
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
                    class="btn btn-success btn-sm"
                    @click="approve(artist.id)"
                >
                  Jóváhagyás
                </button>

                <button
                    class="btn btn-danger btn-sm ms-2"
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
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../../api/axios";

const artists = ref([]);
const loading = ref(true);
const error = ref("");
const success = ref("");

const loadArtists = async () => {
  loading.value = true;
  error.value = "";

  try {
    const res = await api.get("/admin/artists");
    artists.value = res.data;
    console.log("ADMIN ARTISTS:", res.data);
  } catch (err) {
    console.error("ADMIN ARTISTS ERROR:", err);
    error.value =
        err.response?.data?.message ||
        `Nem sikerült betölteni a körmösöket. Status: ${err.response?.status || "ismeretlen"}`;
  } finally {
    loading.value = false;
  }
};

const approve = async (id) => {
  success.value = "";
  error.value = "";

  try {
    await api.patch(`/admin/artists/${id}/approve`, {
      approved: true,
    });

    success.value = "Körmös jóváhagyva.";
    await loadArtists();
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
    await loadArtists();
  } catch (err) {
    error.value = err.response?.data?.message || "Nem sikerült törölni.";
  }
};

onMounted(loadArtists);
</script>