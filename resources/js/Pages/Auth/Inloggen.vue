<script setup>
    import { useForm } from '@inertiajs/vue3';

    import AppLayout from '../../Shared/layout/AppHeaderLayout.vue'

    import WhiteBox from '../../Shared/Components/WhiteBox.vue';
    import TextInput from '../../Shared/Components/form/TextInput.vue';
    import AppButton from '../../Shared/Components/AppButton.vue';
    import FlashMessage from '../../Shared/Components/FlashMessage.vue';

    defineOptions({
        layout: AppLayout,
    });

    const form = useForm({
        email: null,
        password: null,
    })

    const submit = () => {
        form.post('/inloggen')
    }
</script>
<template>
    <div class="grid place-items-center"> 
        <FlashMessage :message="$page.props.flash.message"/>
        <WhiteBox title="Inloggen" class="!w-1/4">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 mt-4">
                    <TextInput label="Email" v-model="form.email" :error="form.errors.email" type="email"/>
                    <TextInput label="Wachtwoord" v-model="form.password" :error="form.errors.password" type="password"/>
                    <div class="flex">
                        <small><Link href="/reset-wachtwoord/check-email">Wachtwoord vergeten?</Link></small>
                        <AppButton class="w-min ml-auto" :disabled="form.processing">Inloggen</AppButton>
                    </div>
                </div>
            </form>
        </WhiteBox>
    </div>
</template>