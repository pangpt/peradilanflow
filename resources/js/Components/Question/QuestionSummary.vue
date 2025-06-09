<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import ActionButtons from "../ActionButtons.vue";
import TagsInline from '../../Components/Tag/TagsInline.vue';

const props = defineProps({
    question: {
        type: Object,
        required: true
    }
})

const answerStatClasses = computed(() => ({
    'has-answers': props.question.answers_count,
    'has-accepted-answer': props.question.has_accepted_answer
}))

const emit = defineEmits(['edit', 'remove'])
</script>

<template>
    <li class="list-group-item">
        <div class="post-item question-summary">
            <div class="question-summary-stats">
                <div class="stats-item vote"><strong>{{ question.votes_count }}</strong> vote</div>
                <div class="stats-item status" :class="answerStatClasses">
                    <svg v-if="question.has_accepted_answer" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-check-lg" viewBox="0 0 16 16">
                        <path
                          d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                    </svg>
                    <strong>{{ question.answers_count }}</strong> answer
                </div>
                <div class="stats-item view">
                    {{ question.views_count }} views
                </div>
            </div>
            <div class="question-summary-content actionable">
                <div class="d-flex align-items-center">
                    <h3 class="mt-0 question-summary-title">
                        <Link :href="route('questions.show', question.slug)">{{ question.title }}</Link>
                    </h3>
                    <div class="ml-auto"></div>
                </div>
                <div class="excerpt">{{ question.summary }}</div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <TagsInline :tags="question.tags" />
                    <div class="question-summary-author">
                        <a href="#" class="avatar-sm">
                            <img :src="question.user.avatar_url" size="16" alt="" srcset="">
                            {{ question.user.name }}
                        </a> <span class="text-muted">asked <time :datetime="question.created_at.machine">{{ question.created_at.human }}</time></span>
                    </div>
                </div>
                <ActionButtons 
                    :allow-updated="question.can_be.updated"
                    :allow-deleted="question.can_be.deleted"
                    @edit="emit('edit', question)" @remove="emit('remove', question)" 
                />
            </div>
        </div>
    </li>
</template>