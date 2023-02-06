<script setup>
    defineProps({
        items: Array
    })
</script>


<template>    
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Quantity
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="item in items" v-bind:key="item.id">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{item.name}}
                    </th>
                    <td class="px-6 py-4">{{item.category}}</td>
                    <td class="px-6 py-4">{{item.quantity}}</td>
                    <td class="px-6 py-4">{{item.price}}</td>
                </tr>

                <tr v-if="items.length == 0">
                    <td colspan="4" class="px-6 py-4 text-center">No data available</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>