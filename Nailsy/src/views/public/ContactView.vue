<template>
  <section class="py-5 bg-light min-vh-100">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 p-md-5">
              <h1 class="fw-bold mb-3">Kapcsolat</h1>

              <p class="text-muted mb-4">
                Kérdésed van a Nailsy használatával kapcsolatban? Írj nekünk,
                vagy keresd ügyfélszolgálatunkat az alábbi elérhetőségeken.
              </p>

              <div class="row g-4 mb-4">
                <div class="col-md-4">
                  <div class="contact-box">
                    <i class="bi bi-envelope fs-2 text-brand"></i>
                    <h5 class="fw-bold mt-2">Email</h5>
                    <p class="text-muted mb-0">info@nailsy.hu</p>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="contact-box">
                    <i class="bi bi-telephone fs-2 text-brand"></i>
                    <h5 class="fw-bold mt-2">Telefon</h5>
                    <p class="text-muted mb-0">+36 30 123 4567</p>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="contact-box">
                    <i class="bi bi-geo-alt fs-2 text-brand"></i>
                    <h5 class="fw-bold mt-2">Cím</h5>
                    <p class="text-muted mb-0">Budapest, Nailsy iroda</p>
                  </div>
                </div>
              </div>

              <hr />

              <h3 class="fw-bold mb-3">Üzenet küldése</h3>

              <div class="mb-3">
                <label class="form-label">Név</label>
                <input v-model="name" type="text" class="form-control" />
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input v-model="email" type="email" class="form-control" />
              </div>

              <div class="mb-3">
                <label class="form-label">Üzenet</label>
                <textarea v-model="message" class="form-control" rows="5"></textarea>
              </div>

              <button class="btn btn-dark" @click="sendMessage">
                Üzenet küldése
              </button>

              <div v-if="success" class="alert alert-success mt-3 mb-0">
                {{ success }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref } from "vue";

const name = ref("");
const email = ref("");
const message = ref("");
const success = ref("");

const sendMessage = () => {
  success.value = "Az üzenetküldés funkció később lesz bekötve.";
};
</script>

<style scoped>
.text-brand {
  color: #c15c8a;
}

.contact-box {
  background: #fff;
  border-radius: 18px;
  padding: 20px;
  height: 100%;
  text-align: center;
  border: 1px solid #f0f0f0;
}
</style>