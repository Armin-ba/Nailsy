<script setup>
import { ref } from "vue";


</script>

<template>
  <section class="container py-5">
    <h1 class="mb-4 text-center">Körmösök listája</h1>

    <div class="row g-4">
      <div
          v-for="artist in nailArtists"
          :key="artist.id"
          class="col-12 col-md-6 col-xl-4"
      >
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body">
            <h3 class="card-title fs-4">{{ artist.name }}</h3>
            <p class="mb-1">📍 {{ artist.city }}</p>
            <p class="mb-1">⭐ {{ artist.rating }}</p>
            <p class="mb-3">💰 {{ artist.price }}</p>

            <div class="row g-2">
              <div
                  v-for="(image, index) in artist.images"
                  :key="index"
                  class="col-6"
              >
                <img
                    :src="image"
                    :alt="`${artist.name} - körömkép ${index + 1}`"
                    class="img-fluid rounded nail-image"
                />
              </div>
            </div>
          </div>

          <div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
            <button class="btn btn-info w-100 text-white">
              Részletek megtekintése
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
h1 {
  font-weight: 700;
}

.card-title {
  color: #0d6efd;
  font-weight: 600;
}

.nail-image {
  width: 100%;
  height: 140px;
  object-fit: cover;
  transition: transform 0.2s ease;
}

.nail-image:hover {
  transform: scale(1.03);
}
</style>