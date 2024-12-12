<script setup>
    defineProps({
        model: String,
        modelValue: String,
    }); 
</script>

<template>
    <div class="relative">

      <input type="text" 
             class="border border-black p-2 pr-10 rounded-full w-full" 
             placeholder="Zoeken"
             @input="$emit('update:modelValue', $event.target.value)"
             :value="modelValue"
             >
  
      <svg class="absolute right-3 top-1/2 transform -translate-y-1/2" 
           width="16" 
           height="16" 
           viewBox="0 0 16 16" 
           fill="none" 
           xmlns="http://www.w3.org/2000/svg">
        <path d="M15.5 15.5L11.875 11.875M13.8333 7.16667C13.8333 10.8486 10.8486 13.8333 7.16667 13.8333C3.48477 13.8333 0.5 10.8486 0.5 7.16667C0.5 3.48477 3.48477 0.5 7.16667 0.5C10.8486 0.5 13.8333 3.48477 13.8333 7.16667Z" stroke="black" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>

    </div>
  </template>
  
  