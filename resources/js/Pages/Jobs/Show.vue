<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";

const sending = ref(false);

const props = defineProps({
    job: {Type: Object}
})

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

function sendJobResponse() {
    sending.value = true;

    axios.get(route('api.jobs.apply', props.job.id))
        .then(data => {
            console.log(data);
        })
        .catch(error => {
            console.error(error);
        })
        .finally(() => {
            sending.value = false;
        });
}
</script>

<template>
    <Head title="View Job"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ job.title}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       {{ job.description}}
                    </div>

                    <div class="p-6 text-gray-900">
                        <a :href="route('jobs')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-500 focus:outline-none focus:border-gray-700 focus:shadow-outline-gray active:bg-gray-700 transition duration-150 ease-in-out">
                            Back
                        </a>

                        <button v-if="$page.props.auth.user" type="button" @click="sendJobResponse" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-4" :disabled="sending">Response to the Job Vacancy</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
