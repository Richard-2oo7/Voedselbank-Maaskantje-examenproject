import { ref } from "vue";
export function makePopup () {
    const popUpContent = ref({
        title: null, 
        component: null, 
        purpose: null, 
        values: null
    })

    const open = ref(false);

    const showPopup = (title, component, purpose, values) => {
        popUpContent.value = {title, component: component, purpose, values};
        open.value = true;
    }

    return {
        popUpContent,
        open,
        showPopup,
    };
}