<template>
    <AppLayout>
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div
                        class="d-flex align-items-center justify-content-between"
                    >
                        <h1 class="page-header" v-if="!tag.name">
                            All Questions
                        </h1>
                        <h1 class="page-header" v-else>
                            Questions tagged [{{ tag.name }}]
                        </h1>
                    </div>
                    <div class="py-2" v-if="tag.description">
                        {{ tag.description }}
                    </div>
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <QuestionSummary
                                v-for="question in questions.data"
                                :key="question.id"
                                :question="question"
                                @edit="editQuestion"
                                @remove="removeQuestion"
                            />
                        </ul>
                    </div>

                    <Pagination :meta="questions.meta" />
                </div>
                <div class="col-md-3">
                    <div class="d-grid">
                        <button class="btn btn-primary" @click="askQuestion">
                            Ask Question
                        </button>
                    </div>

                    <QuestionFilter :filter="filter" />
                    <h2 class="fs-5 mt-5">Related Tags</h2>
                    <TagsList :tags="tags" />
                </div>
            </div>
        </div>
        <Modal
            id="question-modal"
            :title="modalTitle"
            size="extra-large"
            scrollable
            @hidden="editing = false"
        >
            <component
                :is="editing ? EditQuestionForm : CreateQuestionForm"
                :question="question"
                :options="tag_options"
                @success="hideModal"
            />
        </Modal>
    </AppLayout>
    <!-- <h1>Welcome!</h1>

    <div v-for="question in questions" :key="question.id">
        <Link :href="route('questions.show', question.id)">
            {{ question.title }}
        </Link>
    </div> -->

    <Head title="All Questions" />
</template>

<script setup>
import { reactive, ref } from "vue";
import { Head, router } from "@inertiajs/vue3";
import AppLayout from "../../Layouts/AppLayout.vue";
import QuestionSummary from "../../Components/Question/QuestionSummary.vue";
import Pagination from "../../Components/Pagination.vue";
import CreateQuestionForm from "../../Components/Question/CreateQuestionForm.vue";
import EditQuestionForm from "../../Components/Question/EditQuestionForm.vue";
import QuestionFilter from "../../Components/Question/QuestionFilter.vue";
import TagsList from "../../Components/Tag/TagsList.vue";
import useModal from "../../Composables/useModal";

const { showModal, hideModal, modalTitle, Modal } = useModal("#question-modal");

defineProps({
    questions: {
        type: Object,
        required: true,
    },
    tag: {
        type: Object,
        default: () => ({}),
    },
    tags: {
        type: Array,
        required: true,
    },
    tag_options: {
        type: Array,
        default: () => [],
    },
    filter: String,
});

const question = reactive({
    id: null,
    title: null,
    body: null,
    tags: [],
});

const editing = ref(false);

const editQuestion = (payload) => {
    editing.value = true;
    modalTitle.value = "Edit Question";

    question.id = payload.id;
    question.title = payload.title;
    question.body = payload.body;
    question.tags = payload.tags;

    showModal();
};

const askQuestion = () => {
    editing.value = false;
    modalTitle.value = "Ask Question";
    showModal();
};

const removeQuestion = (payload) => {
    if (confirm("Are you sure?")) {
        router.delete(route("questions.destroy", payload.id), {
            preserveScroll: true,
        });
    }
};
</script>
