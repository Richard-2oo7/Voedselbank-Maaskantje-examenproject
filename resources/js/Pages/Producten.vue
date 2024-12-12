<script setup>
    import AppButton from '../Shared/Components/AppButton.vue';
    import CheckBox from '../Shared/Components/CheckBox.vue';
    import IconButton from '../Shared/Components/IconButton.vue';
    import AppTable from '../Shared/Components/Table.vue';
    import SearchInput from '../Shared/Components/SearchInput.vue';

    import WhiteBox from '../Shared/Components/WhiteBox.vue'

    import { router } from '@inertiajs/vue3';
    import { ref, watch, reactive } from 'vue';
    import { debounce } from 'lodash';

    const params = route().params;

    const props = defineProps({
        producten: Object,
        options: Object,
    });

    const search = ref(params.search ?? '');
    const category = ref(params.category_id ?? 0 );
    
    const debounceSearch = debounce((query) => {
        router.get(route('producten'), query, { preserveState: true });
    },200);
    
    watch([search, category], () => {
        sendProductPageRequest();
        updateCheckBoxArr();
    });
    
    const sendProductPageRequest = () =>{
        const query = {};
        if (category.value != 0) query.category_id = category.value;
        if (search.value) query.search = search.value;

        if(props.producten.current_page){
            query.page = props.producten.current_page;
        }
        debounceSearch(query);
    }
        
        const checkBoxArr = reactive({});
        const updateCheckBoxArr = () => {
            Object.keys(checkBoxArr).forEach((key) => {
            if (!props.producten.data.some(product => product.id === Number(key))) {
                delete checkBoxArr[key];
            }
        });

    
    // Voeg elk product toe aan de checkbox arr
    props.producten.data.forEach(product => {
        if (!checkBoxArr[product.id]) {
            checkBoxArr[product.id] = { id: product.id, checked: false };
        }
    });
    };

    updateCheckBoxArr();
    //als er nieuwe producten zijn word de checkbox arr geupdate
    watch(() => props.producten.data, () => {
        updateCheckBoxArr();
    });


    const checkedProducts = () => {
        return Object.values(checkBoxArr).filter(product => product.checked);
    }
    
    const deleteProducts = () => {
        const products = checkedProducts().map(p => p.id);

        //return als er 0 producten zijn geselecteerd
        if(products.length === 0) return
        
        console.log(products);
        axios.delete('/producten', { data: { ids: products } })
            .then(response => {
                console.log(response.data);
                console.log(props.producten);

                sendProductPageRequest();

                
            })
            .catch(error => {
                console.error(error.response.data);
            });
    }
</script>

<template>
    <Layout>
        <div>
            <div class="h-min flex justify-between">

                <div class="flex space-x-1 mb-2">
                    <AppButton variant="small">Nieuw product aanmaken</AppButton>
                    <AppButton variant="small" :withIcon="true" :disabled="!checkedProducts() .length" @click="deleteProducts()">
                        <img src="/public/Icons/DeleteIcon.svg" alt="icon">Verwijderen
                    </AppButton>
                </div>

                <div class="space-x-1 flex">
                    <select class="border border-black p-2 rounded-full" v-model="category">
                        <option class="hover:bg-orange-500" value="0">Alle categorieën</option>
                        <option v-for="option in options" :value="option.id" :key="option.id">{{ option.naam }}</option>
                    </select>
                    <SearchInput v-model="search" :searchTerm="params.search"/>
                </div>

            </div>

            <AppTable :heads="['','ProductNr', 'Naam', 'Categorie', 'Aantal op voorraad']">
                <tr v-for="(product) in producten.data" :key="product.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center">
                    <td class="space-x-2 flex items-center">
                        <CheckBox v-model="checkBoxArr[product.id].checked"/>
                        <IconButton>
                            <img src="/public/icons/editIcon.svg" alt="icon">
                        </IconButton>
                    </td>
                    <td>{{ product.EAN }}</td>
                    <td>{{ product.naam }}</td>
                    <td>{{ product.category.naam }}</td>
                    <td>{{ product.aantal }}</td>
                </tr>
            </AppTable>
 
            <div class="self-end align-bottom h-auto" v-if="producten.links.length > 3">
                <ul class="flex space-x-4 absolute bottom-0 mb-8">
                    <li v-for="(link, index) in producten.links" :key="link.label">
                        <a  
                            :href="link.url" 
                            class="flex items-center justify-center w-8 h-8 rounded-full text-center text-sm"
                            :class="{'bg-orange-500 text-white': link.active,
                                     'bg-black text-white': index === 0 || index === producten.links.length - 1,
                                     'opacity-30' : !link.url,
                                    }"
                             v-html="index === 0 ? '&lt;' : index === producten.links.length - 1 ? '&gt;' : link.label"
                            >
                        </a>
                    </li>
                </ul>
            </div>
                
        </div>
    </Layout>
</template>
