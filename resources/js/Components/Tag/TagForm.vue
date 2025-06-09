<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    tag: {
        type: Object,
        required: true
    },
    method: String,
    action: {
        type: String,
        required: true
    }
})

const formData = {
    name: props.tag.name,
    description: props.tag.description,
    id: props.tag.id
}

if (props.method) {
    formData._method = props.method
}

const form = useForm(formData)

const emit = defineEmits(['success'])

const submit = () => {
    form.post(props.action, {
        onSuccess: () => {
            form.reset()
            emit('success')
        }
    })
}

</script>
<template>
    <form @submit.prevent="submit">
        <div class="mb-3">
            <label for="tag-name" class="form-label">Tag name</label>
            <input type="text" class="form-control" :class="{ 'is-invalid': form.errors.name }" v-model="form.name" name="name" id="tag-name">
            <div class="invalid-feedback" v-if="form.errors.name">{{ form.errors.name }}</div>
        </div>
        <div class="mb-3">
            <label for="tag-description" class="form-label">Tag description</label>
            <textarea class="form-control" rows="5" :class="{ 'is-invalid': form.errors.description }" v-model="form.description" name="description" id="tag-description"></textarea>
            <div class="invalid-feedback" v-if="form.errors.description">{{ form.errors.description }}</div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">{{ tag.id ? "Update" : "Save" }}</button>
        </div>
    </form>
</template>