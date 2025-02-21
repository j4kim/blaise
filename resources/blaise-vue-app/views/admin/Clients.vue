<script setup>
import { Column, DataTable } from "primevue";
import { reactive } from "vue";
import { get } from "../../api";

const clients = reactive({ rows: [] });

async function fetchClients() {
    const { data, response } = await get("/api/clients");
    if (!response.ok) return;
    clients.rows = data.data;
}

fetchClients();
</script>

<template>
    <div class="flex flex-col h-full">
        <h2 class="text-3xl font-extralight mt-4">Clients</h2>

        <DataTable :value="clients.rows" paginator :rows="5">
            <Column field="id" header="ID"></Column>
            <Column field="created_at" header="Création"></Column>
            <Column field="updated_at" header="Modification"></Column>
            <Column field="deleted_at" header="Suppression"></Column>
            <Column field="first_name" header="Prénom"></Column>
            <Column field="last_name" header="Nom"></Column>
            <Column field="tel_1" header="Tel 1"></Column>
            <Column field="tel_2" header="Tel 2"></Column>
            <Column field="tel_3" header="Tel 3"></Column>
            <Column field="npa" header="NPA"></Column>
            <Column field="location" header="Ville"></Column>
            <Column field="gender" header="Genre"></Column>
            <Column field="visits_count" header="Visites"></Column>
        </DataTable>
    </div>
</template>
