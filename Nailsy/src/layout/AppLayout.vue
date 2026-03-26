<template>
  <div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="logo">
        💅 NailBook
      </div>

      <nav class="menu">
        <router-link :to="{ name: 'artists' }">Körmösök</router-link>
        <router-link :to="{ name: 'my-bookings' }">Foglalásaim</router-link>

        <hr />

        <router-link :to="{ name: 'artist-dashboard' }">
          Dashboard
        </router-link>
        <router-link :to="{ name: 'artist-services' }">
          Szolgáltatások
        </router-link>
        <router-link :to="{ name: 'artist-schedule' }">
          Időbeosztás
        </router-link>

        <hr />

        <router-link :to="{ name: 'admin-users' }">Felhasználók</router-link>
        <router-link :to="{ name: 'admin-artists' }">Körmösök admin</router-link>
        <router-link :to="{ name: 'admin-reviews' }">Értékelések</router-link>
      </nav>
    </aside>

    <!-- MAIN -->
    <div class="main">

      <!-- TOPBAR -->
      <header class="topbar">
        <h3>Dashboard</h3>

        <div class="actions">
          <button class="logout">Kilépés</button>
        </div>
      </header>

      <!-- CONTENT -->
      <main class="content">
        <router-view />
      </main>

    </div>

  </div>
</template>

<script>
export default {
  name: "AppLayout"
}
</script>

<style scoped>

/* LAYOUT */
.layout {
  display: flex;
  height: 100vh;
  background: #f7fbff;
  font-family: Arial, sans-serif;
}

/* SIDEBAR */
.sidebar {
  width: 220px;
  background: white;
  border-right: 1px solid #e6f0fa;
  padding: 20px;
  display: flex;
  flex-direction: column;
}

/* LOGO */
.logo {
  font-weight: bold;
  font-size: 18px;
  color: #2b4c7e;
  margin-bottom: 20px;
}

/* MENU */
.menu {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.menu a {
  text-decoration: none;
  color: #2b4c7e;
  padding: 8px 10px;
  border-radius: 8px;
}

.menu a.router-link-active {
  background: #eaf6ff;
  color: #74b9ff;
}

/* DIVIDER */
hr {
  border: none;
  border-top: 1px solid #e6f0fa;
  margin: 15px 0;
}

/* MAIN */
.main {
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* TOPBAR */
.topbar {
  background: white;
  padding: 15px 20px;
  border-bottom: 1px solid #e6f0fa;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* BUTTON */
.logout {
  background: #74b9ff;
  color: white;
  border: none;
  padding: 6px 12px;
  border-radius: 8px;
  cursor: pointer;
}

/* CONTENT */
.content {
  padding: 20px;
  overflow-y: auto;
}

</style>