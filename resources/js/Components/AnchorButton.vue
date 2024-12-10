<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    }
});
</script>

<template>
    <Link :href="href" class="inline-flex items-center px-4 py-2 bg-cyan-500 border border-transparent rounded-md font-semibold text-xs text-white hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-0 transition ease-in-out duration-150">
        <slot />
    </Link>
</template>
