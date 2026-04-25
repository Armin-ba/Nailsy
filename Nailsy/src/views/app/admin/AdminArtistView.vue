<template>

  <div class="container py-5">

    <h2 class="fw-bold mb-4">Körmös hitelesítés</h2>

    <table class="table">

      <thead>
      <tr>
        <th>Név</th>
        <th>Város</th>
        <th>Approved</th>
        <th></th>
      </tr>
      </thead>

      <tbody>

      <tr v-for="artist in artists" :key="artist.id">

        <td>{{ artist.name }}</td>
        <td>{{ artist.city }}</td>

        <td>

          <span v-if="artist.approved">✔</span>
          <span v-else>❌</span>

        </td>

        <td>

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

</template>

<script setup>

import { ref,onMounted } from "vue"
import api from "../../../api/axios"

const artists=ref([])

const loadArtists=async()=>{
  const res=await api.get("/admin/artists")
  artists.value=res.data
}

const approve=async(id)=>{
  await api.patch(`/admin/artists/${id}/approve`)
  loadArtists()
}

const deleteArtist=async(id)=>{
  await api.delete(`/admin/artists/${id}`)
  loadArtists()
}

onMounted(loadArtists)

</script>