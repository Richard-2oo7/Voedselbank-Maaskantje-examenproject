import { reactive } from "vue";
import { router } from "@inertiajs/vue3";
import { debounce } from 'lodash';
import { watch } from "vue";

export default function deleteItems(routeName, AllData) {
    // Voeg elk product toe aan de checkbox arr
    const checkBoxArr = reactive({});
    
    const updateCheckBoxArr = (allItems) => {
        
        Object.keys(checkBoxArr).forEach((key) => {
            if (!allItems.some(data => data.id === Number(key))) {
                delete checkBoxArr[key];
            }
        });
    
        Array.from(allItems).forEach(data => {
            if (!checkBoxArr[data.id]) {
                checkBoxArr[data.id] = { id: data.id, checked: false };
            }
        });
        return checkBoxArr;
    };
    
    const debounceInput = debounce((query) => {
        router.get(route(routeName), query, { preserveState: true });
    }, 200);

    const sendProductPageRequest = (category, search) => {
        const query = {};
        if (category.value != 0) query.category_id = category.value;
        if (search.value) query.search = search.value;
        
        if(AllData.current_page){
            query.page = AllData.current_page;
        }

        debounceInput(query);
    }

    //return items die aangevinkt zijn
    const checkedItems = () => {
        return Object.values(checkBoxArr).filter(item => item.checked);
    }
    
    //verwijder de rijen die aangevinkt zijn
    const deleteCheckedItems = (onSuccessCallBack) => {
        const items = checkedItems().map(item => item.id);
        
        //return als er 0 items zijn geselecteerd
        if(items.length === 0) return

        //stuur server verzoek
        router.delete('/' + routeName, {
            data: {
                ids: items
            }
        }, {
            onSuccess: () => {
                if(onSuccessCallBack) onSuccessCallBack()
            },
        })
    }

    return {
        checkBoxArr,
        updateCheckBoxArr,
        sendProductPageRequest,
        deleteCheckedItems,
        checkedItems,
    };
}
