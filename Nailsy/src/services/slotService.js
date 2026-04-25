import api from "../api/axios";

export const getMySlots = async () => {
    const response = await api.get("/artist/slots");
    return response.data;
};

export const createSlot = async (payload) => {
    const response = await api.post("/artist/slots", payload);
    return response.data;
};

export const deleteSlot = async (id) => {
    const response = await api.delete(`/artist/slots/${id}`);
    return response.data;
};