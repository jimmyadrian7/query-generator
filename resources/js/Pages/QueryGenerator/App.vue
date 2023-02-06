<script setup>

// import components and required liblary
import { onMounted, ref } from 'vue'
import { initModals } from 'flowbite'
import { Head } from '@inertiajs/vue3'
import PrimaryButton from "@/Components/PrimaryButton.vue"
import SecondaryButton from "@/Components/SecondaryButton.vue"
import GroupForm from "@/Components/Filter/GroupForm.vue"
import ItemList from "@/Components/ItemList.vue"
import axios from "axios"


    // initialize modals
    onMounted(() => {
        initModals();
    })

    // initialize filter data
    let data = ref({
        type: "group",
        condition: "AND",
        data: []
    })

    // initialize item data
    let items = ref([])

    defineProps({
        fields: Array
    })

    // fetching items data via POST method
    const fetchData = () => {
        axios.post("/api/fetch/item", data._rawValue).then( response => {
            // set response data to variable items.
            items.value = response.data
        })
    }

    // call fetch data when initialize to load items.
    fetchData()

</script>

<template>
    <!-- Set page title -->
    <Head title="Query Generator" />

    <div class="container">

        <div class="flex p-4">
            <!-- button to show modal -->
            <SecondaryButton type="button" data-modal-toggle="modal" data-modal-target="modal">
                Query Generator
            </SecondaryButton>
        </div>
        
        <!-- component to show item list -->
        <ItemList class="my-5 px-3" :items="items"></ItemList>

        <!-- Modal -->
        <div id="modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-2xl md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                            Query Generator
                        </h3>
                        <!-- close button -->
                        <button id="closeButton" data-modal-hide="modal" data-modal-target="modal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                         <div>
                            <!-- component to show group form -->
                            <GroupForm :form="data"></GroupForm>
                         </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <!-- button to apply filter (trigger fetch function) -->
                        <PrimaryButton 
                            type="button" 
                            @click="fetchData()"
                            data-modal-hide="modal" data-modal-target="modal"
                        >Apply</PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
