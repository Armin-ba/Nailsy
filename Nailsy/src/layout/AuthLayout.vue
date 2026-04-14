<script>
export default {
  name: "AuthLayout"
}
</script>

<template>
  <div class="auth-layout">

    <div class="auth-left">
      <div class="brand">
        Nailsy
      </div>

      <h1>
        Időpontfoglalás <br />
        körmösökhöz egyszerűen
      </h1>

      <p>
        Foglalj időpontot, kezeld vendégeidet,
        építsd a saját körmös vállalkozásod.
      </p>
    </div>

    <div class="auth-right">

      <div class="auth-card">

        <nav class="auth-nav">
          <router-link to="/auth/login">
            Bejelentkezés
          </router-link>

          <router-link to="/auth/register">
            Regisztráció
          </router-link>
        </nav>

        <div class="auth-content">
          <router-view />
        </div>

      </div>

    </div>

  </div>
</template>

<style scoped>


.auth-layout {
  display: flex;
  height: 100vh;
  background: #f7fbff;
  font-family: Arial, sans-serif;
}



.auth-left {
  flex: 1;
  background: linear-gradient(135deg,#74b9ff,#2b4c7e);
  color: white;
  padding: 60px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.brand {
  font-size: 22px;
  font-weight: bold;
  margin-bottom: 20px;
}

.auth-left h1 {
  font-size: 32px;
  margin-bottom: 20px;
}

.auth-left p {
  opacity: 0.9;
  line-height: 1.6;
}



.auth-right {
  width: 450px;
  display: flex;
  justify-content: center;
  align-items: center;
}



.auth-card {
  width: 100%;
  background: white;
  padding: 30px;
  border-radius: 14px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}



.auth-nav {
  display: flex;
  gap: 20px;
  margin-bottom: 25px;
}

.auth-nav a {
  text-decoration: none;
  color: #2b4c7e;
  padding-bottom: 5px;
}

.auth-nav a.router-link-active {
  border-bottom: 2px solid #74b9ff;
  color: #74b9ff;
}


.auth-content {
  margin-top: 10px;
}

</style>
