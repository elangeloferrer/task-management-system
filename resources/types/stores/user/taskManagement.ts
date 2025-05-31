import { defineStore } from "pinia";
import axios from "axios";

import { loadTasks } from "../../api/tasks";

export const useTasksStore = defineStore("tasksStore", {
    state: () => ({
        tasks: [],
        task: null,
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

        getTasks() {
            return this.tasks;
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

        async setTasks() {
            let payload = {
                page: this.pagination.current_page,
                per_page: this.pagination.per_page,
            };
            const response: any = await loadTasks(payload);
            this.tasks = response.data.data.tasks;
            this.pagination = response.data.data.pagination;
        },

        async setCurrentPage(current_page) {
            this.pagination.current_page = current_page;
            this.setTasks();
        },
    },

    getters: {
        isAuthenticated: (state): boolean => !!state.tasks,
    },

    persist: true,
});
