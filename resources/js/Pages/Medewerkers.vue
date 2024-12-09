<script setup>
    defineProps({
        medewerkers: Object,
    })
</script>

<template>
    <Layout>
        <div>
            <h1>Medewerkers</h1>
            <pre>{{ medewerkers }}</pre>
        </div>
    </Layout>
</template>

