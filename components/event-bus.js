import { reactive } from 'vue';

const eventBus = reactive({
    markerPosition: null,
});

export default eventBus;