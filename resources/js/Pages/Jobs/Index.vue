<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';

const jobs = ref([]);

onMounted(() => {
    fetchJobs();
});

const props = defineProps({
    fetchJobsUrl: {Type :String, required: true}
})

function fetchJobs() {
    fetch(props.fetchJobsUrl)
        .then(response => response.json())
        .then(data => jobs.value = data)
        .catch(error => console.error(error));
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

                            <table v-if="jobs.length" class="w-full text-sm text-left text-gray-700">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="py-3 px-6">
                                        Job Vacancy
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Responses
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Job Description
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Author
                                    </th>
                                    <th scope="col" class="py-3 px-6">
                                        Published
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="job in jobs" class="bg-white border-b">
                                    <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                        {{ job.title }}
                                    </th>
                                    <td class="py-4 px-6">
                                        {{ job.response_count }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ job.description }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ job.user.name }}
                                    </td>
                                    <td class="py-4 px-6">
                                       {{ job.published }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
