import api from "../api/axios";

export const uploadGalleryImage = async (formData) => {
    const response = await api.post("/artist/gallery", formData, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });

    return response.data;
};

export const deleteGalleryImage = async (id) => {
    const response = await api.delete(`/artist/gallery/${id}`);
    return response.data;
};