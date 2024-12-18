<script setup>
    defineProps({
        links: Array,
    })
</script>
<template>
    <div class="self-end align-bottom h-auto" v-if="links.length > 3">
        <ul class="flex space-x-4 absolute bottom-0 mb-8">
            <li v-for="(link, index) in links" :key="link.label">
                <a  
                    :href="link.url" 
                    class="flex items-center justify-center w-8 h-8 rounded-full text-center text-sm"
                    :class="{'bg-orange-500 text-white': link.active,
                                'bg-black text-white': index === 0 || index === links.length - 1,
                                'opacity-30' : !link.url,
                            }"
                     v-html="index === 0 ? '&lt;' : index === links.length - 1 ? '&gt;' : link.label"
                    >
                </a>
            </li>
        </ul>
    </div>
</template>