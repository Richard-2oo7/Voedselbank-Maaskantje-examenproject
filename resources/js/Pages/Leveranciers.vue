<script setup>
    defineProps({
        leveranciers: Object,
    });
</script>

<template>
    <Layout>
        <div>
            <h1>Leveranciers</h1>
            <pre>{{ leveranciers }}</pre>
        </div>
    </Layout>
</template>

