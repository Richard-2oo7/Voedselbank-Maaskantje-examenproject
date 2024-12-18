<script setup>
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import KlantVerzoekForm from '../Shared/Components/form/KlantVerzoekForm.vue';

    import AppTable from '../Shared/Components/Table.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    
    import PopUp from '../Shared/Components/PopUp.vue';
    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    
    import { ref, watch } from 'vue';
    
    defineProps({
        klantverzoeken: Object,
    })

    const params = route().params;
    const search = ref(params.search ?? '');    
    

    watch(search, () => {
        sendProductPageRequest(0, search);
        updateCheckBoxArr(props.clients.data);
    });


    const { popUpContent, open, showPopup } = makePopup();
    const handlePopUp = (title, component, purpose, values) => {
        showPopup(title, component, purpose, values);
    };
</script>

<template>
    <FlashMessage v-model="$page.props.flash.message"/>
    <PopUp :popUptitle="popUpContent.title" v-model="open">
        <KlantVerzoekForm :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></KlantVerzoekForm>
    </PopUp>

    <Layout>
        <div>
            <div class="h-min flex justify-end mb-3">
                <SearchInput v-model="search" :searchTerm="params.search"/>
            </div>
            <AppTable :heads="['Gezinsnaam','Postcode', 'Email', 'Telefoonnummer', 'Gezinssamenstelling']">
                <tr v-for="client in klantverzoeken.data" :key="client.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100" @click="handlePopUp('Klant verzoek', KlantVerzoekForm, 'make', {klant: client})">
                    <td>{{ client.gezinsnaam }}</td>
                    <td>{{ client.postcode }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.telefoonnummer }}</td>
                    <td>{{ client.volwassenen }}, {{ client.kinderen }}, {{ client.babys }}</td>
                    <td>
                        <svg class="mt-[2px]" width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L1 13" stroke="lightgray" stroke-width="2"></path>
                        </svg>
                    </td>
                </tr>
            </AppTable>
            <Pagination :links="klantverzoeken.links"/>   
        </div>
    </Layout>
</template>

