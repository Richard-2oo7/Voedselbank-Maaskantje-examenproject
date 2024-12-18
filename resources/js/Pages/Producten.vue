<script setup>
    import SearchInput from '../Shared/Components/SearchInput.vue';
    import AppButton from '../Shared/Components/AppButton.vue';
    import CheckBox from '../Shared/Components/form/CheckBox.vue';
    import IconButton from '../Shared/Components/IconButton.vue';
    import AppTable from '../Shared/Components/Table.vue';
    import ProductForm from '../Shared/Components/form/ProductForm.vue';
    import FlashMessage from '../Shared/Components/FlashMessage.vue';
    import Pagination from '../Shared/Components/Pagination.vue';
    
    import deleteItems from '../Shared/Composables/DeleteItems.js'

    import { makePopup } from '../Shared/Composables/UsePopUp.js';
    import PopUp from '../Shared/Components/PopUp.vue';
    
    import { ref, watch } from 'vue';
    
    const params = route().params;

    const props = defineProps({
        producten: Object,
        options: Object,
    });

    const search = ref(params.search ?? '');
    const category = ref(params.category_id ?? 0 );
    
    
    const { checkBoxArr,
        updateCheckBoxArr,
        sendProductPageRequest,
        checkedItems,
        deleteCheckedItems, } = deleteItems('producten', props.producten);
        
        updateCheckBoxArr(props.producten.data);

    watch([search, category], () => {
        sendProductPageRequest(category, search);
        updateCheckBoxArr(props.producten.data);
    });

    watch(() => props.producten.data, (newData) => {
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
        <ProductForm :values="popUpContent.values" :purpose="popUpContent.purpose" v-model="open"></ProductForm>
    </PopUp>
    <Layout>
        <div>
            <div class="h-min flex justify-between">

                <div class="flex space-x-1 mb-2">
                    <AppButton variant="small" @click="handlePopUp('product aanmaken', ProductForm, 'make', {options})">Nieuw product aanmaken</AppButton>
                    <AppButton variant="small" :withIcon="true" :disabled="!checkedItems() .length" @click="deleteCheckedItems(() => sendProductPageRequest(category, search))">
                        <img src="/public/Icons/DeleteIcon.svg" alt="icon">Verwijderen
                    </AppButton>
                </div>

                <div class="space-x-1 flex">
                    <select class="border border-black p-2 rounded-full" v-model="category">
                        <option value="0">Alle categorieën</option>
                        <option v-for="option in options" :value="option.id" :key="option.id">{{ option.naam }}</option>
                    </select>
                    <SearchInput v-model="search" :searchTerm="params.search"/>
                </div>

            </div>

            <AppTable :heads="['','ProductNr', 'Naam', 'Categorie', 'Aantal op voorraad']">
                <tr v-for="product in producten.data" :key="product.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100">
                    <td class="space-x-2 flex items-center">
                        <CheckBox v-model="checkBoxArr[product.id].checked"/>
                        <IconButton @click="handlePopUp('Product bewerken', ProductForm, 'edit', {options:options, product:product},)">
                            <img src="/public/icons/editIcon.svg" alt="icon">
                        </IconButton>
                    </td>
                    <td>{{ product.EAN }}</td>
                    <td>{{ product.naam }}</td>
                    <td>{{ product.category ? product.category.naam : 'Geen categorie' }}</td>
                    <td>{{ product.aantal }}</td>
                </tr>
            </AppTable>
            <Pagination :links="producten.links"/>               
        </div>
    </Layout>
</template>
