<script setup>
    import { useForm } from '@inertiajs/vue3';

    import AppLayout from '../../Shared/layout/AppHeaderLayout.vue'

    import WhiteBox from '../../Shared/Components/WhiteBox.vue';
    import TextInput from '../../Shared/Components/TextInput.vue';
    import AppButton from '../../Shared/Components/AppButton.vue';
    import FlashMessage from '../../Shared/Components/FlashMessage.vue';

    defineOptions({
        layout: AppLayout,
    });

    const form = useForm({
        email: null,
        wachtwoord: null,
    })

    const submit = () => {
        form.post('/inloggen')
    }
</script>
<template>
    <div class="grid place-items-center"> 
        <FlashMessage :message="$page.props.flash.message"/>
        <WhiteBox title="Inloggen" class="w-1/4">
            <form @submit.prevent="submit">
                <div class="flex flex-col gap-4 mt-4">
                    <TextInput label="Email" v-model="form.email"/>
                    <TextInput label="Wachtwoord" v-model="form.wachtwoord"/>
                    <div class="flex">
                        <small><Link href="/reset-wachtwoord/check-email">Wachtwoord vergeten?</Link></small>
                        <AppButton class="w-min ml-auto">Inloggen</AppButton>
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