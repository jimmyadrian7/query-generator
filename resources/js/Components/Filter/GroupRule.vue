<script setup>

    // import components
    import TextInput from "@/Components/TextInput.vue"
    import SelectInput from "@/Components/SelectInput.vue"
    import { usePage } from '@inertiajs/vue3'
    import { ref } from 'vue'

    // set components to require attributes form when called
    const props = defineProps({
        form: Object
    });

    // initialize
    let data = props.form;
    let fields = usePage().props.fields;
    let typeOptions = ref([]);
    let valueOptions = ref([]);
    let fieldType = ref('text');


    // function to get selected fields data
    const getField = () => {
        let fieldData = {}
        fields.forEach(val => {
            if (val.name == data.field)
            {
                fieldData = val
            }
        })

        return fieldData
    }

    // function to modify rule data
    const changeTypeOption = () => {
        if (data.field)
        {
            let fieldData = getField()
            fieldType = fieldData.type
            data.table = fieldData.table
            data.dataType = "string"

            // set the operation options
            typeOptions.value = [
                {value: '=', label: 'Equal'},
                {value: '<>', label: 'Not Equal'}
            ]

            if (fieldType == "number")
            {
                data.dataType = "integer" // set data type to integer so that php will convert it to integer
                
                // for data type number add more operation options
                typeOptions.value = typeOptions.value.concat([
                    {value: '<', label: 'Less'},
                    {value: '<=', label: 'Less than or equal'},
                    {value: '>', label: 'Greater'},
                    {value: '>=', label: 'Greater than or equal'}
                ])
            }

            // if field type is selection then set the value options
            if (fieldType == 'selection')
            {
                valueOptions.value = fieldData.options
            }
            else
            {
                valueOptions.value = []
            }
        }
    }

</script>

<template>
    <div class="grid grid-cols-4 gap-4 mt-5">
        <div>
            <!-- field name using SelectInput components -->
            <SelectInput v-model="data.field" @change="changeTypeOption()">
                <option v-for="(field, idx) in fields" v-bind:key="idx" :value="field.name">{{field.label}}</option>
            </SelectInput>
        </div>

        <div>
            <!-- field operation using SelectInput components -->
            <SelectInput v-model="data.type">
                <option v-for="(opt, idx) in typeOptions" v-bind:key="idx" :value="opt.value">{{opt.label}}</option>
            </SelectInput>
        </div>

        <div>
            <!-- if field type is 'text' then use TextInput components with type text -->
            <TextInput
                v-if="fieldType == 'text'"
                v-model="data.value"
                type="text"
            />

            <!-- if field type is 'number' then use TextInput components with type number -->
            <TextInput
                v-if="fieldType == 'number'"
                v-model="data.value"
                type="number"
            />

            <!-- if field type is 'selection' then use SelectInput components -->
            <SelectInput v-model="data.value" v-if="fieldType == 'selection'">
                <option v-for="(opt, idx) in valueOptions" v-bind:key="idx" :value="opt">{{opt}}</option>
            </SelectInput>
        </div>

        <slot />
    </div>
</template>