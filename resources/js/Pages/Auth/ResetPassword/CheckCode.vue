<script setup>
    import { useForm } from '@inertiajs/vue3';

    import AppLayout from '../../../Shared/layout/AppHeaderLayout.vue'

    import WhiteBox from '../../../Shared/Components/WhiteBox.vue';
    import TextInput from '../../../Shared/Components/form/TextInput.vue';
    import AppButton from '../../../Shared/Components/AppButton.vue';

    defineOptions({
        layout: AppLayout,
    });

    defineProps({
        email: String,
    });

    const form = useForm({
        code: null,
    })

    const submit = () => {
        form.post('/reset-wachtwoord/check-code');
    }
</script>
<template>
    <div class="grid place-items-center"> 
        <WhiteBox title="Wachtwoord resetten" class="!w-1/4">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 mt-4">
                    <small class="mb-5"><p>Voer de code in die naar <strong>{{ email }}</strong> is verzonden.</p></small>
                    <TextInput label="Code" v-model="form.code" :error="form.errors.code"/>
                    <div class="flex">
                        <AppButton class="w-min ml-auto" :disabled="form.processing" type="submit">Resetten</AppButton>
                    </div>
                </div>
            </form>
        </WhiteBox>
    </div>
</template>