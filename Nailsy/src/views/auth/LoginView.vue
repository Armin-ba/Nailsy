<template>
  <div class="login-page">

    <div class="card">
      <h1>Bejelentkezés</h1>
      <p class="subtitle">Üdv újra</p>

      <form @submit.prevent="handleLogin">

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
          Bejelentkezés
        </button>

      </form>

      <p class="register-link">
        Nincs még fiókod?
        <router-link :to="{ name: 'register' }">
          Regisztrálj
        </router-link>
      </p>
    </div>

  </div>
</template>

<script setup>
import { reactive } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()

const form = reactive({
  email: "",
  password: ""
})

const handleLogin = () => {
  console.log("LOGIN:", form)

  // később:
  // auth API

  // demo redirect:
  router.push("/app")
}
</script>

<style scoped>

/* PAGE */
.login-page {
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
.register-link {
  margin-top: 15px;
  font-size: 14px;
}

.register-link a {
  color: #74b9ff;
  text-decoration: none;
  font-weight: bold;
}

</style>