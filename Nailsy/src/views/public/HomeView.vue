<template>
  <Navbar></Navbar>
  <div class="app">
    <section id="home" class="hero">
      <h1>Üdv a Nailsy-nél 💅</h1>
      <button class="cta" @click="scrollToCategories">Felfedezés</button>
    </section>

    <section id="categories" class="section">
      <h2>Kategóriák</h2>
      <div class="grid">
        <div class="card">⭐ Értékelés szerint</div>
        <div class="card">📍 Helyszín szerint</div>
        <div class="card">💰 Ár szerint</div>
      </div>
    </section>

    <section id="nailtechs" class="section">
      <h2>Kiemelt körmösök</h2>

      <div class="grid">
        <div
            v-for="tech in nailTechs"
            :key="tech.name"
            class="card tech"
        >
          <h3>{{ tech.name }}</h3>
          <p>⭐ {{ tech.rating }} | {{ tech.city }}</p>
          <p>💰 {{ tech.price }}</p>
        </div>
      </div>
    </section>

    <footer class="footer">
      <p>© 2026 Nailsy - Minden jog fenntartva</p>
    </footer>
  </div>
</template>

<script setup>
import navbar from "@/components/Navbar.vue";
import { ref } from "vue";

const nailTechs = ref([
  {
    name: "Beauty Nails Studio",
    rating: 4.9,
    city: "Budapest",
    price: "5.000 - 12.000 Ft",
  },
  {
    name: "Pink Nails Art",
    rating: 4.7,
    city: "Debrecen",
    price: "4.000 - 10.000 Ft",
  },
  {
    name: "Luxury Nails",
    rating: 5.0,
    city: "Szeged",
    price: "8.000 - 15.000 Ft",
  },
]);

function scrollToCategories() {
  document.getElementById("categories")?.scrollIntoView({
    behavior: "smooth",
  });
}
</script>

<style scoped>
.app {
  font-family: Arial, sans-serif;
  background: #e6f7ff;
  color: #333;
}

.hero {
  text-align: center;
  padding: 80px 20px;
}

.cta {
  margin-top: 20px;
  padding: 10px 20px;
  border: none;
  background: #4fc3f7;
  color: white;
  border-radius: 8px;
  cursor: pointer;
}

.section {
  padding: 40px 20px;
  text-align: center;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 15px;
  margin-top: 20px;
}

.card {
  background: white;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.tech h3 {
  margin-bottom: 10px;
}

.footer {
  text-align: center;
  padding: 20px;
  background: #b3e5fc;
  margin-top: 40px;
}
</style>