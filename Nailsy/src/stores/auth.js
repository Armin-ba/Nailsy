import { defineStore } from "pinia";
import {
    login as apiLogin,
    logout as apiLogout,
    me,
} from "../services/authService";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        token: localStorage.getItem("token"),
        user: JSON.parse(localStorage.getItem("user") || "null"),
    }),

    getters: {
        isLoggedIn: (state) => !!state.token,
        isUser: (state) => state.user?.role === "user",
        isArtist: (state) => state.user?.role === "artist",
        isAdmin: (state) => state.user?.role === "admin",
    },

    actions: {
        async login(email, password) {
            const data = await apiLogin({ email, password });

            this.token = data.token;
            this.user = data.user;

            localStorage.setItem("token", data.token);
            localStorage.setItem("user", JSON.stringify(data.user));

            return data.user;
        },

        async fetchUser() {
            const user = await me();

            this.user = user;
            localStorage.setItem("user", JSON.stringify(user));

            return user;
        },

        async logout() {
            try {
                await apiLogout();
            } catch (e) {
                console.error(e);
            }

            this.token = null;
            this.user = null;

            localStorage.removeItem("token");
            localStorage.removeItem("user");
        },
    },
});