<template>

  <div class="container py-5">

    <h2 class="fw-bold mb-4">Reportolt kommentek</h2>

    <div
        v-for="report in reports"
        :key="report.id"
        class="card mb-3"
    >

      <div class="card-body">

        <p>{{ report.rating.comment }}</p>

        <button
            class="btn btn-danger btn-sm me-2"
            @click="deleteRating(report.rating.id)"
        >
          Komment törlése
        </button>

        <button
            class="btn btn-secondary btn-sm"
            @click="dismiss(report.id)"
        >
          Report elutasítása
        </button>

      </div>

    </div>

  </div>

</template>

<script setup>

import {ref,onMounted} from "vue"
import api from "../../../api/axios"

const reports=ref([])

const loadReports=async()=>{
  const res=await api.get("/admin/reports")
  reports.value=res.data
}

const deleteRating=async(id)=>{
  await api.delete(`/admin/ratings/${id}`)
  loadReports()
}

const dismiss=async(id)=>{
  await api.patch(`/admin/reports/${id}/dismiss`)
  loadReports()
}

onMounted(loadReports)

</script>