<script lang="ts" setup>
import {useForm, usePage} from '@inertiajs/vue3';
import axios from "axios";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {reactive} from "vue";


const user = usePage().props.auth.user;
const certificates: any = usePage().props.certificates;
let user_certificates: any = reactive(usePage().props.auth.certificates);

const form = useForm({
    selected_certificate: '',
});

async function addCertificate(user: any, certificate: any) {
    try {
        const response = await axios.patch(`/profile/certificate/${user.id}/${certificate.id}`);
        Object.assign(user_certificates, response.data.certificates);

    } catch (error) {
        console.error(error);
    }
}

async function removeCertificate(user: any, certificate: any) {
    try {
        const response = await axios.delete(`/profile/certificate/${user.id}/${certificate.id}`);
        const index = user_certificates.findIndex((cert: any) => cert.id === certificate.id);

        if (index !== -1) {
            user_certificates.splice(index, 1);
        }
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <div>
        <div class="my-2">
            <InputLabel for="certificate" value="certificate"/>
            <select id="certificate" v-model="form.selected_certificate" required>
                <option v-for="certificate in certificates" :value=certificate>{{ certificate.title }}</option>
            </select>

            <InputError :message="form.errors.selected_certificate" class="mt-2"/>
        </div>
        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing" @click="addCertificate(user,form.selected_certificate,)">
                Add
            </PrimaryButton>

            <Transition
                enter-active-class="transition ease-in-out"
                enter-from-class="opacity-0"
                leave-active-class="transition ease-in-out"
                leave-to-class="opacity-0"
            >
                <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Added.</p>
            </Transition>
        </div>
        <div v-if="user_certificates !== null" class="max-w-2xl mt-3">
            <div class="flex flex-col">
                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table
                                class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                        scope="col">
                                        Title
                                    </th>
                                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                        scope="col">
                                        Date added
                                    </th>
                                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                        scope="col">
                                        Action
                                    </th>

                                </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                <tr v-for="user_certificate in user_certificates"
                                    class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ user_certificate.title }}
                                    </td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                        {{ user_certificate.created_at }}
                                    </td>
                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <secondary-button @click="removeCertificate(user,user_certificate)">
                                            Delete
                                        </secondary-button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<style scoped>
table, th, td {
    border: #9ca3af 1px solid;
    border-collapse: collapse;
}

</style>
