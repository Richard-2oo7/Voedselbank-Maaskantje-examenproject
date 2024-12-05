<script setup>
    //components
import { usePage } from '@inertiajs/vue3';
    import AppNavLink from '../Components/AppNavLink.vue'

    const links = [
        { component: 'Klanten', href: '/klanten' },
        { component: 'Klantverzoeken', href: '/klantverzoeken' },
        { component: 'Producten', href: '/producten' },
        { component: 'productcategorieën', href: '/productcategorieën' },
        { component: 'Voedselpakketten', href: '/voedselpakketten' },
        { component: 'Leveranciers', href: '/leveranciers' },
        { component: 'Medewerkers', href: '/medewerkers' },
    ]

    //welke rol welke paginas op mag
    const roleAccess = {
        vrijwilliger : [
            'Voedselpakketten',
        ],
        magazijnmedewerker : [
            'Producten', 'Leveranciers',
        ],
    }

    const user = usePage().props.auth.user.functie;
    //stuur de links terug
    const hasAcces = () => {
        if( user != 'directie' && roleAccess[user]){
            return links.filter(link =>  roleAccess[user].includes(link.component));
        } else{
            return links;
        }
    }
</script>

<template>
    <div class="bg-gray-200 p-4 h-auto w-80">
        <nav>
            <ul class="flex flex-col gap-4">
                <li v-for="link in hasAcces()" :key="link.component">
                    <AppNavLink :active="usePage().component.endsWith(link.component)" :href="link.href">{{ link.component }}</AppNavLink>
                </li>
            </ul>
        </nav>
    </div>
</template>
