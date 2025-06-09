<script setup>
import TagItem from './TagItem.vue';

defineProps({
    tags: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <ul class="tags-list mt-3">
        <TagItem v-for="tag in tags" :key="tag" :tag="tag" class="mb-1" />
    </ul>
</template>