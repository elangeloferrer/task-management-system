<template>
    <div class="flex min-h-screen flex-col">
        <!-- Navbar -->
        <nav
            class="flex items-center justify-between border-b border-gray-400 bg-white px-6 py-3 text-black"
        >
            <!-- Left Side -->
            <div class="flex items-center space-x-3">
                <h1 class="font-semibold">Task Management System</h1>
            </div>
        </nav>

        <div class="flex flex-1">
            <!-- Sidebar -->

            <aside
                :class="[
                    'flex flex-col justify-between border-r border-gray-400 bg-white p-4 shadow-md transition-[width] duration-100',
                    isSidebarOpen ? 'w-48' : 'w-16',
                ]"
            >
                <!-- Top Content -->
                <div>
                    <div
                        class="mb-4 flex items-center text-black hover:text-blue-400"
                    >
                        <button @click="toggleSidebar()" class="text-4xl">
                            <span v-if="isSidebarOpen">
                                <Icon icon="material-symbols:menu-open" />
                            </span>
                            <span v-else>
                                <Icon icon="material-symbols:menu" />
                            </span>
                        </button>
                    </div>
                    <div
                        v-if="isSidebarOpen"
                        class="text-left text-xl font-light text-gray-400"
                    ></div>
                    <ul class="gap-y-4">
                        <li
                            v-for="(item, index) in menuItems"
                            :key="index"
                            class="mt-4 mb-4 ml-4"
                        >
                            <router-link
                                :to="{ name: item.path }"
                                v-if="
                                    isSidebarOpen &&
                                    item.roles.includes(userRole)
                                "
                            >
                                <a
                                    href="#"
                                    class="flex items-center space-x-4 text-black hover:text-blue-400"
                                >
                                    <Icon :icon="item.icon" class="text-xl" />
                                    <span>{{ item.name }}</span>
                                </a>
                            </router-link>
                        </li>
                    </ul>
                </div>

                <!-- Bottom Logout Button -->
                <div class="flex items-center text-black hover:text-blue-400">
                    <button @click.prevent="logout" class="flex space-x-3">
                        <Icon icon="material-symbols:logout" class="text-xl" />
                        <span v-if="isSidebarOpen">Logout</span>
                    </button>
                </div>
            </aside>

            <!-- Main Content -->
            <div
                class="flex-1 overflow-auto bg-gray-100 p-4 shadow-md"
                style="max-height: calc(120vh - 10rem)"
            >
                <router-view></router-view>
            </div>
        </div>

        <!-- Footer -->
        <footer
            class="border-t border-gray-400 bg-white py-4 text-center text-black"
        >
            <p>
                &copy; {{ yearNow }} Task Management System. All rights
                reserved.
            </p>
        </footer>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useRouter } from "vue-router";

import { useAuthStore } from "../types/stores/authManagement";
import { useMoment } from "../types/utils/moment";

export default defineComponent({
    setup() {
        const auth = useAuthStore();
        const moment = useMoment();
        const router = useRouter();

        const isSidebarOpen = ref(false);
        const userRole = auth.user.role;
        const yearNow = moment().format("YYYY");

        const logout = async () => {
            const res = await auth.logout();

            if (res.status === 200) {
                window.location.href = "/login";
            }
        };

        const menuItems = ref([
            {
                name: "Dashboard",
                path: "dashboard",
                icon: "mingcute:cube-line",
                isOpen: false,
                isLink: true,
                children: [],
                roles: ["admin", "manager"],
            },
            {
                name: "Tasks",
                path: "tasks",
                icon: "fa-solid:tasks",
                isOpen: false,
                isLink: true,
                children: [],
                roles: ["user"],
            },
        ]);

        const toggleSidebar = () => {
            isSidebarOpen.value = !isSidebarOpen.value;
        };

        return {
            router,
            menuItems,
            isSidebarOpen,
            yearNow,
            userRole,

            toggleSidebar,
            logout,
        };
    },
});
</script>
