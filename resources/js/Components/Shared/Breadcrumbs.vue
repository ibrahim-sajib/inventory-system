<script setup>
import { ChevronRightIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    list: { type: Array, required: true },
});
</script>

<template>
    <ol
        class="flex items-center whitespace-nowrap my-1 w-fit"
        aria-label="Breadcrumb"
    >
    <!-- :href="route(data.route)" -->
        <li v-for="data in list">
            <button
                v-if="data.route"
                class="flex items-center text-gray-700 gap-1 hover:text-gray-800"
            >
                <span>{{ data.label }}</span>
                <ChevronRightIcon class="h-4 w-4 text-blue-500 font-bold" />
            </button>
            <div v-else class="text-gray-600 ml-[2px] cursor-default">
                {{ data.label }}
            </div>
        </li>
    </ol>
</template>
