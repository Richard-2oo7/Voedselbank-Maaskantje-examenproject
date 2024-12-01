<script setup>
    import { useForm } from '@inertiajs/vue3'

    import AppLayout from '../Shared/layout/AppHeaderLayout.vue'
    import WhiteBox from '../Shared/Components/WhiteBox.vue'
    import TextInput from '../Shared/Components/TextInput.vue'
    import CheckBox from '../Shared/Components/CheckBox.vue'
    import SubmitButton from '../Shared/Components/AppButton.vue'

    defineOptions({
        layout: AppLayout,
    });

    const form = useForm({
        gezinsnaam: null,
        email: null,
        adres: null,
        postcode: null,
        telefoonnummer: null,
        allergisch: null,
        vegetarisch: false,
        veganistisch: false,
        vegetarisch: false,
        varkensvlees: false,
        volwassenen: null,
        kinderen: null,
        babys: null,
    });

    const submit = () => {
        form.post('/klanten')
    }


</script>
<template>
    <div class="grid place-items-center"> 
        <!-- <WhiteBox class="absolute top-0 left-0">
            <pre>
                {{ form }}
            </pre>
        </WhiteBox> -->
        <WhiteBox title="Als klant aanmelden" class="!w-1/3">
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
                        <SubmitButton class="ml-auto" :disabled="form.processing">Aanmelden</SubmitButton>
                    </div>
                </div>
            </form>
        </WhiteBox>
    </div>
</template>