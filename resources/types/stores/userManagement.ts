import { defineStore } from "pinia";
import axios from "axios";

import { loadUsers } from "../api/users";

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

        getUsers() {
            return this.users;
        },

        getPagination() {
            return this.pagination;
        },

        getCurrentPage() {
            return this.pagination.current_page;
        },

        getPerPage() {
            return this.pagination.per_page;
        },

        async setUsers() {
            let payload = {
                page: this.pagination.current_page,
                per_page: this.pagination.per_page,
            };
            const response: any = await loadUsers(payload);
            this.users = response.data.data.users;
            this.pagination = response.data.data.pagination;
        },

        async setCurrentPage(current_page) {
            this.pagination.current_page = current_page;
            this.setUsers();
        },
    },

    getters: {
        isAuthenticated: (state): boolean => !!state.users,
    },

    persist: true,
});
