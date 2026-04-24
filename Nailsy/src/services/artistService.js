import api from "../api/axios";

export const getApprovedArtists = async () => {
    const response = await api.get("/artists");
    return response.data;
};

export const searchArtists = async (filters) => {
    const response = await api.get("/artists/search", {
        params: filters,
    });
    return response.data;
};

export const getArtistById = async (id) => {
    const response = await api.get(`/artists/${id}`);
    return response.data;
};

export const getArtistServices = async (artistId) => {
    const response = await api.get(`/artists/${artistId}/services`);
    return response.data;
};

export const getArtistSlots = async (artistId) => {
    const response = await api.get(`/artists/${artistId}/slots`);
    return response.data;
};

export const getArtistRatings = async (artistId) => {
    const response = await api.get(`/artists/${artistId}/ratings`);
    return response.data;
};