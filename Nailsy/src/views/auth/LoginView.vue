<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-4">
            <h2 class="fw-bold mb-3">Bejelentkezés</h2>

            <div v-if="error" class="alert alert-danger">
              {{ error }}
            </div>

            <div class="mb-3">
              <label class="form-label">Email cím</label>
              <input
                  v-model="email"
                  type="email"
                  class="form-control"
                  placeholder="user@test.com"
              />
            </div>

            <div class="mb-3">
              <label class="form-label">Jelszó</label>
              <input
                  v-model="password"
                  type="password"
                  class="form-control"
                  placeholder="password"
              />
            </div>

            <button
                class="btn btn-dark w-100"
                :disabled="loading"
                @click="handleLogin"
            >
              <span
                  v-if="loading"
                  class="spinner-border spinner-border-sm me-2"
              ></span>
              Bejelentkezés
            </button>

            <p class="text-muted mt-3 mb-0">
              Még nincs fiókod?
              <RouterLink to="/auth/register">Regisztráció</RouterLink>
            </p>

            <hr />

            <small class="text-muted">
              Teszt user: <b>user@test.com</b> / <b>password</b>
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useAuthStore } from "../../stores/auth";

const router = useRouter();
const route = useRoute();
const auth = useAuthStore();

const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref("");

const handleLogin = async () => {
  error.value = "";
  loading.value = true;

  try {
    const user = await auth.login(email.value, password.value);

    const redirect = route.query.redirect;

    if (redirect) {
      router.push(redirect);
      return;
    }

    if (user.role === "admin") {
      router.push("/app/admin/artists");
    } else if (user.role === "artist") {
      router.push("/app/artist/dashboard");
    } else {
      router.push("/app/artists");
    }
  } catch (err) {
    error.value = err.response?.data?.message || "Sikertelen bejelentkezés.";
  } finally {
    loading.value = false;
  }
};
</script>