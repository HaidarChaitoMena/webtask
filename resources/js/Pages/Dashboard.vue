<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";

defineProps<{
    users?: any;
    links?: any;
}>();
const users: any = usePage().props.users;

async function approveUser(user: any) {
    try {
        const response = await axios.put(`/users/${user.id}/approve`);
        const updatedUser = response.data;

        const index = users.data.findIndex((u: any) => u.id === updatedUser.id);
        if (index !== -1) {
            users.data[index].approved = updatedUser.approved;
        }
    } catch (error) {
        console.error(error);
    }
}

async function disapproveUser(user: any) {
    try {
        const response = await axios.put(`/users/${user.id}/disapprove`);
        const updatedUser = response.data;

        const index = users.data.findIndex((u: any) => u.id === updatedUser.id);
        if (index !== -1) {
            users.data[index].approved = updatedUser.approved;
        }
    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 mx-6">
            <div class="flex flex-col justify-center items-center">
                <div class="my-3">
                    <div>
                        <div class="max-w-2xl mx-auto">
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
                                                        Email
                                                    </th>
                                                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                                        scope="col">
                                                        Last Login
                                                    </th>
                                                    <th class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400"
                                                        scope="col">
                                                        Action
                                                    </th>

                                                </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                                <tr v-for="user in users.data"
                                                    class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ user.email }}
                                                    </td>
                                                    <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                        {{ user.last_login }}
                                                    </td>
                                                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        <secondary-button v-if="user.approved === 0"
                                                                          @click="approveUser(user)">
                                                            Approve
                                                        </secondary-button>
                                                        <secondary-button v-else-if="user.approved === 1"
                                                                          @click="disapproveUser(user)">
                                                            Disapprove
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
                </div>
                <div class="flex justify-center" v-html="links">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
