<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    tag: {
        type: String,
        required: true
    }
})
</script>

<template>
    <li>
        <Link :href="route('questions.tagged', tag)" class="tag">{{ tag }}</Link>
    </li>
</template>