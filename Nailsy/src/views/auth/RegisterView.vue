<template>
  <div class="register-page">

    <div class="card">
      <h1>Regisztráció</h1>
      <p class="subtitle">Hozd létre a fiókodat</p>

      <form @submit.prevent="handleRegister">

        <input
            v-model="form.name"
            type="text"
            placeholder="Teljes név"
            required
        />

        <input
            v-model="form.email"
            type="email"
            placeholder="Email cím"
            required
        />

        <input
            v-model="form.password"
            type="password"
            placeholder="Jelszó"
            required
        />

        <button type="submit">
          Regisztráció
        </button>

      </form>

      <p class="login-link">
        Már van fiókod?
        <router-link :to="{ name: 'login' }">
          Jelentkezz be
        </router-link>
      </p>
    </div>

  </div>
</template>

<script setup>
import { reactive } from "vue"

const form = reactive({
  name: "",
  email: "",
  password: ""
})

const handleRegister = () => {
  console.log("REG:", form)

  // később:
  // API hívás
}
</script>

<style scoped>

/* PAGE */
.register-page {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 80vh;
}

/* CARD */
.card {
  background: white;
  padding: 30px;
  border-radius: 16px;
  width: 320px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.08);
  text-align: center;
}

/* TITLE */
h1 {
  color: #2b4c7e;
  margin-bottom: 5px;
}

.subtitle {
  color: #7a9cc6;
  margin-bottom: 20px;
  font-size: 14px;
}

/* INPUT */
input {
  width: 100%;
  padding: 12px;
  margin-bottom: 10px;
  border-radius: 10px;
  border: 1px solid #e6f0fa;
  outline: none;
}

input:focus {
  border-color: #74b9ff;
}

/* BUTTON */
button {
  width: 100%;
  padding: 12px;
  background: #74b9ff;
  color: white;
  border: none;
  border-radius: 10px;
  font-weight: bold;
  cursor: pointer;
  margin-top: 10px;
}

/* LINK */
.login-link {
  margin-top: 15px;
  font-size: 14px;
}

.login-link a {
  color: #74b9ff;
  text-decoration: none;
  font-weight: bold;
}

</style>