<script setup>
    defineProps({
        klantverzoeken: Object,
    })
</script>

<template>
    <Layout>
        <div>
            <h1>Klantverzoeken</h1>
            <pre>{{ klantverzoeken }}</pre>
        </div>
    </Layout>
</template>

