<script setup>
import { reactive } from "vue";
import { useRoute } from "vue-router";
import { get } from "../../api";
import { Column, DataTable } from "primevue";
import { formatDate } from "../../tools";

const route = useRoute();

const state = reactive({ sheets: [] });

async function fetchSheets(id) {
    const { data, response } = await get(`/api/admin/clients/${id}/sheets`);
    if (!response.ok) return;
    state.sheets = data;
}

fetchSheets(route.params.clientId);
</script>

<template>
    <div class="py-2 px-3">
        <h2 class="text-xl font-extralight mb-4">Fiches techniques</h2>
        <DataTable
            :value="state.sheets"
            paginator
            :rows="10"
            @row-click="console.log"
            selectionMode="single"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="fiches {first} à {last} sur {totalRecords}"
            stateStorage="session"
            :stateKey="`${$route.params.clientId}-sheets`"
            :alwaysShowPaginator="false"
            :rowClass="
                (row) =>
                    row.deleted_at ? '!text-muted-color line-through' : ''
            "
        >
            <template #empty> Aucune fiche technique </template>
            <Column
                field="created_at"
                header="Date de création"
                sortable
                bodyClass="tabular-nums"
            >
                <template #body="{ data }">
                    {{ formatDate(data.created_at, true) }}
                </template>
            </Column>
            <Column field="notes" header="Notes" sortable> </Column>
            <Column field="visit_id" header="ID visite" sortable> </Column>
        </DataTable>
    </div>
</template>
