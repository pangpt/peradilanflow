import { computed, onMounted, reactive } from "vue";
import * as bootstrap from 'bootstrap';
import Modal from '../Components/Modal.vue';

export default (modalId, options = {}) => {
    const modal = reactive({
        ref: null,
        title: ""
    })

    onMounted(() => {
        modal.ref = new bootstrap.Modal(modalId, Object.assign(options, {
            backdrop: 'static',
            keyboard: false
        }))
    })
    
    const showModal = () => modal.ref.show();
    
    const hideModal = () => modal.ref.hide();

    const modalTitle = computed({
        get: () => modal.title,
        set: (title) => modal.title = title
    })

    return {
        showModal, hideModal, modalTitle, Modal
    }
}