import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import axios from "axios";
import { useAuthStore } from "../stores/auth";

import Register from "../../components/Register.vue";
import Login from "../../components/Login.vue";
import Home from "../../components/Home.vue";
import Dashboard from "../../components/Dashboard.vue";
import Tasks from "../../components/tasks/Tasks.vue";

const routes: RouteRecordRaw[] = [
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: { guestOnly: true },
    },
    {
        path: "/register",
        name: "register",
        component: Register,
        meta: { guestOnly: true },
    },
    {
        path: "/",
        name: "home",
        component: Home,
        meta: { requiresAuth: true },
        children: [
            {
                path: "/dashboard",
                name: "dashboard",
                component: Dashboard,
                meta: { requiresAuth: true },
            },
            {
                path: "/tasks",
                name: "tasks",
                component: Tasks,
                meta: { requiresAuth: true },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const auth = useAuthStore();
    const baseUrl = import.meta.env.VITE_API_URL;

    if (!auth.user) {
        try {
            const response = await axios.get(`${baseUrl}/api/user`);
            auth.setUser(response.data.data.user);
        } catch (err) {
            auth.clearUser();
        }
    }

    const isLoggedIn = !!auth.user;

    if (to.meta.requiresAuth && !isLoggedIn) {
        return next("/login");
    }

    if (isLoggedIn && auth.user.role === "admin" && to.path !== "/dashboard") {
        console.log("here");
        return next("/dashboard");
    }

    if (isLoggedIn && auth.user.role === "user" && to.path !== "/tasks") {
        return next("/tasks");
    }

    next();
});

export default router;
