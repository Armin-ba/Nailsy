<template>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
          <div class="card-body p-4">
            <h2 class="fw-bold mb-3">Regisztráció</h2>

            <div v-if="error" class="alert alert-danger">
              {{ error }}
            </div>

            <div v-if="success" class="alert alert-success">
              {{ success }}
            </div>

            <div class="mb-3">
              <label class="form-label">Név</label>
              <input v-model="form.name" type="text" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Email cím</label>
              <input v-model="form.email" type="email" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Jelszó</label>
              <input v-model="form.password" type="password" class="form-control" />
            </div>

            <div class="mb-3">
              <label class="form-label">Jelszó megerősítése</label>
              <input
                  v-model="form.password_confirmation"
                  type="password"
                  class="form-control"
              />
            </div>

            <div class="mb-3">
              <label class="form-label">Fiók típusa</label>
              <select v-model="form.role" class="form-select">
                <option value="user">Felhasználó</option>
                <option value="artist">Körmös</option>
              </select>
            </div>

            <div v-if="form.role === 'artist'" class="artist-box p-3 rounded-4 mb-3">
              <h5 class="fw-bold mb-3">
                <i class="bi bi-shop me-2"></i>
                Szalon adatai
              </h5>

              <div class="mb-3">
                <label class="form-label">Város</label>
                <input v-model="form.city" type="text" class="form-control" />
              </div>

              <div class="mb-3">
                <label class="form-label">Irányítószám</label>
                <input v-model="form.zip_code" type="text" class="form-control" />
              </div>

              <div class="mb-3">
                <label class="form-label">Utca</label>
                <input v-model="form.street" type="text" class="form-control" />
              </div>

              <div class="mb-3">
                <label class="form-label">Házszám</label>
                <input v-model="form.house_number" type="text" class="form-control" />
              </div>

              <div class="mb-0">
                <label class="form-label">Bemutatkozás</label>
                <textarea
                    v-model="form.description"
                    class="form-control"
                    rows="3"
                ></textarea>
              </div>

              <small class="text-muted d-block mt-2">
                A körmös profilod regisztráció után admin jóváhagyásra vár.
              </small>
            </div>

            <button
                class="btn btn-dark w-100"
                :disabled="loading"
                @click="handleRegister"
            >
              <span v-if="loading" class="spinner-border spinner-border-sm me-2"></span>
              Regisztráció
            </button>

            <p class="text-muted mt-3 mb-0">
              Már van fiókod?
              <RouterLink to="/auth/login">Bejelentkezés</RouterLink>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { register } from "../../services/authService";

const router = useRouter();

const loading = ref(false);
const error = ref("");
const success = ref("");

const form = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  role: "user",

  city: "",
  zip_code: "",
  street: "",
  house_number: "",
  description: "",
});

const handleRegister = async () => {
  error.value = "";
  success.value = "";
  loading.value = true;

  try {
    const payload = {
      name: form.name,
      email: form.email,
      password: form.password,
      password_confirmation: form.password_confirmation,
      role: form.role,
    };

    if (form.role === "artist") {
      payload.city = form.city;
      payload.zip_code = form.zip_code;
      payload.street = form.street;
      payload.house_number = form.house_number;
      payload.description = form.description;
    }

    await register(payload);

    success.value =
        form.role === "artist"
            ? "Sikeres körmös regisztráció. A profilod admin jóváhagyásra vár."
            : "Sikeres regisztráció. Most már bejelentkezhetsz.";

    setTimeout(() => {
      router.push("/auth/login");
    }, 1200);
  } catch (err) {
    if (err.response?.data?.errors) {
      const firstError = Object.values(err.response.data.errors)[0][0];
      error.value = firstError;
    } else {
      error.value = err.response?.data?.message || "Sikertelen regisztráció.";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.artist-box {
  background: #fff5f9;
  border: 1px solid #ffd6e7;
}
</style>