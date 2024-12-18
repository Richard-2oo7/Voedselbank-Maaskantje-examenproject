<script setup>
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import AppButton from '../Shared/Components/AppButton.vue';

    import AppTable from '../Shared/Components/Table.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    import deleteItems from '../Shared/Composables/DeleteItems.js'

    import VoedselpakketForm from '../Shared/Components/form/VoedselpakketForm.vue';
    import ShowVoedselpakket from '../Shared/Components/screens/ShowVoedselpakket.vue';

    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    import PopUp from '../Shared/Components/PopUp.vue';
    import formatDate from '../Shared/Composables/DateFormater.js';
    
    import { reactive, ref, watch } from 'vue';

    import { router } from '@inertiajs/vue3';
    const params = route().params;
    const search = ref(params.search ?? '');  

    const props = defineProps({
        voedselpakketten: Object,
        klanten: Object,
        producten: Object,
        geselecteerdeKlant: Object
    });

    const { sendProductPageRequest } = deleteItems('voedselpakketten', props.voedselpakketten);
    watch([search], () => {
        sendProductPageRequest(0, search);
    });

    const { popUpContent, open, showPopup } = makePopup();
    const handlePopUp = (title, component, purpose, values) => {
        showPopup(title, component, purpose, values);
    };

    const updateOpgehaald = (voedselpakket) => {
        if(voedselpakket && voedselpakket.opgehaald == 1) return false;

        router.patch('/voedselpakket/' + voedselpakket.id, {opgehaald: true})
    }

    let klanten = props.klanten;
    let producten = props.producten;
    let geselecteerdeKlant = props.geselecteerdeKlant;

    if(params.client_page){
        handlePopUp('Voedselpakket samenstellen', VoedselpakketForm, 'make', {klanten, producten, geselecteerdeKlant});
    }

    const voedselpakketSamenstellen = () => {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.delete('search');
    currentUrl.searchParams.set('client_page', '1');
    
    router.visit(currentUrl.toString());
        handlePopUp('Voedselpakket samenstellen', VoedselpakketForm, 'make', {klanten, producten, geselecteerdeKlant})
    }

</script>

<template>
    <FlashMessage v-model="$page.props.flash.message"/>
    <PopUp :popUptitle="popUpContent.title" v-model="open">
        <component :is="popUpContent.component" :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></component>
    </PopUp>
    <Layout>
        <div>
            <div class="h-min flex justify-between">

                <div class="flex space-x-1 mb-2">
                    <AppButton variant="small" @click.stop="voedselpakketSamenstellen()">Voedselpakket sammenstellen</AppButton>
                </div>

                <div class="flex justify-end">
                    <SearchInput v-model="search" :searchTerm="search"/>
                </div>

            </div>
            <AppTable :heads="['PakketNr','KlantNr', 'Gezinssamenstelling', 'Uitgiftedatum', 'Opgehaald', '']">
                <tr v-for="voedselpakket in voedselpakketten.data" 
                    :key="voedselpakket.id" 
                    class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100" 
                    @click="handlePopUp('Voedselpakket voor klant: #' + voedselpakket.client_id, ShowVoedselpakket, 'make', {voedselpakket})">

                    <td>{{ voedselpakket.id }}</td>
                    <td>{{ voedselpakket.client_id }}</td>
                    <td>{{ voedselpakket.client.volwassenen }}, {{ voedselpakket.client.kinderen }}, {{ voedselpakket.client.babys }}</td>
                    <td>{{ formatDate(voedselpakket.uitgiftedatum)}}</td>
                    <td>
                        <span 
                            @click.stop="updateOpgehaald(voedselpakket)"
                            v-html="voedselpakket.opgehaald ? 'opgehaald' : 'niet opgehaald'" 
                            class="px-2 rounded-full bg-red-400 flex items-center w-32 hover:bg-red-500 cursor-pointer" 
                            :class="{'!bg-green-400 !cursor-default' : voedselpakket.opgehaald, }">
                        </span>
                    </td>
                    <td>
                        <svg class="mt-[2px]" width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L1 13" stroke="lightgray" stroke-width="2"></path>
                        </svg>
                    </td>
                </tr>
            </AppTable>
            <Pagination :links="voedselpakketten.links"/>
        </div>
    </Layout>
</template>