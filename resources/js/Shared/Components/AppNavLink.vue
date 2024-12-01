<script setup>
    //props
    const props = defineProps({
        active: {
            type: Boolean,
            default: false,
        },
        black: {
            type: Boolean,
            default: false,
        },
        
    })
    const UsedColor  = props.black ? '!bg-black !text-white' : '!bg-orange-500 !text-white';
</script>

<template>
    <Link
    class="bg-white text-black flex items-center rounded-full px-4 py-3"
     :class="active ? UsedColor : ''">
        <slot></slot>
    </Link>
</template>

