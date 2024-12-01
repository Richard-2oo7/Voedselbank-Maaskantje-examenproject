<script setup>
    //components
    import AppNavLink from '../Components/AppNavLink.vue'
</script>

<template>
    <div class="bg-gray-200 p-4 h-auto w-80">
        <nav>
            <ul class="flex flex-col gap-4">
                <li><AppNavLink :active="$page.component.endsWith('Klanten')" href="/klanten">Klanten</AppNavLink></li>
                <li><AppNavLink :active="$page.component.endsWith('Klantverzoeken')" href="/klantverzoeken">Klantverzoeken</AppNavLink></li>
                <li><AppNavLink :active="$page.component.endsWith('Producten')" href="/producten">Producten</AppNavLink></li>
                <li><AppNavLink :active="$page.component.endsWith('productcategorieën')" href="/productcategorieën">Productcategorieën</AppNavLink></li>
                <li><AppNavLink :active="$page.component.endsWith('Voedselpakketten')" href="/voedselpakketten">Voedselpakketten</AppNavLink></li>
                <li><AppNavLink :active="$page.component.endsWith('Leveranciers')" href="/leveranciers">Leveranciers</AppNavLink></li>
                <li><AppNavLink :active="$page.component.endsWith('Medewerkers')" href="/medewerkers">Medewerkers</AppNavLink></li>
            </ul>
        </nav>
    </div>
</template>
