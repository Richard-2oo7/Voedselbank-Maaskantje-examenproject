<script setup>
    defineProps({
        disabled: Boolean,
        withIcon: Boolean,
        variant: {
            type: String,
            default: 'normal',
        }
    })
</script>

<template>
    <button class="bg-orange-500 text-white flex items-center rounded-full px-4 py-3" 
    :disabled="disabled" 
    :class="{ 'opacity-50': disabled, 
              '[&>img]:mr-1' : withIcon ?? false,
              'text-sm [&>img]:h-4' : variant ==  'small',
              }"
    >
        <slot></slot>
    </button>
</template>