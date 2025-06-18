import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import { useAuthStore } from "../stores/authManagement";

import Register from "../../components/Register.vue";
import Login from "../../components/Login.vue";
import Home from "../../components/Home.vue";
import Dashboard from "../../components/admin/dashboard/Dashboard.vue";
import Tasks from "../../components/user/tasks/Tasks.vue";

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

    const isLoggedIn = !!auth.isAuthenticated;

    if (to.meta.requiresAuth && !isLoggedIn) {
        auth.clearUser();
        auth.clearToken();
        return next("/login");
    }

    if (isLoggedIn && auth.user.role === "admin" && to.path !== "/dashboard") {
        return next("/dashboard");
    }

    if (isLoggedIn && auth.user.role === "user" && to.path !== "/tasks") {
        return next("/tasks");
    }

    next();
});

export default router;
