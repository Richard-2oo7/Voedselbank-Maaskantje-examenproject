<script setup>
    import { update } from 'lodash';
    import WhiteBox from './WhiteBox.vue';
    import { router } from '@inertiajs/vue3';
    import { ref } from 'vue';
    defineProps({
        popUptitle: String,
        modelValue: Boolean,
    })
    const emit = defineEmits(['update:modelValue']);

    let closeFormViaOverlay =  (e) => {
        if(!e.target.closest('.popup')){
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete('client_page');
            currentUrl.searchParams.delete('client_id');
            currentUrl.searchParams.delete('client_page');
            router.visit(currentUrl.toString());     

            emit('update:modelValue', false);

        }
    }
    let closeFormViaButton =  () => {
        emit('update:modelValue', false);
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('client_page');
        currentUrl.searchParams.delete('client_id');
        currentUrl.searchParams.delete('product_page');
        router.visit(currentUrl.toString());
    }
</script>

<template>
    <div class="bg-black/70 grid place-items-center absolute top-0 left-0 w-full z-10" @click="closeFormViaOverlay($event)" v-if="modelValue">
        <WhiteBox :title="popUptitle" class="bg-white p-5 relative popup w-[40vw] h-3/5">
            <button class="absolute top-4 right-4 hover:bg-gray-100 p-2 rounded-full" @click.stop="closeFormViaButton()"><img src="/public//Icons/exitIcon.svg" alt="icon"></button>
            <slot/>
        </WhiteBox>
    </div>
</template>