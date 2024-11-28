<script setup>
    defineProps({
        foodPacks: Object
    });
</script>

<template>
    <Layout>
        <div>
            <h1>Voedselpakketten</h1>
        </div>
        <pre>{{ foodPacks }}</pre>
    </Layout>
</template>

