<template>
  <div class="min-vh-100 d-flex flex-column">
    <Navbar />

    <main class="flex-grow-1">
      <router-view />
    </main>

    <footer class="bg-dark text-white py-4 mt-5">
      <div class="container">
        © 2026 Nailsy. Minden jog fenntartva.
      </div>
    </footer>
  </div>
</template>

<script setup>
import Navbar from "../components/Navbar.vue";
</script>