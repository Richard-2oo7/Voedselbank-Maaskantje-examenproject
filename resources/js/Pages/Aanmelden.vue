<script setup>

import KlantForm from '../Shared/Components/form/KlantForm.vue';
    import AppLayout from '../Shared/layout/AppHeaderLayout.vue'
    import WhiteBox from '../Shared/Components/WhiteBox.vue'

    defineOptions({
        layout: AppLayout,
    });


</script>
<template>
    <div class="grid place-items-center"> 
        <!-- <WhiteBox class="absolute top-0 left-0">
            <pre>
                {{ form }}
            </pre>
        </WhiteBox> -->
        <WhiteBox title="Als klant aanmelden" class="!w-1/3">
            <KlantForm/>
        </WhiteBox>
    </div>
</template>