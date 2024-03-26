<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {onMounted, ref, watch} from 'vue';

import DataTable from 'datatables.net-vue3'
import DataTablesLib from 'datatables.net';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

DataTable.use(DataTablesLib);

const jobs = ref([]);
const date = ref();

const columns = [
    {data: 'title', orderable: false},
    {data: 'response_count'},
    {data: 'description', orderable: false},
    {data: 'user.name', orderable: false},
    {data: 'published'},
];

onMounted(() => {
    fetchJobs();
});

watch(date, fetchJobs);

const props = defineProps({
    fetchJobsUrl: {Type: String, required: true}
})

function fetchJobs() {
    let url = props.fetchJobsUrl;

    if (date.value) {
        url += `?date_from=${getFormattedDate(date.value[0])}&date_to=${getFormattedDate(date.value[1])}`;
    }

    fetch(url)
        .then(response => response.json())
        .then(data => jobs.value = data)
        .catch(error => console.error(error));
}

function getFormattedDate(date) {
    let year = date.getFullYear();
    let month = (date.getMonth() + 1).toString().padStart(2, '0');
    let day = date.getDate().toString().padStart(2, '0');
    return `${year}-${month}-${day}`;
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jobs list</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <div v-if="!jobs.length" class="p-6 text-center text-gray-500">
                                No jobs found.
                            </div>

                            Filter:
                            <VueDatePicker
                            v-model="date"
                            :range="{}"
                            style="width: 300px;"
                            ></VueDatePicker>

                            <DataTable
                                v-if="jobs.length"
                                :data="jobs"
                                :columns="columns"
                                class="w-full text-sm text-left text-gray-700"
                                :options="{
                                    paging: true,
                                    searching: false,
                                    info: false,
                                    lengthChange: false,
                                    order: []
                                }"
                            >
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6">Job Vacancy</th>
                                    <th scope="col" class="py-3 px-6">Responses</th>
                                    <th scope="col" class="py-3 px-6">Job Description</th>
                                    <th scope="col" class="py-3 px-6">Author</th>
                                    <th scope="col" class="py-3 px-6">Published</th>
                                </tr>
                                </thead>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
