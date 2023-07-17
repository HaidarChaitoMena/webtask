<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";

defineProps<{
    users?: any;
    links?: any;
}>();
const users:any = usePage().props.users;

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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12 mx-6">
            <div class="flex flex-col justify-center items-center">
                <div class="my-3">
                    <div>
                        <table>
                            <tr>
                                <th>Email</th>
                                <th>Action</th>
                                <th>Last login</th>
                            </tr>
                            <tr v-for="user in users.data">
                                <td>{{ user.email }}</td>
                                <td>
                                    <secondary-button v-if="user.approved === 0" @click="approveUser(user)">
                                        Approve
                                    </secondary-button>
                                    <secondary-button v-else-if="user.approved === 1" @click="disapproveUser(user)">
                                        Disapprove
                                    </secondary-button>
                                </td>
                                <td>{{ user.last_login }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="flex justify-center" v-html="links">
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
