<script setup>
    import AppLayout from '../Shared/layout/AppHeaderLayout.vue'
    import AppNavLink from '../Shared/Components/AppNavLink.vue'
    import FlashMessage from '../Shared/Components/FlashMessage.vue'
    defineOptions({
        layout: AppLayout,
    });
</script>
<template>
    <FlashMessage :message="$page.props.flash.message"/>
    <div class="grid grid-cols-2 place-items-center"> 
        <div class=" bg-white rounded-xl h-60 w-96 flex flex-col justify-around px-6 shadow-lg">
            <h1 class="text-orange-500 font-black text-2xl">Je bent welkom!</h1>
            <p>
                Wij zorgen voor gezond en gratis voedsel voor iedereen die extra hulp kan gebruiken.
            </p>
            <AppNavLink href="/aanmelden" :active="true" class="w-max">Als klant aanmelden</AppNavLink>
        </div>
    </div>
</template>