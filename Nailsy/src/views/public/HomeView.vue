<template>
  <div>

    <h1>Nail Booking App - Home</h1>

    <nav>
      <router-link to="/artists">Körmösök Böngészése</router-link> |
      <router-link to="/auth/login">Login</router-link> |
      <router-link to="/auth/register">Register</router-link>
    </nav>

    <h2>Featured Nail Artists</h2>

    <div v-for="artist in featuredArtists" :key="artist.id">
      <router-link :to="'/artists/' + artist.id">
        {{ artist.name }}
      </router-link>
    </div>

  </div>
</template>

<script setup>

const featuredArtists = [
  { id: 1, name: "Anna Nails" },
  { id: 2, name: "Crystal Studio" },
  { id: 3, name: "Beauty Nails by Laura" }
]

</script>