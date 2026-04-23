<script setup>
import { ref } from "vue";

const nailArtists = ref([
  {
    id: 1,
    name: "Beauty Nails Studio",
    city: "Budapest",
    rating: 4.9,
    price: "5.000 - 12.000 Ft",
    images: [
      "https://picsum.photos/300/200?random=11",
      "https://picsum.photos/300/200?random=12",
      "https://picsum.photos/300/200?random=13",
      "https://picsum.photos/300/200?random=14",
    ],
  },
  {
    id: 2,
    name: "Pink Nails Art",
    city: "Debrecen",
    rating: 4.8,
    price: "4.500 - 10.000 Ft",
    images: [
      "https://picsum.photos/300/200?random=21",
      "https://picsum.photos/300/200?random=22",
      "https://picsum.photos/300/200?random=23",
      "https://picsum.photos/300/200?random=24",
    ],
  },
  {
    id: 3,
    name: "Luxury Nails",
    city: "Szeged",
    rating: 5.0,
    price: "8.000 - 15.000 Ft",
    images: [
      "https://picsum.photos/300/200?random=31",
      "https://picsum.photos/300/200?random=32",
      "https://picsum.photos/300/200?random=33",
      "https://picsum.photos/300/200?random=34",
    ],
  },
  {
    id: 4,
    name: "Diamond Nails",
    city: "Pécs",
    rating: 4.7,
    price: "5.500 - 11.500 Ft",
    images: [
      "https://picsum.photos/300/200?random=41",
      "https://picsum.photos/300/200?random=42",
      "https://picsum.photos/300/200?random=43",
      "https://picsum.photos/300/200?random=44",
    ],
  },
  {
    id: 5,
    name: "Lovely Nails",
    city: "Győr",
    rating: 4.6,
    price: "4.000 - 9.500 Ft",
    images: [
      "https://picsum.photos/300/200?random=51",
      "https://picsum.photos/300/200?random=52",
      "https://picsum.photos/300/200?random=53",
      "https://picsum.photos/300/200?random=54",
    ],
  },
  {
    id: 6,
    name: "Queen Nails",
    city: "Miskolc",
    rating: 4.9,
    price: "6.000 - 13.000 Ft",
    images: [
      "https://picsum.photos/300/200?random=61",
      "https://picsum.photos/300/200?random=62",
      "https://picsum.photos/300/200?random=63",
      "https://picsum.photos/300/200?random=64",
    ],
  },
]);
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