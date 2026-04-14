<template>
  <div class="layout">

    <!-- NAVBAR -->
    <header class="navbar">
      <div class="logo">
        Nailsy
      </div>

      <nav class="nav-links">
        <router-link to="/">Kezdőlap</router-link>
        <router-link :to="{ name: 'artists-public' }">Körmösök</router-link>
      </nav>

      <div class="actions">
        <router-link :to="{ name: 'login' }" class="login">
          Bejelentkezés
        </router-link>

        <router-link :to="{ name: 'register' }" class="register">
          Regisztráció
        </router-link>
      </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="content">
      <router-view />
    </main>

    <!-- FOOTER -->
    <footer class="footer">
      <p>© 2026 Nailsy</p>
    </footer>

  </div>
</template>

<script>
export default {
  name: "PublicLayout"
}
</script>

<style>

/* LAYOUT */
.layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: #f7fbff;
  font-family: Arial, sans-serif;
}

/* NAVBAR */
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 30px;
  background: white;
  border-bottom: 1px solid #e6f0fa;
}

/* LOGO */
.logo {
  font-weight: bold;
  font-size: 20px;
  color: #2b4c7e;
}

/* LINKS */
.nav-links {
  display: flex;
  gap: 20px;
}

.nav-links a {
  text-decoration: none;
  color: #2b4c7e;
  font-weight: 500;
}

.nav-links a.router-link-active {
  color: #74b9ff;
}

/* ACTIONS */
.actions {
  display: flex;
  gap: 10px;
}

.login {
  color: #2b4c7e;
  text-decoration: none;
}

.register {
  background: #74b9ff;
  color: white;
  padding: 6px 12px;
  border-radius: 8px;
  text-decoration: none;
}

/* CONTENT */
.content {
  flex: 1;
}

/* FOOTER */
.footer {
  text-align: center;
  padding: 15px;
  background: white;
  border-top: 1px solid #e6f0fa;
  color: #7a9cc6;
  font-size: 14px;
}

</style>