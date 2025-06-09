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
    <ul class="tags-inline">
        <TagItem v-for="tag in tags" :key="tag" :tag="tag" />
    </ul>
</template>