<template>
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table id="tableComponent" class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- loop through each value of the fields to get the table header -->
                                <th v-for="field in fields" :key='field' @click="sortTable(field)"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                    scope="col">
                                    {{ field }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <!-- Loop through the list get the each student data -->
                            <tr v-for="item in tableData" :key='item'>
                                <td v-for="field in fields" :key='field'
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-6">
                                    <span :id='field'>{{ item[field] }}<span id="rate" class="hidden">%</span> </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'TableComponent',
    props: {
        // 
        tableData: {
            type: Array,
        },
        fields: {
            type: Array,
        }
    },
}
</script>