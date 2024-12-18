<script setup>
    import AppButton from '../Shared/Components/AppButton.vue';
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import CheckBox from '../Shared/Components/form/CheckBox.vue';
    import IconButton from '../Shared/Components/IconButton.vue';

    import AppTable from '../Shared/Components/Table.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    
    import PopUp from '../Shared/Components/PopUp.vue';
    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    
    import KlantForm from '../Shared/Components/form/KlantForm.vue';
    import deleteItems from '../Shared/Composables/DeleteItems.js';

    import { ref, watch } from 'vue';
    
    const props = defineProps({
        clients: Object,
    })

    const params = route().params;
    const search = ref(params.search ?? '');    
    
    const { checkBoxArr,
        updateCheckBoxArr,
        sendProductPageRequest,
        checkedItems,
        deleteCheckedItems, } = deleteItems('klanten', props.clients);
        
        updateCheckBoxArr(props.clients.data);

    watch(search, () => {
        sendProductPageRequest(0, search);
        updateCheckBoxArr(props.clients.data);
    });

    watch(() => props.clients.data, (newData) => {
        updateCheckBoxArr(newData);
    });

    const { popUpContent, open, showPopup } = makePopup();
    const handlePopUp = (title, component, purpose, values) => {
        showPopup(title, component, purpose, values);
    };
</script>

<template>
    <FlashMessage v-model="$page.props.flash.message"/>
    <PopUp :popUptitle="popUpContent.title" v-model="open">
        <KlantForm :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></KlantForm>
    </PopUp>

    <Layout>
        <div>
            <div class="h-min flex justify-between">

                <div class="flex space-x-1 mb-2">
                    <AppButton variant="small" @click="handlePopUp('Klant toevoegen', ProductForm, 'make', {sentmail: false})">Nieuwe klant toevoegen</AppButton>
                    <AppButton variant="small" :withIcon="true" :disabled="!checkedItems() .length" @click="deleteCheckedItems(() => sendProductPageRequest(search))">
                        <img src="/public/Icons/DeleteIcon.svg" alt="icon">Verwijderen
                    </AppButton>
                </div>

                <div class="space-x-1 flex">
                    <SearchInput v-model="search" :searchTerm="params.search"/>
                </div>

            </div>
            <AppTable :heads="['','KlantNr', 'Gezinsnaam', 'Postcode', 'Email', 'Telefoonnummer', 'Gezinsssamenstelling']">
                <tr v-for="client in clients.data" :key="client.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100">
                    <td class="space-x-2 flex items-center">
                        <CheckBox v-model="checkBoxArr[client.id].checked"/>
                        <IconButton @click="handlePopUp('Bewerk klant', KlantForm, 'edit', {klant: client})">
                            <img src="/public/icons/editIcon.svg" alt="icon">
                        </IconButton>
                    </td>
                    <td>{{ client.id }}</td>
                    <td>{{ client.gezinsnaam }}</td>
                    <td>{{ client.postcode }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.telefoonnummer }}</td>
                    <td>{{ client.volwassenen }}, {{ client.kinderen }}, {{ client.babys }}</td>
                </tr>
            </AppTable>
            <Pagination :links="clients.links"/>   
        </div>
    </Layout>
</template>
