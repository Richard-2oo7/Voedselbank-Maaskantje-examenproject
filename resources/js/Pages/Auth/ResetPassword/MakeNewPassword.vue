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
        password: null,
        password_confirmation: null,
    })

    const submit = () => {
        form.post('/reset-wachtwoord/maak-wachtwoord');
    }
</script>
<template>
    <div class="grid place-items-center"> 
        <WhiteBox title="wachtwoord resetten" class="!w-1/4">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 mt-4">
                    <TextInput label="Nieuw wachtwoord" v-model="form.password" type="password" :error="form.errors.password"/>
                    <TextInput label="Bevestig wachtwoord" v-model="form.password_confirmation" type="password" :error="form.errors.password_confirmation"/>
                    <div class="flex">
                        <AppButton class="w-min ml-auto" :disabled="form.processing" type="submit">Resetten</AppButton>
                    </div>
                </div>
            </form>
        </WhiteBox>
    </div>
</template>