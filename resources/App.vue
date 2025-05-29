<template>
    <router-view />
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "./types/stores/auth";
import { useMoment } from "./types/utils/moment";

import Login from "./components/Login.vue";
import Dashboard from "./components/Dashboard.vue";

export default defineComponent({
    components: {
        Login,
        Dashboard,
    },

    setup() {
        const router = useRouter();
        const auth = useAuthStore();
        const moment = useMoment();

        const isLogged = auth.user ? true : false;

        onMounted(() => {
            console.log("isLogged onMounted", isLogged);
        });

        return {
            router,
            isLogged,
        };
    },
});
</script>
