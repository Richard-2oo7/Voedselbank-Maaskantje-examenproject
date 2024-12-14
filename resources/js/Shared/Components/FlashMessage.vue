<script setup>
import { onMounted, ref, watch, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

let message = ref(null);
let open = ref(false);

const props = defineProps({
    modelValue: String,
})

const emit = defineEmits(['update:modelValue']);
const page = usePage();

watch(() => props.modelValue, () => {
        open.value = true;

        setTimeout(() => {
            open.value = false;
            emit('update:modelValue', open.value);
        }, 2500);
        props.modelValue = null;
});

const close = () => {
    open.value = false;
    emit('update:modelValue', open.value);

};

const isVisible = computed(() => open.value && props.modelValue);
</script>

<template>
    <div 
        class="w-1/2 h-min bg-orange-200 mt-4 p-2 absolute top-0 left-1/2 transform -translate-x-1/2 flex justify-between items-center" 
        v-if="isVisible"
    >
        <p class="inline-block">
            {{ modelValue }}
        </p>
        <button @click="close" class="grid place-items-center hover:bg-white/50 p-3 rounded-full">
            <img src="/public/icons/exitIcon.svg" alt="icon">
        </button>
    </div>
</template>
