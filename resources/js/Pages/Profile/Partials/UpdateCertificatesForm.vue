<script lang="ts" setup>
import {usePage} from '@inertiajs/vue3';
import axios from "axios";

defineProps<{
    user?: any;
    certificates?: any;
}>();
const user: any = usePage().props.users;

async function addCertificate(user: any, certificate: any) {
    try {
        const response = await axios.put(`/users/${user.id}/certificate/${certificate.id}/add`);
        user = response.data;

    } catch (error) {
        console.error(error);
    }
}

async function removeCertificate(user: any, certificate: any) {
    try {
        const response = await axios.put(`/users/${user.id}/certificate/${certificate.id}/remove`);
        user = response.data;

    } catch (error) {
        console.error(error);
    }
}
</script>

<template>
    <div>
        <div v-for="certificate in certificates"></div>
        
    </div>
</template>
