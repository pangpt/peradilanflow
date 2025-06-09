<script setup>
import QuestionForm from './QuestionForm.vue'

const emit = defineEmits(['success'])

const props = defineProps({
    question: {
        type: Object,
        required: true
    },
    options: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <QuestionForm 
        :question="question" 
        :options="options"
        :action="route('questions.update', question.id)" 
        @success="emit('success')" 
        method="PUT"
    />
</template>