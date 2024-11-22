<template>
    <div class="bg-gray-200 p-4 h-auto w-80">
        <nav>
            <ul class="flex flex-col gap-4">
                <li><AppNavLink :active="$page.component == 'Klanten'" href="/">Klanten</AppNavLink></li>
                <!-- <li><AppNavLink :active="$page.component == 'Klanten'" href="/klanten">Klanten</AppNavLink></li> -->
                <li><AppNavLink :active="$page.component == 'Klantverzoeken'" href="/klantverzoeken">Klantverzoeken</AppNavLink></li>
                <li><AppNavLink :active="$page.component == 'Producten'" href="/producten">Producten</AppNavLink></li>
                <li><AppNavLink :active="$page.component == 'productcategorieën'" href="/productcategorieën">Productcategorieën</AppNavLink></li>
                <li><AppNavLink :active="$page.component == 'Voedselpakketten'" href="/voedselpakketten">Voedselpakketten</AppNavLink></li>
                <li><AppNavLink :active="$page.component == 'Leveranciers'" href="/leveranciers">Leveranciers</AppNavLink></li>
                <li><AppNavLink :active="$page.component == 'Medewerkers'" href="/medewerkers">Medewerkers</AppNavLink></li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
    //components
    import AppNavLink from './AppNavLink.vue'
</script>