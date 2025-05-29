<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div
            class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 space-y-6"
        >
            <h2 class="text-2xl font-bold text-center text-gray-800">Login</h2>
            <form @submit.prevent="login" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Username</label
                    >
                    <input
                        type="text"
                        v-model="username"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5"
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
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2.5"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-xl transition duration-200"
                >
                    Login
                </button>
                <p class="text-sm text-center text-gray-500">
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

import { useAuthStore } from "../types/stores/auth";

import { showSuccessToast, showErrorToast } from "../types/utils/toast";

export default defineComponent({
    setup() {
        const router = useRouter();
        const auth = useAuthStore();

        const username = ref("");
        const password = ref("");

        const login = async () => {
            const res = await auth.login({
                username: username.value,
                password: password.value,
            });

            if (res.status === 200) {
                showSuccessToast(res.data.message); // to be fix

                console.log("auth.user login", auth.user);
                if (auth.user.role === "admin") {
                    router.push({ name: "home" });
                }

                if (auth.user.role === "user") {
                    router.push({ name: "tasks" });
                }
            }

            if (res.status === 401 && res.response?.data?.message) {
                showErrorToast(res.response?.data?.message);
            }
        };

        return {
            username,
            password,

            login,
        };
    },
});
</script>

<style scoped></style>
