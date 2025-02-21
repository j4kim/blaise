<script setup>
import { Column, DataTable, Paginator } from "primevue";
import { reactive } from "vue";
import { get } from "../../api";
import dayjs from "dayjs";

const state = reactive({ page: {}, loading: false });

async function fetchClients(page = 1) {
    state.loading = true;
    const { data, response } = await get(`/api/clients?page=${page}`);
    state.loading = false;
    if (!response.ok) return;
    state.page = data;
}

fetchClients();

function formatDate(isoDate) {
    return dayjs(isoDate).format("DD.MM.YY");
}
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="text-xl font-extralight py-2 px-4">Clients</header>

        <DataTable
            :value="state.page.data"
            scrollable
            scrollHeight="100%"
            class="grow overflow-auto"
            :loading="state.loading"
            :rowClass="(row) => (row.deleted_at ? 'opacity-50' : '')"
        >
            <Column field="id" header="ID"></Column>
            <Column field="updated_at" header="Mise à jour">
                <template #body="slotProps" class="yolo">
                    {{ formatDate(slotProps.data.updated_at) }}
                </template>
            </Column>
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

        <Paginator
            :rows="state.page.per_page"
            :totalRecords="state.page.total"
            :first="state.page.from - 1"
            @page="fetchClients($event.page + 1)"
        ></Paginator>
    </div>
</template>
