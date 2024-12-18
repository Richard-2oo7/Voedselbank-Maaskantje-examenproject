<script setup>
    //props
    defineProps({
        title: {
            type: String,
            default: 'Scherm',
        },       
    })
</script>

<template>
    <div class="bg-white rounded-xl h-max w-max p-4 flex flex-col shadow-lgfo">
        <h1 class="text-2xl font-black">{{ title }}</h1>
        <slot/>
    </div>
</template>

