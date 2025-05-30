<template>
    <div
        @keyup.esc="$emit('close-modal')"
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600/50 p-7"
    >
        <div
            class="relative h-[90%] w-[90%] overflow-y-auto rounded-lg bg-white p-6 shadow-lg"
        >
            <!-- Close Button -->
            <button
                @click="$emit('close-modal')"
                class="absolute top-4 right-4 text-gray-500 transition hover:text-gray-700"
            >
                <Icon
                    icon="mdi:close"
                    class="text-xl hover:text-gray-300"
                ></Icon>
            </button>

            <!-- Modal Content -->
            <slot></slot>
        </div>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
    emits: ["close-modal"],

    setup() {},
});
</script>
