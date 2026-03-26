<template>
  <div class="home">

    <!-- HERO -->
    <section class="hero">
      <div class="hero-content">
        <h1>Találd meg a kedvenc körmösöd</h1>
        <p>Foglalj időpontot gyorsan, egyszerűen</p>

        <div class="search">
          <input
              v-model="search"
              placeholder="Keresés név vagy város szerint..."
          />
          <button @click="goToSearch">
            Keresés
          </button>
        </div>
      </div>
    </section>

    <!-- FEATURED -->
    <section class="featured">
      <div class="section-header">
        <h2>Kiemelt körmösök</h2>

        <router-link :to="{ name: 'artists-public' }" class="all-link">
          Összes →
        </router-link>
      </div>

      <div class="grid">
        <div
            v-for="artist in featuredArtists"
            :key="artist.id"
            class="card"
        >
          <img :src="artist.image"/>

          <div class="info">
            <h3>{{ artist.name }}</h3>
            <p class="city">{{ artist.city }}</p>

            <div class="bottom">
              <span class="rating">⭐ {{ artist.rating }}</span>

              <router-link
                  :to="{ name: 'artist-public-details', params: { id: artist.id } }"
                  class="btn"
              >
                Megnézem
              </router-link>
            </div>
          </div>
        </div>
      </div>

    </section>

  </div>
</template>

<script setup>
import {ref} from "vue"
import {useRouter} from "vue-router"

const router = useRouter()
const search = ref("")

const goToSearch = () => {
  router.push({
    name: "artists-public",
    query: {q: search.value}
  })
}

const featuredArtists = [
  {
    id: 1,
    name: "Anna Nails",
    city: "Budapest",
    rating: 4.9,
    image: "https://via.placeholder.com/400x300"
  },
  {
    id: 2,
    name: "Crystal Studio",
    city: "Győr",
    rating: 4.8,
    image: "https://via.placeholder.com/400x300"
  },
  {
    id: 3,
    name: "Beauty Nails by Laura",
    city: "Debrecen",
    rating: 5.0,
    image: "https://via.placeholder.com/400x300"
  }
]
</script>

<style scoped>

/* BASE */
.home {
  background: #f7fbff;
  font-family: Arial, sans-serif;
}

/* HERO */
.hero {
  background: linear-gradient(135deg, #cfe9ff, #eaf6ff);
  padding: 100px 20px;
  display: flex;
  justify-content: center;
}

.hero-content {
  text-align: center;
  max-width: 600px;
}

.hero h1 {
  font-size: 38px;
  color: #2b4c7e;
  margin-bottom: 10px;
}

.hero p {
  color: #5f7fa6;
  margin-bottom: 25px;
}

/* SEARCH */
.search {
  display: flex;
  background: white;
  border-radius: 50px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.search input {
  flex: 1;
  padding: 14px;
  border: none;
  outline: none;
}

.search button {
  background: #74b9ff;
  color: white;
  border: none;
  padding: 0 20px;
  cursor: pointer;
  font-weight: bold;
}

/* FEATURED */
.featured {
  padding: 60px 20px;
}

/* HEADER */
.section-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 25px;
}

.all-link {
  color: #74b9ff;
  text-decoration: none;
  font-weight: bold;
}

/* GRID */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 20px;
}

/* CARD */
.card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  border: 1px solid #e6f0fa;
  transition: 0.2s;
}

.card:hover {
  transform: translateY(-5px);
}

/* IMAGE */
.card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

/* INFO */
.info {
  padding: 15px;
}

.city {
  color: #7a9cc6;
  font-size: 14px;
}

/* BOTTOM */
.bottom {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
}

.rating {
  color: #2b4c7e;
  font-weight: bold;
}

.btn {
  background: #74b9ff;
  color: white;
  padding: 6px 12px;
  border-radius: 8px;
  text-decoration: none;
  font-size: 14px;
}

</style>