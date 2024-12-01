<script setup>
    defineProps({
        disabled: {
            type: Boolean,
            default: false,
        }
    })
</script>

<template>
    <Button class="bg-orange-500 text-white flex items-center rounded-full px-4 py-3" :disabled="disabled" :class="{ ' opacity-50': disabled  }">
        <slot></slot>
    </Button>
</template>

