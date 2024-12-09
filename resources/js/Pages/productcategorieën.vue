<script setup>
    defineProps({
        productCategorieën: Object
    })
</script>

<template>
    <Layout>
        <div>
            <h1>Productcategorieën</h1>
            <pre>{{ productCategorieën }}</pre>
        </div>
    </Layout>
</template>

