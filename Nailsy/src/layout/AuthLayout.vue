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
      <router-link to="/auth/login">Login</router-link> |
      <router-link to="/auth/register">Register</router-link>
    </nav>

    <router-view />

  </div>
</template>

<style scoped>

</style>