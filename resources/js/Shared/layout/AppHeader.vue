<script setup>
    import AppNavLink from '../Components/AppNavLink.vue';
    import { onBeforeUnmount, onMounted, ref } from 'vue';

    defineProps({
        ingelogd: {
            type: Boolean,
            default: false,
        },

    });

    let open = ref(false);
    const toggle = () => {
        open.value = !open.value
    }

    const closeMenu = (e) => {
        if(!e.target.closest('.menu-container')){
            open.value = false
        }
    }
    //als het element op de pagina komt
    onMounted(() => {
        document.addEventListener('click', closeMenu);
    })

    //als het element van de pagina word verwijdert
    onBeforeUnmount(() => {
        document.removeEventListener('click', closeMenu);
    })

</script>
<template>
    <header class="w-full bg-orange-500 p-4 flex justify-between items-center">
        <h1 class="font-bold text-white text-2xl">Voedselbank Maaskantje</h1>


        <div class="flex flex-row gap-3" v-if="!$page.props.auth.user">
            <AppNavLink :active="$page.component.endsWith('Home')" href="/" :black="true">Home</AppNavLink>
            <AppNavLink :active="$page.component.endsWith('Aanmelden') " href="/aanmelden" :black="true">Als klant aanmelden</AppNavLink>
            <AppNavLink :active="$page.component.endsWith('Inloggen') " href="/inloggen" :black="true">Inloggen</AppNavLink>
        </div>

        <div class="menu-container relative" v-else>

            <div class="text-white font-semibold text-base flex items-center space-x-1 cursor-pointer" @click.stop="toggle">
                <p>{{ $page.props.auth.user.gebruikersnaam }}</p>
                <span>
                    <svg class="mt-[2px]" width="14" height="9" viewBox="0 0 14 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L7 7L13 1" stroke="white" stroke-width="2.5"/>
                    </svg>
                </span>
            </div>

            <div class="absolute z-10 bg-white h-max shadow-lg bottom-0 right-0 translate-y-full w-40 rounded overflow-hidden" :class="{'hidden': !open}">           
                <Link class="block px-3 py-2 hover:bg-black hover:text-white cursor-pointer w-full" href="#">Profiel</Link>
                <Link class="block px-3 py-2 hover:bg-black hover:text-white cursor-pointer w-full text-start" href="/uitloggen" method="post" as="button">Uitloggen</Link>
            </div>

        </div>

    </header>
</template>
