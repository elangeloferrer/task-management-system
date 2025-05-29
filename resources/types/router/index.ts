import { createRouter, createWebHistory } from "vue-router";
import Register from "../../views/Register.vue";
import Login from "../../views/Login.vue";
import Dashboard from "../../views/Dashboard.vue";
import axios from "axios";

const routes = [
    {
        path: "/login",
        name: "login",
        component: Login,
    },
    {
        path: "/register",
        name: "register",
        component: Register,
    },
    {
        path: "/",
        name: "dashboard",
        component: Dashboard,
        meta: { requiresAuth: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const publicPages = ["/login", "/register"];
    const authRequired = !publicPages.includes(to.path);

    try {
        const { data } = await axios.get("/api/user");

        if (!authRequired && data) {
            return next("/");
        }

        next();
    } catch (e) {
        if (authRequired) return next("/login");
        next();
    }
});

export default router;
