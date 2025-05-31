<template>
    <router-view />
</template>

<script lang="ts">
import { defineComponent, onMounted, watch, nextTick } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "./types/stores/authManagement";
import { useNotificationStore } from "./types/stores/notificationManagement";

import { showSuccessToast, showErrorToast } from "./types/utils/toast";

import Login from "./components/Login.vue";
import Dashboard from "./components/admin/dashboard/Dashboard.vue";

export default defineComponent({
    components: {
        Login,
        Dashboard,
    },

    setup() {
        const auth = useAuthStore();
        const notif = useNotificationStore();
        const router = useRouter();

        const isLogged = auth.user ? true : false;

        onMounted(() => {
            watch(
                () => notif.latest_notif,
                (val) => {
                    if (val?.is_triggered) {
                        setTimeout(() => {
                            nextTick(() => {
                                if (val.type === "success") {
                                    showSuccessToast(val.message);
                                } else if (val.type === "error") {
                                    showErrorToast(val.message);
                                }

                                notif.clearNotification();
                            });
                        }, 300);
                    }
                },
                { immediate: true },
            );
        });

        return {
            isLogged,
            router,
        };
    },
});
</script>
