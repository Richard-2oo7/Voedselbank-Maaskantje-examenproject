<script setup>
    import { useForm } from '@inertiajs/vue3';

    import AppLayout from '../../../Shared/layout/AppHeaderLayout.vue'

    import WhiteBox from '../../../Shared/Components/WhiteBox.vue';
    import TextInput from '../../../Shared/Components/form/TextInput.vue';
    import AppButton from '../../../Shared/Components/AppButton.vue';

    defineOptions({
        layout: AppLayout,
    }); 

    const form = useForm({
        email: null,
    })

    const submit = () => {
        form.post('/reset-wachtwoord/check-email');
    }
</script>
<template>
    <div class="grid place-items-center"> 
        <WhiteBox title="Wachtwoord resetten" class="!w-1/4">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 mt-4">
                    <small class="mb-5"><p>Voer uw email in om uw wachtwoord te kunnen wijzigen.</p></small>
                    <TextInput label="Email" v-model="form.email" :error="form.errors.email"/>
                    <div class="flex">
                        <AppButton class="w-min ml-auto" type="submit" :disabled="form.processing">Verstuur</AppButton>
                    </div>
                </div>
            </form>
        </WhiteBox>
    </div>
</template>