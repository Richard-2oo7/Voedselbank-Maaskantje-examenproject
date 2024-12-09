<script setup>
    defineProps({
        voedselpakketten: Object
    });
</script>

<template>
    <Layout>
        <div>
            <h1>Voedselpakketten</h1>
            <pre>{{ voedselpakketten }}</pre>
        </div>
    </Layout>
</template>

