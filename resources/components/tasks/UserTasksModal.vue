<template>
    <modal @close-modal="closeModal">
        <div class="overflow-x-auto p-7">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2 font-semibold">Title</th>
                        <th class="px-4 py-2 font-semibold">Description</th>
                        <th class="px-4 py-2 font-semibold">Status</th>
                        <th class="px-4 py-2 font-semibold">Priority</th>
                        <th class="px-4 py-2 font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr v-for="(item, index) in userTasks" :key="index">
                        <td class="px-4 py-2">{{ item.title }}</td>
                        <td class="px-4 py-2">
                            {{ item.description }}
                        </td>
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
                                class="rounded px-2 py-1 text-xs"
                                >{{ item.priority }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Close Button at Bottom Right -->
        <div class="mt-4 flex justify-end">
            <button
                @click="closeModal()"
                class="absolute right-4 bottom-4 rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300"
            >
                Close
            </button>
        </div>
    </modal>
</template>

<script lang="ts">
import Modal from "../common/Modal.vue";

import { defineComponent, onMounted, ref } from "vue";

export default defineComponent({
    components: {
        Modal,
    },

    props: {
        user_tasks: {
            type: Array,
            required: true,
        },
    },

    emits: ["close-modal", "handle-delete-task"],

    setup(props, context) {
        const userTasks = ref(props.user_tasks);

        const closeModal = () => {
            context.emit("close-modal");
        };

        onMounted(() => {});

        return {
            userTasks,
            closeModal,
        };
    },
});
</script>
