<template>
    <h1 class="text-green-500">This is DASHBOARD</h1>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useUsersStore } from "../types/stores/users";

export default defineComponent({
    setup() {
        const usersStore = useUsersStore();

        const users = ref([]);
        const userTasks = ref([]);

        onMounted(async () => {
            const response = await usersStore.getUsers();

            console.log("response", response);
            // users.value = response.data;
        });

        const showTasks = async (userId) => {};

        return {
            users,
            userTasks,

            showTasks,
        };
    },
});
</script>

<style scoped></style>
