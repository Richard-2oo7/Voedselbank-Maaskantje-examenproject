<script setup>
    import { useForm } from '@inertiajs/vue3';

    import AppLayout from '../../../Shared/layout/AppHeaderLayout.vue'

    import WhiteBox from '../../../Shared/Components/WhiteBox.vue';
    import TextInput from '../../../Shared/Components/TextInput.vue';
    import AppButton from '../../../Shared/Components/AppButton.vue';

    defineOptions({
        layout: AppLayout,
    });

    const form = useForm({
        password: null,
        password_confirmed: null,
    })

    const submit = () => {
        form.patch('/reset-wachtwoord/maak-wachtwoord', {
            replace: true, //zorgt dat de url niet verandert
        });
    }
</script>
<template>
    <div class="grid place-items-center"> 
        <WhiteBox title="wachtwoord resetten" class="w-1/4">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 mt-4">
                    <TextInput label="Nieuw wachtwoord" v-model="form.password" type="password"/>
                    <TextInput label="Bevestig wachtwoord" v-model="form.password_confirmed" type="password"/>
                    <div class="flex">
                        <AppButton class="w-min ml-auto">Resetten</AppButton>
                    </div>
                </div>
            </form>
        </WhiteBox>
        <WhiteBox class="absolute left-0 w-1/4">
            <pre>
                {{ form }}
            </pre>
        </WhiteBox>
    </div>
</template>