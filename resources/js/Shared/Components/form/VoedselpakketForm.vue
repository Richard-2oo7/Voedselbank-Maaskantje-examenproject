<script setup>
    import AppTable from '../Table.vue';
    import Pagination from '../Pagination.vue';
    import { reactive, ref, computed  } from 'vue';
    import { router, useForm } from '@inertiajs/vue3';
    import CheckBox from './CheckBox.vue';
    import AppButton from '../AppButton.vue';
    
    const params = route().params;

    const props = defineProps({
        purpose: String,
        values: Object,
        modelValue: Boolean,
    });

    const emit = defineEmits(['update:modelValue'])
    const klant = ref(props.values.geselecteerdeKlant ?? null);

    const loadForm = (client) => {
        const currentUrl = new URL(window.location.href); // Huidige URL ophalen
        currentUrl.searchParams.set('client_id', client.id);
        router.visit(currentUrl.toString()); // Navigeer naar de nieuwe URL
        klant.value = client;
    }

    const selectedProducts = reactive({});
    const updateSelectedProducts = () => {    
        Array.from(props.values.producten.data).forEach(product => {
            selectedProducts[product.id] = {id:product.id, aantal: 1, checked: false };
        });
    };

    const changeValue = (product,bool) => {
        if(bool){
            if(product.aantal == selectedProducts[product.id].aantal) return
            selectedProducts[product.id].aantal++
        } else {
            if(selectedProducts[product.id].aantal == 1) return
            selectedProducts[product.id].aantal--
        }
    }
    const sortedProducts = computed(() => {
        return props.values.producten.data.slice().sort((a, b) => {
            const aChecked = selectedProducts[a.id]?.checked || false;
            const bChecked = selectedProducts[b.id]?.checked || false;
            return (bChecked - aChecked); // checked items komen bovenaan
        });
    });
    updateSelectedProducts()

    const checkedProductsArr = () => {
        return Object.values(selectedProducts).filter(p => {
            return selectedProducts[p.id]?.checked === true;
        });
    }
    const productForm = useForm({
        client_id: params['client_id'],
        products: checkedProductsArr(),
    })
    const submitForm = () => {
        productForm.products = checkedProductsArr();
        productForm.post('/voedselpakketten', {
            onSuccess: () => emit('update:modelValue', false),
        })
    
};

</script>

<template>
    <!-- <pre>{{ values }}</pre> -->
    <div class="w-[70vw] h-max">
        <div class="flex flex-col mt-2" v-if="!klant">
            <AppTable :heads="['KlantNr', 'Gezinsnaam', 'Wensen', 'Gezinsssamenstelling']">
                <tr v-for="client in values.klanten.data" :key="client.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100 cursor-pointer" @click.stop="loadForm(client)">
                    <td>{{ client.id }}</td>
                    <td>{{ client.gezinsnaam }}</td>
                    <td>
                        <span v-html="client.veganistisch ? 'Veganistisch, ' : ''"></span>
                        <span v-html="client.vegetarisch ? 'vegetarisch, ' : ''"></span>
                        <span v-html="client.varkensvlees ? 'geen varkensvlees, ' : ''"></span>
                        <span v-html="client.allergisch ? `Allergish voor: ${client.allergisch}`: ''"></span>
                        <span v-if="!client.veganistisch || !client.vegetarisch || !client.varkensvlees || !client.allergisch"></span>
                    </td>
                    <td>{{ client.volwassenen }}, {{ client.kinderen }}, {{ client.babys }}</td>
                    <td>
                        <svg class="mt-[2px]" width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L7 7L1 13" stroke="lightgray" stroke-width="2"></path>
                        </svg>
                    </td>
                </tr>
            </AppTable>
            
            <!-- paginator -->
             <div class="mt-12">
                 <pagination :links="values.klanten.links"/>
             </div>
        </div>

        
        <div v-else>
            <div class="flex space-x-1">
                <strong>Gezinsnaam:</strong><p>{{ klant.gezinsnaam }}</p>
            </div>
            <div class="grid grid-cols-[max-content_max-content] gap-12 mt-4">
                <p>
                    <strong>Gezinssamenstelling</strong>
                    <ul class="list-disc ml-4">
                        <li>volwassenen: {{ klant.volwassenen }}</li>
                        <li>kinderen: {{ klant.kinderen }}</li>
                        <li>baby's: {{ klant.babys }}</li>
                    </ul>
                </p>
                
                <div>
                    <strong>Wensen</strong>
                    
                    <p v-if="klant.varkensvlees || klant.vegetarisch || klant.allergisch || klant.veganistisch">
                        <ul class="list-disc ml-4">
                            <li v-if="klant.varkensvlees">Geen varkensvlees</li>
                            <li v-if="klant.vegetarisch">Vegetarisch</li>
                            <li v-if="klant.veganistisch">Veganistisch</li>
                            <li v-if="klant.allergisch">Allergish voor: {{ klant.allergisch }}</li>
                        </ul>
                    </p>
                    <p v-else>
                        <ul>
                            <li>Geen wensen</li>
                        </ul>
                    </p>
                </div>

            </div>
                <div>
                <AppTable :heads="['ProductNr', 'Naam', 'Aantal op voorraad', 'Aantal voor de klant']">
                        <tr v-for="product in sortedProducts" :key="product.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100"> 
                            <td>{{ product.EAN }}</td>
                            <td>{{ product.naam }}</td>
                            <td>{{ product.aantal }}</td>
                            <td class="flex items-center">
                                <CheckBox v-model="selectedProducts[product.id].checked"/>
                                <div class="flex items-center ml-3 space-x-1" v-if="selectedProducts[product.id].checked">
                                    <button class="bg-orange-500 text-white border border-black rounded-md w-5 h-5 flex items-center justify-center font-extrabold pb-[3px]" @click="changeValue(product, 0)">-</button>
                                    <span>{{ selectedProducts[product.id].aantal }}</span>
                                    <button class="bg-orange-500 text-white border border-black rounded-md w-5 h-5 flex items-center justify-center font-extrabold pb-[3px]" @click="changeValue(product, 1)">+</button>
                                </div>
                            </td>
                        </tr>
                    </AppTable>
                    <div>
                </div>
                <!-- errors -->
                 <div v-if="productForm.errors">
                    <p v-if="productForm.errors.client_id" class="text-red-500">{{ productForm.errors.client_id }}</p>
                    <p v-if="productForm.errors.products" class="text-red-500">Selecteer minimaal 1 product</p>
                 </div>
                <!-- paginator -->
                <div class="mt-4 flex justify-between">
                    <pagination :links="values.producten.links"/>
                    <AppButton @click="submitForm" :disabled="productForm.processing">Maak voedselpakket</AppButton>
                </div>

            </div>
            
        </div>
    </div>
</template>