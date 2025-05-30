<template>
    <router-view />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "./types/stores/authManagement";

import Login from "./components/Login.vue";
import Dashboard from "./components/Dashboard.vue";

export default defineComponent({
    components: {
        Login,
        Dashboard,
    },

    setup() {
        const auth = useAuthStore();
        const router = useRouter();

        const isLogged = auth.user ? true : false;

        return {
            isLogged,
            router,
        };
    },
});
</script>
