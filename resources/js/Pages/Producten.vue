<script setup>
    defineProps({
        product: Object,
    })
</script>

<template>
    <Layout>
        <div>
            <h1>Producten</h1>
            <pre>
                {{ product }}
            </pre>
        </div>
    </Layout>
</template>
