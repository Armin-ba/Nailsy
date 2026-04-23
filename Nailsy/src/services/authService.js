import { defineStore } from "pinia";
import { login as apiLogin, logout as apiLogout } from "../services/authService";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null
    }),

    actions: {
        async login(email, password) {
            const res = await apiLogin(email, password);

            this.token = res.token;
            this.user = res.user;

            localStorage.setItem("token", res.token);
        },

        async logout() {
            await apiLogout();

            this.token = null;
            this.user = null;

            localStorage.removeItem("token");
        }
    }
});