<script setup>
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import AppButton from '../Shared/Components/AppButton.vue';
    import CheckBox from '../Shared/Components/form/CheckBox.vue';
    import IconButton from '../Shared/Components/IconButton.vue';
    import AppTable from '../Shared/Components/Table.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    import MedewerkerForm from '../Shared/Components/form/MedewerkerForm.vue';
    
    import deleteItems from '../Shared/Composables/DeleteItems.js'

    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    import PopUp from '../Shared/Components/PopUp.vue';
    
    import { ref, watch } from 'vue';
    
    const params = route().params;
    const props = defineProps({
        medewerkers: Object,
        medewerkerFuncties: Array,
    })

    const search = ref(params.search ?? '');    
    
    const { checkBoxArr,
        updateCheckBoxArr,
        sendProductPageRequest,
        checkedItems,
        deleteCheckedItems, } = deleteItems('medewerkers', props.medewerkers);
        
        updateCheckBoxArr(props.medewerkers.data);

    watch([search], () => {
        sendProductPageRequest(0, search);
        updateCheckBoxArr(props.medewerkers.data);
    });

    watch(() => props.medewerkers.data, (newData) => {
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
        <MedewerkerForm :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></MedewerkerForm>
    </PopUp>
    <Layout>
        <div>
            <div class="h-min flex justify-between">

                <div class="flex space-x-1 mb-2">
                    <AppButton variant="small" @click="handlePopUp('Medewerker toevoegen', medewerkerForm, 'make', {medewerkerFuncties})">Medewerker toevoegen</AppButton>
                    <AppButton variant="small" :withIcon="true" :disabled="!checkedItems() .length" @click="deleteCheckedItems(() => sendProductPageRequest(0, search))">
                        <img src="/public/Icons/DeleteIcon.svg" alt="icon">Verwijderen
                    </AppButton>
                </div>

                <div class="flex justify-end">
                    <SearchInput v-model="search" :searchTerm="params.search"/>
                </div>

            </div>
            <AppTable :heads="['','Naam', 'Gebruikersnaam', 'Email', 'Functie']">
                <tr v-for="medewerker in medewerkers.data" :key="medewerker.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100">
                    <td class="space-x-2 flex items-center">
                        <CheckBox v-model="checkBoxArr[medewerker.id].checked"/>
                        <IconButton @click="handlePopUp('medewerker bewerken', medewerkerForm, 'edit', { medewerker, medewerkerFuncties },)">
                            <img src="/public/icons/editIcon.svg" alt="icon">
                        </IconButton>
                    </td>
                    <td>{{ medewerker.naam }}</td>
                    <td>{{ medewerker.gebruikersnaam }}</td>
                    <td>{{ medewerker.email }}</td>
                    <td>{{ medewerker.role.naam }}</td>
                </tr>
            </AppTable>
            <Pagination :links="medewerkers.links"/>     
        </div>
    </Layout>
</template>

