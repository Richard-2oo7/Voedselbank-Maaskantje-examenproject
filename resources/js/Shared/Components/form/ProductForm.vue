<script setup>
    import TextInput from './TextInput.vue';
    import AppButton from '../AppButton.vue';

    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        purpose: String,
        values: Object,
        modelValue: Boolean,
    })

    const emit = defineEmits(['update:modelValue']);

    const product = props.values.product;

    const productForm = useForm({
        id: product ? product.id : null,
        naam: product ? product.naam : null,
        aantal: product ? product.aantal :null,
        EAN: product ? product.EAN : null,
        category_id: product ? product.category_id : 1,
    });
    

    const submit = () => {
        if(props.purpose == 'edit') {
            delete productForm.EAN;
            productForm
                .patch('/producten/' + productForm.id, {
                    onSuccess: () => emit('update:modelValue', false),
                })
        } else {
            productForm
                .post('/producten', {
                    onSuccess: () => emit('update:modelValue', false),
                })
        }
    }
</script>
<template>
    <!-- edit -->
        <form @submit.prevent="submit">
            <div class="grid grid-cols-2 gap-4 h-max mt-5">
                <TextInput label="Naam"  v-model="productForm.naam" :error="productForm.errors.naam"></TextInput>
                <TextInput label="Product Nummer" v-model="productForm.EAN" v-if="purpose !== 'edit'" :error="productForm.errors.EAN"></TextInput>
             <div>
                 <div class="border-black h-10 relative">
                     <TextInput label="Aantal" v-model="productForm.aantal" type="number" :error="productForm.errors.aantal"></TextInput>
                     <div class="absolute top-2 right-0 flex">
                         <button 
                             class="bg-orange-500 text-white border border-black rounded-sm w-6 h-6 flex items-center justify-center font-extrabold mr-1" 
                             @click="productForm.aantal--"
                             type="button">
                             -
                         </button>
                         <button 
                             class="bg-orange-500 text-white border border-black rounded-sm w-6 h-6 flex items-center justify-center font-extrabold" 
                             @click="productForm.aantal++"
                             type="button">
                             +
                         </button>
                     </div>
                 </div>
             </div>
             <select 
                 v-model="productForm.category_id" 
                 class="border-b border-black focus:outline-none">
                 <option v-for="option in values.options" :value="option.id" :key="option.id">{{ option.naam }}</option>
             </select>
            </div>
            <!-- buttons -->
            <div class="flex justify-end items-end">
                <AppButton v-html="purpose == 'edit' ? 'bewerken' : 'toevoegen'" :disabled="productForm.processing" type="submit"></AppButton>
            </div>
        </form>
    
</template>
<script>
</script>