<script setup>
    import { ref } from 'vue';

    defineProps({
        message: String,
    })
    let closed = ref(false);
    const close = () => {
        closed.value = true;
    }
</script>
<template>
    <div class="w-1/2 h-min bg-orange-200 mt-4 p-2 absolute top-0 left-1/2 transform -translate-x-1/2 flex justify-between items-center" v-if="!closed && message">
        <p class="inline-block">
            {{ message }}
        </p>
        <button @click="close" class="grid place-items-center hover:bg-white/50 p-3 rounded-full">
            <img src="/public/icons/exitIcon.svg" alt="icon">
        </button>
    </div>
</template>