<script setup>
    import AppHeader from './AppHeader.vue';
</script>
<template>
    <div class="flex flex-col">
        <AppHeader/>
        <main class="h-full bg-[url('/public/images/background.png')] bg-cover relative">
            <slot></slot>
        </main>
    </div>
</template>