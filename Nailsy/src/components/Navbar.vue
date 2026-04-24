<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
      <RouterLink class="navbar-brand fw-bold fs-3 brand-logo" to="/">
        <i class="bi bi-stars me-2"></i>
        Nailsy
      </RouterLink>

      <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#mainNavbar"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="mainNavbar" class="collapse navbar-collapse">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <RouterLink class="nav-link" to="/">Kezdőlap</RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/artists">Körmösök</RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/search">Keresés</RouterLink>
          </li>

          <li class="nav-item">
            <RouterLink class="nav-link" to="/contact">Kapcsolat</RouterLink>
          </li>
        </ul>

        <div class="d-flex gap-2">
          <RouterLink class="btn btn-outline-dark" to="/auth/login">
            Bejelentkezés
          </RouterLink>

          <RouterLink class="btn btn-dark" to="/auth/register">
            Regisztráció
          </RouterLink>
        </div>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.brand-logo {
  letter-spacing: 1px;
  font-family: Georgia, "Times New Roman", serif;
  color: #c15c8a;
}

.nav-link.router-link-active {
  font-weight: 600;
  color: #c15c8a;
}
</style>