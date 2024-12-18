<script setup>
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import AppButton from '../Shared/Components/AppButton.vue';
    import CheckBox from '../Shared/Components/form/CheckBox.vue';
    import IconButton from '../Shared/Components/IconButton.vue';
    import AppTable from '../Shared/Components/Table.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    import LeverancierForm from '../Shared/Components/form/LeverancierForm.vue';
    
    import deleteItems from '../Shared/Composables/DeleteItems.js'
    import shortenString from '../Shared/Composables/limitCharacters.js';

    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    import PopUp from '../Shared/Components/PopUp.vue';
    
    import formatDate from '../Shared/Composables/DateFormater.js';
    import { ref, watch } from 'vue';

    const params = route().params;
    const props = defineProps({
        leveranciers: Object,
    });

    const search = ref(params.search ?? '');    
    
    const { checkBoxArr,
        updateCheckBoxArr,
        sendProductPageRequest,
        checkedItems,
        deleteCheckedItems, } = deleteItems('leveranciers', props.leveranciers);
        
        updateCheckBoxArr(props.leveranciers.data);

    watch([search], () => {
        sendProductPageRequest(0, search);
        updateCheckBoxArr(props.leveranciers.data);
    });

    watch(() => props.leveranciers.data, (newData) => {
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
        <LeverancierForm :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></LeverancierForm>
    </PopUp>
    <Layout>
        <div>
            <div class="h-min flex justify-between">

            <div class="flex space-x-1 mb-2">
                <AppButton variant="small" @click="handlePopUp('Leverancier toevoegen', medewerkerForm, 'make', {medewerkerFuncties})">Leveranciers toevoegen</AppButton>
                <AppButton variant="small" :withIcon="true" :disabled="!checkedItems() .length" @click="deleteCheckedItems(() => sendProductPageRequest(0, search))">
                    <img src="/public/Icons/DeleteIcon.svg" alt="icon">Verwijderen
                </AppButton>
            </div>

            <div class="flex justify-end">
                <SearchInput v-model="search" :searchTerm="params.search"/>
            </div>

            </div>
                <AppTable :heads="['','Bedrijsnaam','Naam', 'Email', 'Adres', 'Telefoonnummer', 'Volgende levering'] ">
                    <tr v-for="leverancier in leveranciers.data" :key="leverancier.id" class="border-t [&>td]:py-1 [&>td]:pr-3 [&>td]:items-center whitespace-nowrap hover:bg-slate-100">
                        <td class="space-x-2 flex items-center sticky left-0 bg-white h-full">
                            <CheckBox v-model="checkBoxArr[leverancier.id].checked"/>
                            <IconButton @click="handlePopUp('Leverancier bewerken', leverancierForm, 'edit', { leverancier, leverancierFuncties },)">
                                <img src="/public/icons/editIcon.svg" alt="icon">
                            </IconButton>
                        </td>
                        <td>{{ shortenString(leverancier.bedrijfsnaam) }}</td>
                        <td>{{ shortenString(leverancier.naam) }}</td>
                        <td>{{ shortenString(leverancier.email) }}</td>
                        <td>{{ shortenString(leverancier.adres) }}</td>
                        <td>{{ shortenString(leverancier.telefoonnummer) }}</td>
                        <td>{{ formatDate(leverancier.volgende_levering) }}</td>
                    </tr>
                </AppTable>
            <Pagination :links="leveranciers.links"/>   
        </div>
    </Layout>
</template>

