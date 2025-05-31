<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div
            class="w-full max-w-md space-y-6 rounded-2xl bg-white p-8 shadow-xl"
        >
            <h2 class="text-center text-2xl font-bold text-gray-800">Login</h2>
            <form @submit.prevent="login" class="space-y-4">
                <p class="pt-2 text-red-400">
                    {{ error }}
                </p>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Username</label
                    >
                    <input
                        type="text"
                        v-model="username"
                        class="mt-1 block w-full rounded-xl border border-gray-300 p-2.5 outline-none hover:border-blue-500 focus:border-blue-500"
                        required
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Password</label
                    >
                    <input
                        type="password"
                        v-model="password"
                        class="mt-1 block w-full rounded-xl border border-gray-300 p-2.5 outline-none hover:border-blue-500 focus:border-blue-500"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-2.5 font-semibold text-white transition duration-200 outline-none hover:bg-blue-700"
                >
                    Login
                </button>
                <p class="text-center text-sm text-gray-500">
                    Don't have an account?
                    <router-link
                        to="/register"
                        class="text-blue-600 hover:underline"
                        >Register</router-link
                    >
                </p>
            </form>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "../types/stores/authManagement";
import { useNotificationStore } from "../types/stores/notificationManagement";

export default defineComponent({
    setup() {
        const auth = useAuthStore();
        const notif = useNotificationStore();
        const router = useRouter();

        const username = ref("");
        const password = ref("");
        const error = ref("");

        const login = async () => {
            const res = await auth.login({
                username: username.value,
                password: password.value,
            });

            if (res.status === 200) {
                notif.setNotification({
                    type: "success",
                    message: "You have logged in!",
                    is_triggered: true,
                });

                if (auth.user.role === "admin") {
                    router.push({ name: "home" });
                }

                if (auth.user.role === "user") {
                    router.push({ name: "tasks" });
                }
            }

            if (res.status === 401 && res.response?.data?.message) {
                error.value = res.response?.data?.message;
            }
        };

        return {
            username,
            password,
            error,

            login,
        };
    },
});
</script>

<style scoped></style>
