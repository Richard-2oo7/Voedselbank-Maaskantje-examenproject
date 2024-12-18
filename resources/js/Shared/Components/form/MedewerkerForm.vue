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

    const medewerker = props.values && props.values.medewerker ? props.values.medewerker: {};

    const form = useForm({
        id: medewerker.id ?? null,
        naam: medewerker.naam ?? null,
        gebruikersnaam: medewerker.gebruikersnaam ?? null,
        email: medewerker.email ?? null,
        role_id: medewerker.role_id ?? 1,
    });
    

    const submit = () => {
        if(props.purpose == 'edit') {
            form
                .patch('/medewerkers/' + form.id, {
                    onSuccess: () => emit('update:modelValue', false),
                })
        } else {
            delete form.id;
            form
                .post('/medewerkers/', {
                    onSuccess: () => emit('update:modelValue', false),
                })
        }
    }
</script>
<template>
     <div class="w-[30vw]">
         <form @submit.prevent="submit">
             <div class="grid grid-cols-2 gap-4 h-max mt-5">
                 <TextInput label="Naam"  v-model="form.naam" :error="form.errors.naam"></TextInput>
                 <TextInput label="Gebruikersnaam" v-model="form.gebruikersnaam" :error="form.errors.gebruikersnaam"></TextInput>
                 <TextInput label="Email" v-model="form.email" :error="form.errors.email"></TextInput>
                 <select
                      v-model="form.role_id"
                      class="border-b border-black focus:outline-none mb-2">
                      <option v-for="option in values.medewerkerFuncties" :value="option.id" :key="option.id">{{ option.naam }}</option>
                  </select>
             </div>
 
             <div class="flex justify-end items-end">
                 <AppButton v-html="purpose == 'edit' ? 'bewerken' : 'toevoegen'" :disabled="form.processing" type="submit"></AppButton>
             </div>
         </form>
     </div>
    
</template>