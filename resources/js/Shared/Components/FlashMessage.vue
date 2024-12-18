<script setup>
import { ref, watch, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

let open = ref(false);

const props = defineProps({
    modelValue: [String, Boolean],
})

const emit = defineEmits(['update:modelValue']);

watch(() => props.modelValue, (newValue) => {
    if(newValue){
        open.value = true;

        setTimeout(() => {
            open.value = false;
            emit('update:modelValue', null);
        }, 2500);
    }
});

const close = () => {
    open.value = false;
    emit('update:modelValue', null);
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
