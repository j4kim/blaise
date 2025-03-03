<script setup>
import { useRouter } from "vue-router";
import { Column, DataTable } from "primevue";
import { formatDate } from "../../tools";
import { useAdminClientsStore } from "../../stores/admin/clients";

const router = useRouter();

const store = useAdminClientsStore();

store.fetchVisits();

function goToVisitDetails({ data }) {
    store.visit = data;
    router.push(`/admin/clients/${store.client.id}/visits/${data.id}`);
}
</script>

<template>
    <div class="py-2 px-3">
        <h2 class="text-xl font-extralight mb-4">Toutes les visites</h2>
        <DataTable
            :value="store.visits"
            paginator
            :rows="10"
            @row-click="goToVisitDetails"
            selectionMode="single"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="visites {first} à {last} sur {totalRecords}"
            stateStorage="session"
            :stateKey="`${$route.params.clientId}-visits`"
            :alwaysShowPaginator="false"
            :rowClass="
                (row) =>
                    row.deleted_at ? '!text-muted-color line-through' : ''
            "
        >
            <Column
                field="visit_date"
                header="Date de la visite"
                sortable
                bodyClass="tabular-nums"
            >
                <template #body="{ data }">
                    {{ formatDate(data.visit_date, true) }}
                </template>
            </Column>
            <Column field="billed" header="Total CHF" sortable> </Column>
        </DataTable>
    </div>
</template>
