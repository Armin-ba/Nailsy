import api from "../api/axios";

export const createBooking = async (data) => {
    const res = await api.post("/bookings", data);
    return res.data;
};

export const getMyBookings = async () => {
    const res = await api.get("/bookings");
    return res.data;
};