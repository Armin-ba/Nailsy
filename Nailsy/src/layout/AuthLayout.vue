<script>
export default {
  name: "AuthLayout"
}
</script>

<template>
  <div>

    <h2>Auth Layout</h2>

    <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/auth/login">Bejelentkezés</router-link> |
      <router-link to="/auth/register">Regisztráció</router-link>
    </nav>

    <router-view />

  </div>
</template>

<style>

</style>