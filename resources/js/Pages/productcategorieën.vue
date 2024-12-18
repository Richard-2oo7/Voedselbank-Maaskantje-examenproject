<script setup>
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import AppButton from '../Shared/Components/AppButton.vue';
    import CheckBox from '../Shared/Components/form/CheckBox.vue';
    import IconButton from '../Shared/Components/IconButton.vue';
    import AppTable from '../Shared/Components/Table.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    import CategorieForm from '../Shared/Components/form/CategorieForm.vue';
    
    import deleteItems from '../Shared/Composables/DeleteItems.js'

    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    import PopUp from '../Shared/Components/PopUp.vue';
    
    import { ref, watch } from 'vue';
    
    const params = route().params;
    const search = ref(params.search);
    const props = defineProps({
        productCategorieën: Object
    })

    const { checkBoxArr,
        updateCheckBoxArr,
        sendProductPageRequest,
        checkedItems,
        deleteCheckedItems, } = deleteItems('productcategorieën', props.productCategorieën);
        
        updateCheckBoxArr(props.productCategorieën.data);

    watch([search], () => {
        sendProductPageRequest(0, search);
        updateCheckBoxArr(props.productCategorieën.data);
    });

    watch(() => props.productCategorieën.data, (newData) => {
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
        <CategorieForm :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></CategorieForm>
    </PopUp>
    <Layout>
        <div class="h-min flex justify-between">

            <div class="flex space-x-1 mb-2">
                <AppButton variant="small" @click="handlePopUp('Categorie toevoegen', medewerkerForm, 'make', {medewerkerFuncties})">Categorie toevoegen</AppButton>
                <AppButton variant="small" :withIcon="true" :disabled="!checkedItems() .length" @click="deleteCheckedItems(() => sendProductPageRequest(0, search))">
                    <img src="/public/Icons/DeleteIcon.svg" alt="icon">Verwijderen
                </AppButton>
            </div>

            <div class="flex justify-end">
                <SearchInput v-model="search" :searchTerm="params.search"/>
            </div>

        </div>
        <div> 
            <AppTable :heads="['','Naam']">
                <tr v-for="categorie in productCategorieën.data" :key="categorie.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100">
                    <td class="space-x-2 flex items-center">
                        <CheckBox v-model="checkBoxArr[categorie.id].checked"/>
                        <IconButton @click="handlePopUp('categorie bewerken', categorie, 'edit', { categorie })">
                            <img src="/public/icons/editIcon.svg" alt="icon">
                        </IconButton>
                    </td>
                    <td>{{ categorie.naam }}</td>
                </tr>
            </AppTable>
            <Pagination :links="productCategorieën.links"/>     
        </div>
    </Layout>
</template>

