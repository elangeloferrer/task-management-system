<template>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table
                class="min-w-full divide-y divide-gray-200 border border-gray-300"
            >
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Name</th>
                        <th class="px-4 py-2 text-left">Username</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Task Statistics</th>
                        <th class="px-4 py-2 text-left">Tasks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="(item, index) in users" :key="index">
                        <td class="px-4 py-2">
                            {{ item.last_name }}, {{ item.first_name }}
                            {{ item.middle_name }}
                        </td>
                        <td class="px-4 py-2">{{ item.username }}</td>
                        <td class="px-4 py-2">{{ item.email }}</td>
                        <td class="space-y-1 space-x-1 px-4 py-2">
                            <div
                                v-if="item.pending_tasks_count > 0"
                                class="group relative inline-block"
                            >
                                <span
                                    class="inline-flex items-center rounded-md bg-gray-100 px-3 py-1 text-sm font-medium text-gray-600 ring-1 ring-gray-500/10 ring-inset"
                                >
                                    {{ item.pending_tasks_count }}
                                </span>

                                <!-- Tooltip -->
                                <div
                                    class="absolute top-full left-1/2 z-10 mt-1 w-max -translate-x-1/2 rounded bg-black px-2 py-1 text-xs text-white opacity-0 transition-opacity group-hover:opacity-100"
                                >
                                    Pending tasks
                                </div>
                            </div>

                            <div
                                v-if="item.in_progress_tasks_count > 0"
                                class="group relative inline-block"
                            >
                                <span
                                    class="inline-flex items-center rounded-md bg-amber-100 px-3 py-1 text-sm font-medium text-amber-600 ring-1 ring-amber-500/10 ring-inset"
                                    >{{ item.in_progress_tasks_count }}
                                </span>

                                <!-- Tooltip -->
                                <div
                                    class="absolute top-full left-1/2 z-10 mt-1 w-max -translate-x-1/2 rounded bg-black px-2 py-1 text-xs text-white opacity-0 transition-opacity group-hover:opacity-100"
                                >
                                    In Progress
                                </div>
                            </div>

                            <div
                                v-if="item.completed_tasks_count"
                                class="group relative inline-block"
                            >
                                <span
                                    class="inline-flex items-center rounded-md bg-green-100 px-3 py-1 text-sm font-medium text-green-600 ring-1 ring-green-500/10 ring-inset"
                                    >{{ item.completed_tasks_count }}
                                </span>

                                <!-- Tooltip -->
                                <div
                                    class="absolute top-full left-1/2 z-10 mt-1 w-max -translate-x-1/2 rounded bg-black px-2 py-1 text-xs text-white opacity-0 transition-opacity group-hover:opacity-100"
                                >
                                    Completed
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-2">
                            <button
                                v-if="item.tasks.length > 0"
                                @click="showUserTasksModal(item, item.tasks)"
                                class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
                            >
                                <Icon icon="mdi:show" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div
                class="mt-4 flex items-center justify-center space-x-2"
                v-if="pagination"
            >
                <span class="text-md pt-2 text-gray-600">
                    Page {{ pagination.current_page }} of
                    {{ pagination.total_pages }}
                </span>

                <button
                    @click="goToPage(currentPage - 1)"
                    :disabled="!pagination.prev_page_url"
                    class="rounded border border-gray-800 px-2 py-1 text-sm text-gray-600 hover:bg-gray-300 disabled:bg-gray-400 disabled:text-white"
                >
                    <Icon icon="fa:angle-left" />
                </button>

                <button
                    v-for="page in pagination.total_pages"
                    :key="page"
                    @click="goToPage(page)"
                    class="rounded border border-gray-800 px-3 py-1 text-sm text-gray-600 hover:bg-gray-300 disabled:bg-gray-400 disabled:text-white"
                    :class="[
                        page === pagination.current_page
                            ? 'bg-blue-500 text-white'
                            : '',
                    ]"
                >
                    {{ page }}
                </button>

                <button
                    @click="goToPage(currentPage + 1)"
                    :disabled="!pagination.next_page_url"
                    class="rounded border border-gray-800 px-2 py-1 text-sm text-gray-600 hover:bg-gray-300 disabled:bg-gray-400 disabled:text-white"
                >
                    <Icon icon="fa:angle-right" />
                </button>
            </div>
        </div>

        <UserTasksModal
            v-if="isUserTaskModalVisible"
            @close-modal="hideUserTasksModal"
            @handle-delete-tasks="handleDeleteTask"
            :user_tasks="userTasks"
        />
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";
import { useUsersStore } from "../types/stores/userManagement";

import UserTasksModal from "./tasks/UserTasksModal.vue";
import { excludeKeys } from "../types/utils/excludeKeys";

export default defineComponent({
    components: {
        UserTasksModal,
    },

    setup() {
        const usersStore = useUsersStore();

        const users = computed(() => usersStore.getUsers());
        const user = ref({});
        const userTasks = ref([]);
        const currentPage = ref(usersStore.getCurrentPage() || 1);
        const pagination = computed(() => usersStore.getPagination());
        const perPage = ref(usersStore.getPerPage() || 10);
        const isUserTaskModalVisible = ref(false);

        const updateList = async () => {
            await usersStore.setUsers();
        };

        const goToPage = async (page) => {
            usersStore.setCurrentPage(page);
        };

        onMounted(async () => {
            updateList();
        });

        const showUserTasksModal = async (userInfo, tasks) => {
            user.value = excludeKeys(userInfo, ["tasks"]);
            userTasks.value = tasks;
            isUserTaskModalVisible.value = true;
        };

        const hideUserTasksModal = () => {
            userTasks.value = [];
            isUserTaskModalVisible.value = false;
        };

        const handleDeleteTask = () => {};

        return {
            users,
            userTasks,
            currentPage,
            pagination,
            perPage,
            isUserTaskModalVisible,

            goToPage,
            handleDeleteTask,
            hideUserTasksModal,
            showUserTasksModal,
        };
    },
});
</script>

<style scoped></style>
