<script setup>
import { useForm } from '@inertiajs/vue3';
import AppButton from '../AppButton.vue';

const props = defineProps({
    values: Object,
});

const emit = defineEmits(['update:modelValue']);
const klant = props.values.klant;

const form = useForm({
    id: klant.id,
    keuze: 'accepteren',
    redenering: null,
});

const submit = () => {
    if(form.keuze == 'accepteren') delete form['redenering'];
    form
    .post('/klantverzoeken', {
        onSuccess: () => emit('update:modelValue', false)
    });
}
</script>

<template>
    <div class="w-[40vw]">
        <div class="grid grid-cols-2 gap-4 mt-4">
            <p><strong>Gezinsnaam: </strong>{{ klant.gezinsnaam }}</p>
            <p><strong>Email: </strong>{{ klant.email }}</p>
            <p><strong>Adres: </strong>{{ klant.adres }}</p>
            <p><strong>Postcode: </strong>{{ klant.postcode }}</p>

            <p>
                <strong>Gezinssamenstelling</strong>
                <ul class="list-disc ml-4">
                    <li>volwassenen: {{ klant.volwassenen }}</li>
                    <li>kinderen: {{ klant.kinderen }}</li>
                    <li>baby's: {{ klant.babys }}</li>
                </ul>
            </p>

            <p v-if="klant.varkensvlees || klant.vegatarisch || klant.allergisch">
                <strong>Eisen</strong>
                <ul class="list-disc ml-4">
                    <li v-if="klant.varkensvlees">Geen varkensvlees</li>
                    <li v-if="klant.vegatarisch">Vegetarisch</li>
                    <li v-if="klant.allergisch">{{ klant.allergisch }}</li>
                </ul>
            </p>

        </div>
        <form @submit.prevent="submit">
            <div class="flex flex-col my-4">
    
                <div class="flex items-center">
                    <input type="radio" id="accepteren" name="keuze" value="accepteren" class="appearance-none border w-4 h-4 border-black rounded-full checked:bg-black checked:border-black" v-model="form.keuze">
                    <label for="accepteren" class="ml-1 cursor-pointer">Accepteren</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" id="afwijzen" name="keuze" value="afwijzen" class="appearance-none border w-4 h-4 border-black rounded-full checked:bg-black checked:border-black" v-model="form.keuze">
                    <label for="afwijzen" class="ml-1 cursor-pointer">Afwijzen</label>
                </div>
    
            </div>
    
            <div v-if="form.keuze === 'afwijzen'" class="flex flex-col">
                <strong>Reden voor afwijzing</strong>
                <textarea class="border border-black h-28" v-model="form.redenering" maxlength="255"></textarea>
                <p v-if="form.errors.redenering" class="text-red-500">{{ form.errors.redenering }}</p>
            </div>
    
            <div class="flex justify-end mt-4">
                <AppButton type="submit" :disabled="form.processing">Verstuur</AppButton>
            </div>
        </form>

    </div>
</template>
