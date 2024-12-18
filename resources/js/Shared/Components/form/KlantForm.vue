<script setup>

import { useForm } from '@inertiajs/vue3'

import TextInput from './TextInput.vue'
import CheckBox from './CheckBox.vue'
import SubmitButton from '../AppButton.vue'

const props = defineProps({
    purpose: String,
    values: Object,
    modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue']);
const klant = props.values && props.values.klant ? props.values.klant: {};
// console.log(sentMail)
const hasSentMail = props.values && props.values.sentmail;
const sentMail = hasSentMail ?? true;


const form = useForm({
    id:             klant.id ?? null,
    gezinsnaam:     klant.gezinsnaam ?? null,
    email:          klant.email ?? null,
    adres:          klant.adres ?? null,
    postcode:       klant.postcode ?? null,
    telefoonnummer: klant.telefoonnummer ?? null,
    allergisch:     klant.allergisch ?? null,
    vegetarisch:    klant.vegetarisch === 1,
    veganistisch:   klant.veganistisch === 1,
    varkensvlees:   klant.varkensvlees === 1,
    volwassenen:    klant.volwassenen ?? null,
    kinderen:       klant.kinderen ?? null,
    babys:          klant.babys ?? null,
    sentMail:       sentMail,
});

const submit = () => {
    if(props.purpose == 'edit') {
        form.patch('/klanten/' + form.id, {
            onSuccess: () => emit('update:modelValue', false),
        })
    } else {
        form.post('/klanten', {
            onSuccess: () => emit('update:modelValue', false),
        })
    }
}

</script>
<template>
    <form @submit.prevent="submit">
        <div class="mt-5 grid grid-cols-2 gap-3 gap-x-7">

            <TextInput label="Gezinsnaam" v-model="form.gezinsnaam" :error="form.errors.gezinsnaam"/>
            <TextInput label="Email" type="email" v-model="form.email" :error="form.errors.email"/>

            <TextInput label="Adres" type="adres" v-model="form.adres" :error="form.errors.adres"/>
            <TextInput label="Postcode" v-model="form.postcode" :error="form.errors.postcode"/>

            <TextInput label="Telefoonnummer" v-model="form.telefoonnummer" :error="form.errors.telefoonnummer"/>     
            <TextInput label="Allergisch" :required="false" v-model="form.allergisch" :error="form.errors.allergisch"/>     
            
            <div class="flex flex-col gap-1">
                <CheckBox label="Vegetarisch" v-model="form.vegetarisch"/>
                <CheckBox label="Veganistisch" v-model="form.veganistisch"/>
            </div>

            <div class="flex flex-col gap-1 ">
                <CheckBox label="Geen varkensvlees" class="h-min" v-model="form.varkensvlees"/>
            </div>

            <div class="border border-black flex w-full col-span-2 gap-4 p-3">
                <div class="flex flex-col items-center justify-center space-y-2">
                    <span>Ouder dan 18</span>
                    <div class="items-end flex flex-grow">
                        <img src="/public/icons/ParentsIcon.svg" alt="icon">
                    </div>
                    <TextInput label="Volwassenen" type="number" v-model="form.volwassenen" :error="form.errors.volwassenen"/>     
                </div>

                <div class="flex flex-col items-center justify-center space-y-2">
                    <span>Ouder dan 2</span>
                    <div class="items-end flex flex-grow">
                        <img src="/public/icons/ChildrenIcon.svg" alt="icon">
                    </div>
                    <TextInput label="Kinderen" type="number" v-model="form.kinderen" :error="form.errors.kinderen"/>   
                </div>

                <div class="flex flex-col items-center justify-center space-y-2">
                    <span>Jonger dan 2</span>
                    <div class="items-end flex flex-grow">
                        <img src="/public/icons/BabyIcon.svg" alt="icon">
                    </div>
                    <TextInput label="Baby's" type="number" v-model="form.babys" :error="form.errors.babys"/>
                </div>
            </div>

            <div class=" col-span-2">
                <SubmitButton class="ml-auto" :disabled="form.processing" type="submit">Aanmelden</SubmitButton>
            </div>
        </div>
    </form>
</template>