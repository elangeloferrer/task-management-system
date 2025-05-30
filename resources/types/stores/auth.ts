import { defineStore } from "pinia";
import axios from "axios";

interface RegistrationData {
    first_name: string;
    middle_name: string;
    last_name: string;
    username: string;
    password: string;
    password_confirmation: string;
}

interface Credentials {
    username: string;
    password: string;
}

const baseUrl = import.meta.env.VITE_API_URL;

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
    }),

    actions: {
        async getCsrf() {
            await axios.get("/sanctum/csrf-cookie");
        },

        async login(credentials: Credentials) {
            try {
                this.getCsrf();
                const response = await axios.post(
                    `${baseUrl}/api/login`,
                    credentials,
                );
                this.user = response.data.data.user;
                return response;
            } catch (e) {
                return e;
            }
        },

        async register(data: RegistrationData) {
            try {
                this.getCsrf();
                const response = await axios.post(
                    `${baseUrl}/api/register`,
                    data,
                );
                this.user = response.data.data.user;
                return response;
            } catch (e) {
                return e;
            }
        },

        async logout() {
            this.getCsrf();
            const response = await axios.post(`${baseUrl}/api/logout`);
            this.user = null;
            return response;
        },

        async getUser() {
            this.getCsrf();
            const response = await axios.get(`${baseUrl}/api/user`);
            this.user = response.data.data.user;
        },

        async setUser(user) {
            this.user = user;
        },

        async clearUser() {
            this.user = null;
        },
    },

    getters: {
        isAuthenticated: (state): boolean => !!state.user,
    },
});
