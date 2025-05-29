<template>
    <div class="min-h-screen bg-gray-100 text-gray-800">
        <main class="p-6">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const user = ref(null);

onMounted(async () => {
    try {
        const res = await axios.get("/api/user");
        user.value = res.data;
    } catch {
        user.value = null;
    }
});

const logout = async () => {
    await axios.post("/api/logout");
    user.value = null;
    window.location.href = "/login";
};
</script>
