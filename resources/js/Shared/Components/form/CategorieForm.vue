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

    const categorie = props.values.categorie;

    const form = useForm({
        id: categorie ? categorie.id : null,
        naam: categorie ? categorie.naam : null,
    });
    

    const submit = () => {
        if(props.purpose == 'edit') {
            form.patch('/productcategorieën/' + form.id, {
                    onSuccess: () => emit('update:modelValue', false),
            })
        } else {
            delete form.id;
            form.post('/productcategorieën', {
                onSuccess: () => emit('update:modelValue', false),
            })
        }
    }
</script>
<template>
    <!-- edit -->
        <form @submit.prevent="submit">
            <div class="h-max mt-5 w-[20vw]">
                <TextInput label="Naam"  v-model="form.naam" :error="form.errors.naam"></TextInput>
            </div>
            <div class="flex justify-end items-end">
                <AppButton v-html="purpose == 'edit' ? 'bewerken' : 'toevoegen'" :disabled="form.processing" type="submit"></AppButton>
            </div>
        </form>
    
</template>
<script>
</script>