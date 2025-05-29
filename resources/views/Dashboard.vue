<template>
    <div class="p-4">
        <h1 class="text-xl font-bold mb-4">Hello ! Dashboard</h1>
        <button @click="logout" class="btn">Logout</button>
    </div>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";

const router = useRouter();

const logout = async () => {
    await axios.post("/api/logout");
    router.push("/login");
};
</script>
