import api from "../api/axios";

export const createRating = async (payload) => {
    const response = await api.post("/ratings", payload);
    return response.data;
};