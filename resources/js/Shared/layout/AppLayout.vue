<template>
    <div class="min-h-screen flex flex-col">
        <AppHeader/>
        <div class="flex flex-1">
            <AppNav/>
            <div class="w-full bg-slate-300 p-4 h-auto">
                <div class="w-full h-full bg-white rounded-lg p-4">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    //components
    import AppHeader from './AppHeader.vue'
    import AppNav from './AppNav.vue'
</script>