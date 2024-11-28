<script setup>
    defineProps({
        clients: Object,
    })
</script>

<template>
    <Layout>
        <div>
            <h1>Klanten</h1>
            <pre>
                {{ clients }}
            </pre>
        </div>
    </Layout>
</template>
