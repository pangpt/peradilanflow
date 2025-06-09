<script setup>
import TagForm from './TagForm.vue'

const emit = defineEmits(['success'])

const props = defineProps({
    tag: {
        type: Object,
        required: true
    }
})
</script>

<template>
    <TagForm :tag="tag" :action="route('tags.store')" @success="emit('success')" />
</template>