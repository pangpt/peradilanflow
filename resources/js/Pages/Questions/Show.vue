<script setup>
import { Head, router } from "@inertiajs/vue3";
import AppLayout from '../../Layouts/AppLayout.vue'
import Author from '../../Components/Author.vue'
import Answers from '../../Components/Answer/Answers.vue';
import CreateAnswer from '../../Components/Answer/CreateAnswer.vue';
import Votable from "../../Components/Votable.vue";
import TagsInline from '../../Components/Tag/TagsInline.vue';
import TagsList from '../../Components/Tag/TagsList.vue';
import RelatedQuestions from '../../Components/Question/RelatedQuestions.vue';
import useVote from '../../Composables/useVote.js';

const props = defineProps({
    question: {
        type: Object,
        required: true
    },
    related_questions: {
        type: Array,
        required: true
    },
    answers: {
        type: Object,
        required: true
    },
    tags: {
        type: Array,
        required: true
    }
})

const bookmark = () => {
    if (props.question.is_bookmarked) {
        router.delete(route('questions.bookmark.destroy', props.question.id), {
            preserveScroll: true
        })
    } else {
        router.post(route('questions.bookmark.store', props.question.id), {}, {
            preserveScroll: true
        })
    }
}

const { upVote, downVote } = useVote(props.question, 'questions.vote')
</script>

<template>
    <Head :title="question.title" />
    
    <AppLayout>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="border-bottom pb-3 mb-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <h1 class="question-title">{{ question.title }}</h1>
                            <a href="index.html" class="btn btn-outline-secondary">All Questions</a>
                        </div>
                        <div class="d-flex question-meta">
                            <div class="me-3">
                                <span class="text-muted">Asked</span> <time :datetime="question.created_at.machine">{{ question.created_at.human }}</time>
                            </div>
                            <div class="me-3">
                                <span class="text-muted">Modified</span> {{ question.updated_at.human }}
                            </div>
                            <div>
                                <span class="text-muted">Viewed</span> {{ question.views_count }} times
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <Votable class="question-content" 
                        :votes="question.votes_count"
                        @up-vote="upVote"
                        @down-vote="downVote"
                    >
                        <div class="question-body" v-html="question.body">
                        </div>
                        <div class="d-flex justify-content-between align-items start py-3">
                            <TagsInline :tags="question.tags" />
                            <Author :post-at="question.created_at" :user="question.user" />
                        </div>
                        <template #extra>
                            <button title="Bookmark the post" class="btn text-secondary" @click="bookmark" :class="{ 'question-bookmarked': question.is_bookmarked }">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bookmark-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2" />
                                </svg>
                            </button>
                        </template>
                    </Votable>

                    <Answers :answers="answers" />

                    <CreateAnswer :question="question" />
                </div>
                <div class="col-md-3">
                    <h3 class="fs-5 mb-3">Related</h3>
                    <RelatedQuestions :questions="related_questions" />

                    <h3 class="fs-5 mt-5">Tags</h3>
                    <TagsList :tags="tags" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>