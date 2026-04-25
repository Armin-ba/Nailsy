import api from "../api/axios";

export const getMyServices = async () => {
    const response = await api.get("/artist/services");
    return response.data;
};

export const createService = async (payload) => {
    const response = await api.post("/artist/services", payload);
    return response.data;
};

export const deleteService = async (id) => {
    const response = await api.delete(`/artist/services/${id}`);
    return response.data;
};