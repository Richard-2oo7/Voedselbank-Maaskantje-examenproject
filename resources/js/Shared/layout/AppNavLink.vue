<script setup>
    //props
    defineProps({
        active: Boolean,
    })
</script>

<template>
    <Link
    class="bg-gray-100 text-black w-full h-full flex items-center rounded-full px-4 py-3"
    :class="{'bg-orange-500 text-white': active}">
        <slot></slot>
    </Link>
</template>

