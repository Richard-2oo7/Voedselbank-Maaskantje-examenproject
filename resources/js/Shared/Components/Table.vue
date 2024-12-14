<script setup>
    import CheckBox from './form/CheckBox.vue'
    defineProps({
        heads: Array,
    });
</script>

<template>
    <table class="w-full">
        <thead>
            <tr class="text-left font-bold">
                <th v-for="head in heads" :key="head">{{ head }}</th>
            </tr>
        </thead>
        <tbody>
            <slot/>
        </tbody>
    </table>
</template>