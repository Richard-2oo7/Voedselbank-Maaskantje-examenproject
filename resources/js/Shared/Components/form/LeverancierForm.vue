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

    const leverancier = props.values && props.values.leverancier ? props.values.leverancier: {};

    const form = useForm({
        id: leverancier.id ?? null,
        bedrijfsnaam: leverancier.bedrijfsnaam ?? null,
        naam: leverancier.naam ?? null,
        adres: leverancier.adres ?? null,
        email: leverancier.email ?? null,
        telefoonnummer: leverancier.telefoonnummer ?? null,
        volgende_levering: leverancier.volgende_levering ?? null,
    });
    

    const submit = () => {
        if(props.purpose == 'edit') {
            form
                .patch('/leveranciers/' + form.id, {
                    onSuccess: () => emit('update:modelValue', false),
                })
        } else {
            delete form.id;
            form
                .post('/leveranciers', {
                    onSuccess: () => emit('update:modelValue', false),
                })
        }
    }
</script>
<template>
     <div class="w-[30vw]">
         <form @submit.prevent="submit">
             <div class="grid grid-cols-2 gap-4 h-max mt-5">
                 <TextInput label="Bedrijfsnaam" v-model="form.bedrijfsnaam" :error="form.errors.bedrijfsnaam"></TextInput>
                 <TextInput label="Naam" v-model="form.naam" :error="form.errors.naam"></TextInput>

                 <TextInput label="Email" v-model="form.email" :error="form.errors.email"></TextInput>
                 <TextInput label="Telefoonnummer" v-model="form.telefoonnummer" :error="form.errors.telefoonnummer"></TextInput>

                 <TextInput label="Adres" v-model="form.adres" :error="form.errors.adres"></TextInput>
                 <TextInput label="Volgende Levering" v-model="form.volgende_levering" :error="form.errors.volgende_levering" type="datetime-local" :required="false"></TextInput>
             </div>
             <div class="flex justify-end items-end">
                 <AppButton v-html="purpose == 'edit' ? 'bewerken' : 'toevoegen'" :disabled="form.processing" type="submit"></AppButton>
             </div>
         </form>
     </div>
</template>