<script>
export default {
  name: "PublicLayout"
}
</script>

<template>
  <div>

    <h2>Public Layout</h2>

    <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/artists">Artists</router-link> |
      <router-link to="/auth/login">Login</router-link>
    </nav>

    <router-view />

  </div>
</template>

<style scoped>

</style>