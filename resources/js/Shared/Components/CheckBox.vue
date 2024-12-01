<script setup>
    defineProps({
        label: String,
        modelValue: Boolean,
    });
</script>

<template>
    <div v-if="label" class="flex items-center gap-2">
        <input 
            type="checkbox" 
            :id="label"
            class="w-5 h-5 bg-transparent border border-black rounded-md appearance-none relative peer checked:bg-orange-500"
            @change="$emit('update:modelValue', $event.target.checked)"
        />
        <Label v-if="label" :for="label">{{ label }}</Label>
    </div>

    <input 
        v-else
        type="checkbox" 
        :id="label"
        class="w-5 h-5 bg-transparent border border-black rounded-md appearance-none relative peer checked:bg-orange-500"
        @change="$emit('update:modelValue', $event.target.checked)"
    />
</template>