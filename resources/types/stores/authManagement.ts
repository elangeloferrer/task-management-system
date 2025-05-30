import { defineStore } from "pinia";
import axios from "axios";

import { loadUser } from "../api/auth";

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

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: "",
    }),

    actions: {
        async getCsrf() {
            await axios.get("/sanctum/csrf-cookie");
        },

        async login(credentials: Credentials) {
            try {
                await this.getCsrf();
                const response = await axios.post(`/api/login`, credentials);
                this.setUser(response.data.data.user);
                this.setToken(response.data.data.token);
                return response;
            } catch (e) {
                return e;
            }
        },

        async register(data: RegistrationData) {
            try {
                await this.getCsrf();
                const response = await axios.post(`/api/register`, data);
                this.setUser(response.data.data.user);
                this.setToken(response.data.data.token);
                return response;
            } catch (e) {
                return e;
            }
        },

        async logout() {
            await this.getCsrf();
            const response = await axios.post(`/api/logout`);
            this.clearUser();
            this.clearToken();
            return response;
        },

        async getUser() {
            if (!this.user && this.token) {
                const response: any = await loadUser();
                this.setUser(response.data.data.user);
                this.setToken(response.data.data.token);
                console.log("response getUser", response);
            }
            return this.user;
        },

        async getToken() {
            console.log("getToken", this.token);
            return this.token;
        },

        async setUser(user) {
            this.user = user;
        },

        async clearUser() {
            this.user = null;
        },

        async setToken(token) {
            this.token = token;
        },

        async clearToken() {
            this.token = "";
        },
    },

    getters: {
        isAuthenticated: (state): boolean => !!state.user,
    },

    persist: true,
});
