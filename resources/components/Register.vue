<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
        <div
            class="w-full max-w-md space-y-6 rounded-2xl bg-white p-8 shadow-xl"
        >
            <h2 class="text-center text-2xl font-bold text-gray-800">
                Register
            </h2>
            <form @submit.prevent="register" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >First Name</label
                    >
                    <input
                        type="text"
                        v-model="firstName"
                        class="mt-1 block w-full rounded-xl border border-gray-300 p-2.5 outline-none hover:border-blue-500 focus:border-blue-500"
                        required
                    />
                    <ul v-if="errors.first_name" class="list-disc pt-2 pl-4">
                        <li
                            v-for="(item, index) in errors.first_name"
                            class="text-black"
                        >
                            <p class="text-red-400">
                                {{ item }}
                            </p>
                        </li>
                    </ul>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Middle Name</label
                    >
                    <input
                        type="text"
                        v-model="middleName"
                        class="mt-1 block w-full rounded-xl border border-gray-300 p-2.5 outline-none hover:border-blue-500 focus:border-blue-500"
                        required
                    />
                    <ul v-if="errors.middle_name" class="list-disc pt-2 pl-4">
                        <li
                            v-for="(item, index) in errors.middle_name"
                            class="text-black"
                        >
                            <p class="text-red-400">
                                {{ item }}
                            </p>
                        </li>
                    </ul>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Last Name</label
                    >
                    <input
                        type="text"
                        v-model="lastName"
                        class="mt-1 block w-full rounded-xl border border-gray-300 p-2.5 outline-none hover:border-blue-500 focus:border-blue-500"
                        required
                    />
                    <ul v-if="errors.last_name" class="list-disc pt-2 pl-4">
                        <li
                            v-for="(item, index) in errors.last_name"
                            class="text-black"
                        >
                            <p class="text-red-400">
                                {{ item }}
                            </p>
                        </li>
                    </ul>
                </div>
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
                    <ul v-if="errors.username" class="list-disc pt-2 pl-4">
                        <li
                            v-for="(item, index) in errors.username"
                            class="text-black"
                        >
                            <p class="text-red-400">
                                {{ item }}
                            </p>
                        </li>
                    </ul>
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
                    <ul v-if="errors.password" class="list-disc pt-2 pl-4">
                        <li
                            v-for="(item, index) in errors.password"
                            class="text-black"
                        >
                            <p class="text-red-400">
                                {{ item }}
                            </p>
                        </li>
                    </ul>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700"
                        >Confirm Password</label
                    >
                    <input
                        type="password"
                        v-model="passwordConfirmation"
                        class="mt-1 block w-full rounded-xl border border-gray-300 p-2.5 outline-none hover:border-blue-500 focus:border-blue-500"
                        required
                    />
                </div>
                <button
                    type="submit"
                    class="w-full rounded-xl bg-blue-600 py-2.5 font-semibold text-white transition duration-200 outline-none hover:bg-blue-700"
                >
                    Register
                </button>
                <p class="text-center text-sm text-gray-500">
                    Already have an account?
                    <router-link
                        to="/login"
                        class="text-blue-600 hover:underline"
                        >Login</router-link
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
import { showSuccessToast } from "../types/utils/toast";

export default defineComponent({
    setup() {
        const router = useRouter();
        const auth = useAuthStore();

        const firstName = ref("");
        const middleName = ref("");
        const lastName = ref("");
        const username = ref("");
        const password = ref("");
        const passwordConfirmation = ref("");
        const errors = ref({
            first_name: "",
            middle_name: "",
            last_name: "",
            username: "",
            password: "",
        });

        const register = async () => {
            const res = await auth.register({
                first_name: firstName.value,
                middle_name: middleName.value,
                last_name: lastName.value,
                username: username.value,
                password: password.value,
                password_confirmation: passwordConfirmation.value,
            });

            if (res.status === 201) {
                showSuccessToast(res.data.message);
                console.log("auth.user register", auth.user);
                if (auth.user.role === "user") {
                    console.log("push to tasks");
                    router.push({ name: "tasks" });
                }
            }

            if (res.status === 422 && res.response?.data?.errors) {
                errors.value = res.response?.data?.errors;
            }
        };

        return {
            firstName,
            middleName,
            lastName,
            username,
            password,
            passwordConfirmation,
            errors,

            register,
        };
    },
});
</script>
