<script setup>

    // import components
    import GroupRule from "@/Components/Filter/GroupRule.vue"
    import SmallRedButton from "@/Components/Button/SmallRedButton.vue"
    import { ref } from 'vue'

    const props = defineProps({
        form: Array
    });

    let groupData = props.form;

    // Append Object with type rule to group data
    const addRule = () => {
        groupData.data.push({
            type: "rule",
            data: {field: "", type: "", value: "", table: "", dataType: ""}
        })
    }

    // Append Object with type group to group data
    const addGroup = () => {
        groupData.data.push({
            type: "group",
            condition: "AND",
            data: []
        })
    }

    // change Group condition either using "AND" or "OR"
    const changeCondition = (con) => {
        groupData.condition = con
    }

    // remove array with given index
    const deleteData = (idx) => {
        groupData.data.splice(idx, 1)
    }
    
</script>


<template>

    <div class="bg-gray-100 p-3 border border-gray-200 my-2">
        <div class="float-left">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <!-- when clicked will change group condition to "AND" -->
                <button 
                    type="button" 
                    @click="changeCondition('AND')"
                    class="px-4 py-1 text-sm font-medium text-white bg-blue-700 border border-blue-800 rounded-l-lg hover:bg-blue-800 focus:z-10 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    :class="{'bg-blue-800': groupData.condition == 'AND'}"
                >
                    AND
                </button>

                <!-- when clicked will change group condition to "OR" -->
                <button 
                    type="button" 
                    @click="changeCondition('OR')"
                    class="px-4 py-1 text-sm font-medium text-white bg-blue-700 border border-blue-800 rounded-r-md hover:bg-blue-800 focus:z-10 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    :class="{'bg-blue-800': groupData.condition == 'OR'}"
                >
                    OR
                </button>
            </div>
        </div>

        <div class="float-right">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <!-- when clicked will add Rule inside group -->
                <button 
                    type="button" 
                    @click="addRule()"
                    class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                >
                    Add Rule
                </button>

                <!-- when clicked will add group inside group -->
                <button 
                    type="button" 
                    @click="addGroup()"
                    class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"
                >
                    Add Group
                </button>
                <slot />
            </div>
        </div>

        <!-- prevent float element overshadow below element -->
        <div class="clear-both"></div>

        <!-- Show group data either it is rule or group -->
        <div v-for="(d, index) in groupData.data" v-bind:key="index">

            <!-- if the data is rule then use GroupRule component -->
            <GroupRule :form="d.data" class="bg-white p-2" v-if="d.type == 'rule'">
                <div class="text-right">
                    <SmallRedButton @click="deleteData(index)">
                        Delete
                    </SmallRedButton>
                </div>
            </GroupRule>
            
            <!-- if the data is group then use GroupForm component (recursive components) -->
            <GroupForm :form="d" class="bg-white p-2" v-if="d.type == 'group'">
                <SmallRedButton @click="deleteData(index)" class="ml-2">
                    Delete
                </SmallRedButton>
            </GroupForm>
        </div>
    </div>

</template>