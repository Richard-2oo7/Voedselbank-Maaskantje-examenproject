<script setup>
import { reactive } from 'vue';
import AppTable from '../Table.vue';
import formatDate from '../../Composables/DateFormater.js';
const props = defineProps({
    purpose: String,
    values: Object,
    modelValue: Boolean,
})

const klant = reactive(props.values.voedselpakket.client);
const producten = reactive(props.values.voedselpakket.products);
const voedselpakket = reactive(props.values.voedselpakket);


</script>

<template>
    <!-- <pre>{{ producten }}</pre> -->
    <div class="w-[40vw]">
        <div>
            <strong>Opgehaald: </strong>
            <span v-html="voedselpakket.opgehaald ? 'ja' : 'nee'"></span>
        </div>
        <div>
            <strong>Datum samenstelling: </strong>
            <span>{{ formatDate(voedselpakket.created_at) }}</span>
        </div>
        <div>
            <strong>Uitgiftedatum: </strong>
            <span v-html="voedselpakket.uitgiftedatum ? formatDate(voedselpakket.uitgiftedatum) : '-'"></span>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
            <p>
                <strong>Gezinssamenstelling</strong>
                <ul class="list-disc ml-4">
                    <li>volwassenen: {{ klant.volwassenen }}</li>
                    <li>kinderen: {{ klant.kinderen }}</li>
                    <li>baby's: {{ klant.babys }}</li>
                </ul>
            </p>

            <p v-if="klant.varkensvlees || klant.vegatarisch || klant.allergisch">
                <strong>Wensen</strong>
                <ul class="list-disc ml-4">
                    <li v-if="klant.varkensvlees">Geen varkensvlees</li>
                    <li v-if="klant.vegatarisch">Vegetarisch</li>
                    <li v-if="klant.allergisch">Allergisch voor: {{ klant.allergisch }}</li>
                </ul>
            </p>
        </div>
        <div class="mt-5">

            <AppTable :heads="['ProductNr', 'Productnaam','Aantal']">
                <tr v-for="product in producten" :key="product.id" class="border-t [&>td]:py-1 [&>td]: [&>td]:items-center hover:bg-slate-100">
                    <td>{{ product.EAN }}</td>
                    <td>{{ product.naam }}</td>
                    <td>{{ product.pivot.aantal_producten }}</td>
                </tr>
            </AppTable>
        </div>


    </div>
</template>