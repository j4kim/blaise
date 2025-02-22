<script setup>
import { Column, DataTable, Paginator } from "primevue";
import { reactive } from "vue";
import { get } from "../../api";
import dayjs from "dayjs";

const state = reactive({ page: {}, loading: false });

async function fetchClients(page = 1) {
    state.loading = true;
    const { data, response } = await get("/api/clients", { page });
    state.loading = false;
    if (!response.ok) return;
    state.page = data;
}

fetchClients();

function formatDate(isoDate) {
    const date = dayjs(isoDate);
    return date.isValid() ? date.format("DD.MM.YY") : isoDate;
}

function formatTel(row) {
    return ["tel_1", "tel_2", "tel_3"]
        .map((name) => row[name])
        .filter((v) => v)
        .join(", ");
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
            :rowClass="(row) => (row.deleted_at ? 'opacity-50' : '')"
        >
            <Column field="id" header="ID"></Column>
            <Column
                field="updated_at"
                header="Mise à jour"
                bodyClass="tabular-nums"
            >
                <template #body="slotProps">
                    {{ formatDate(slotProps.data.updated_at) }}
                </template>
            </Column>
            <Column field="first_name" header="Prénom"></Column>
            <Column field="last_name" header="Nom"></Column>
            <Column header="Tel" bodyClass="min-w-44">
                <template #body="{ data }">
                    {{ formatTel(data) }}
                </template>
            </Column>
            <Column header="Ville" bodyClass="min-w-32">
                <template #body="{ data }">
                    {{ data.npa }} {{ data.location }}
                </template>
            </Column>
            <Column field="gender" header="Genre">
                <template #body="{ data }">
                    {{ data.gender == 1 ? "H" : "F" }}
                </template>
            </Column>
            <Column field="visits_count" header="Visites"></Column>
        </DataTable>

        <Paginator
            :rows="state.page.per_page"
            :totalRecords="state.page.total"
            :first="state.page.from - 1"
            @page="fetchClients($event.page + 1)"
        >
            <template #start>
                <span class="text-sm w-20">Total: {{ state.page.total }}</span>
            </template>
            <template #end>
                <div class="w-20 text-right">
                    <i class="pi pi-spin pi-spinner" v-if="state.loading"></i>
                </div>
            </template>
        </Paginator>
    </div>
</template>
