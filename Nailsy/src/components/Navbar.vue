<script>
export default {
  name: "Navbar"
}
</script>

<template>
  <header class="navbar">
    <div class="logo">Nailsy</div>

    <nav class="nav-links">
      <a href="#home">Home</a>
      <a href="#nailtechs">Körmösök</a>
      <a href="#categories">Kategóriák</a>
      <a href="#contact">Kapcsolat</a>
    </nav>
  </header>
</template>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
  background: #b3e5fc;
}

.logo {
  font-size: 24px;
  font-weight: bold;
  color: #01579b;
}

.nav-links a {
  margin-left: 15px;
  text-decoration: none;
  color: #01579b;
}
</style>