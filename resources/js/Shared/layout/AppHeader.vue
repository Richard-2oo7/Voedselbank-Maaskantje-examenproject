<script setup>
    import AppNavLink from '../Components/AppNavLink.vue';
    defineProps({
        ingelogd: {
            type: Boolean,
            default: false,
        },

    });
</script>
<template>
    <header class="w-full bg-orange-500 px-2 py-4 flex justify-between">
        <div>
            <h1 class="font-bold text-white text-2xl">Voedselbank Maaskantje</h1>
        </div>
        <div class="flex flex-row gap-3">
            <AppNavLink :active="$page.component.endsWith('Home')" href="/" :black="true">Home</AppNavLink>
            <AppNavLink :active="$page.component.endsWith('Aanmelden') " href="/aanmelden" :black="true">Als klant aanmelden</AppNavLink>
            <AppNavLink :active="$page.component.endsWith('Inloggen') " href="/inloggen" :black="true">Inloggen</AppNavLink>
        </div>
    </header>
</template>
