<template>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table
                class="min-w-full divide-y divide-gray-200 border border-gray-300"
            >
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">Description</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Priority</th>
                        <th class="px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="(item, index) in tasks" :key="index">
                        <td class="px-4 py-2">
                            {{ item.title }}
                        </td>
                        <td class="px-4 py-2">{{ item.description }}</td>
                        <td class="px-4 py-2">
                            <span
                                :class="[
                                    item.status === 'pending'
                                        ? 'bg-gray-100 text-gray-600'
                                        : '',
                                    item.status === 'in-progress'
                                        ? 'bg-amber-100 text-amber-600'
                                        : '',
                                    item.status === 'completed'
                                        ? 'bg-green-100 text-green-600'
                                        : '',
                                ]"
                                class="rounded px-2 py-1 text-xs ring-1"
                                >{{ item.status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <span
                                :class="[
                                    item.priority === 'low'
                                        ? 'bg-green-100 text-green-600'
                                        : '',
                                    item.priority === 'medium'
                                        ? 'bg-yellow-100 text-yellow-600'
                                        : '',
                                    item.priority === 'high'
                                        ? 'bg-red-100 text-red-600'
                                        : '',
                                ]"
                                class="rounded px-2 py-1 text-xs ring-1"
                                >{{ item.priority }}
                            </span>
                        </td>
                        <td class="px-4 py-2"></td>
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
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";

import { useTasksStore } from "../../../types/stores/user/taskManagement";

export default defineComponent({
    setup() {
        const tasksStore = useTasksStore();

        const tasks = computed(() => tasksStore.getTasks());
        const task = ref({});
        const currentPage = ref(tasksStore.getCurrentPage() || 1);
        const pagination = computed(() => tasksStore.getPagination());
        const perPage = ref(tasksStore.getPerPage() || 10);

        const updateList = async () => {
            await tasksStore.setTasks();
        };

        const goToPage = async (page) => {
            tasksStore.setCurrentPage(page);
        };

        onMounted(async () => {
            updateList();
        });

        const handleDeleteTask = () => {};

        return {
            tasks,
            task,
            currentPage,
            pagination,
            perPage,

            goToPage,
            handleDeleteTask,
        };
    },
});
</script>

<style scoped></style>
