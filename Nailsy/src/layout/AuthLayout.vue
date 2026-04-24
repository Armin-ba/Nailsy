<template>
  <div class="min-vh-100 bg-light">
    <Navbar />

    <main>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
</script>