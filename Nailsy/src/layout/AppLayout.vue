<template>
  <div class="min-vh-100">
    <Navbar />

    <main>
      <router-view />
    </main>
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
</script>