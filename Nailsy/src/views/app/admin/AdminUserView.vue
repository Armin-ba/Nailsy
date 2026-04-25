<template>
  <div class="container py-5">

    <h2 class="fw-bold mb-4">Felhasználók kezelése</h2>

    <table class="table">
      <thead>
      <tr>
        <th>ID</th>
        <th>Név</th>
        <th>Email</th>
        <th>Role</th>
        <th></th>
      </tr>
      </thead>

      <tbody>

      <tr v-for="user in users" :key="user.id">

        <td>{{ user.id }}</td>
        <td>{{ user.name }}</td>
        <td>{{ user.email }}</td>
        <td>{{ user.role }}</td>

        <td>
          <button
              class="btn btn-danger btn-sm"
              @click="deleteUser(user.id)"
          >
            Törlés
          </button>
        </td>

      </tr>

      </tbody>
    </table>

  </div>
</template>

<script setup>

import { onMounted,ref } from "vue"
import api from "../../../api/axios"

const users=ref([])

const loadUsers=async()=>{
  const res=await api.get("/admin/users")
  users.value=res.data
}

const deleteUser=async(id)=>{
  await api.delete(`/admin/users/${id}`)
  loadUsers()
}

onMounted(loadUsers)

</script>