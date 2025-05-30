import { defineStore } from "pinia";
import axios from "axios";

const baseUrl = import.meta.env.VITE_API_URL;

export const useUsersStore = defineStore("usersStore", {
    state: () => ({
        users: [],
        user: null,
        pagination: {
            current_page: 1,
            next_page_url: "",
            prev_page_url: "",
            per_page: 10,
            total_items: 0,
            total_pages: 0,
        },
    }),

    actions: {
        async getCsrf() {
            await axios.get("/sanctum/csrf-cookie");
        },

        async getUsers() {
            this.getCsrf();
            const response = await axios.get(`${baseUrl}/api/users`);
            this.users = response.data.data.user;

            return response;
        },

        async setPagination(pagination) {
            this.pagination = pagination;
        },

        async setCurrentPage(current_page) {
            this.pagination.current_page = current_page;
        },
    },

    getters: {
        isAuthenticated: (state): boolean => !!state.users,
    },
});
