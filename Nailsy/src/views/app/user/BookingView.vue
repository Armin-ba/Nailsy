<template>
  <div>
    <h2>Foglalás</h2>

    <input v-model="artistId" placeholder="Artist ID" />
    <input v-model="serviceId" placeholder="Service ID" />
    <input v-model="datetime" placeholder="YYYY-MM-DD HH:mm:ss" />

    <button @click="createBookingHandler">Foglalás</button>

    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { createBooking } from "../../../services/bookingService";

const artistId = ref("");
const serviceId = ref("");
const datetime = ref("");
const message = ref("");

const createBookingHandler = async () => {
  try {
    await createBooking({
      nail_artist_id: artistId.value,
      service_id: serviceId.value,
      booking_datetime: datetime.value
    });

    message.value = "Sikeres foglalás!";
  } catch (e) {
    message.value = e.response?.data?.error || "Hiba történt";
  }
};
</script>