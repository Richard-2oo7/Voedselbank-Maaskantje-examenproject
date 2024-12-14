<script setup>
    //props
    defineProps({
        type: {
            type: String,
            default: 'text',
        },
        required: {
            type: Boolean,
            default: true,
        },
        label: String,
        error: String,
        modelValue: String,  // Dit is de prop die v-model doorgeeft
    })
</script>

<template>
<div class="h-min">
    <div class="relative z-0 h-min">
        <input 
            :type="type" 
            class="block py-2.5 px-0 w-full text-sm text-black bg-transparent border-0 border-b border-black appearance-none focus:outline-none focus:ring-0 peer" 
            placeholder=""
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            >
            <!-- :required="required" -->
        <label 
            class="absolute text-sm duration-300 transform -translate-y-6 scale-80 top-3 -z-10 origin-[0] peer-focus:start-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-80 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
            <span class="text-orange-500" v-if="required">*</span>
            {{ label }}
        </label>
    </div>
    <!-- error -->
    <p class="mt-2 text-xs text-red-500">{{ error }}</p>
</div>
</template>

