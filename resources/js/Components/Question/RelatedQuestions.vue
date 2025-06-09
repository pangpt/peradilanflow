<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    questions: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <div class="related">
        <div class="related-item" v-for="question in questions" :key="question.id">
            <Link :href="route('questions.show', question.slug)">
                <div class="answer-votes" :class="{ 'answer-accepted': question.answer_accepted }">{{ question.votes_count }}</div>
            </Link>
            <Link :href="route('questions.show', question.slug)">
                {{ question.title }}
            </Link>
        </div>
    </div>
</template>