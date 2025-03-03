<script setup>
import { RouterLink, useRoute } from "vue-router";
import { Button, Column, DataTable } from "primevue";
import { formatDate } from "../../tools";
import { useAdminClientsStore } from "../../stores/admin/clients";

const route = useRoute();

const store = useAdminClientsStore();

store.fetchSheets(route.params.clientId);
</script>

<template>
    <div class="py-2 px-3">
        <h2 class="text-xl font-extralight mb-4">Fiches techniques</h2>
        <DataTable
            :value="store.sheets"
            paginator
            :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="fiches {first} à {last} sur {totalRecords}"
            stateStorage="session"
            :stateKey="`${$route.params.clientId}-sheets`"
            :alwaysShowPaginator="false"
        >
            <template #empty> Aucune fiche technique </template>
            <Column
                field="created_at"
                header="Date de création"
                sortable
                bodyClass="tabular-nums"
            >
                <template #body="{ data }">
                    {{ formatDate(data.created_at) }}
                </template>
            </Column>
            <Column
                field="notes"
                header="Notes"
                sortable
                bodyClass="whitespace-pre-line"
            ></Column>
            <Column field="visit_id" header="ID visite" sortable>
                <template #body="{ data }">
                    <RouterLink
                        v-if="data.visit_id"
                        :to="`/admin/clients/${$route.params.clientId}/visits/${data.visit_id}`"
                    >
                        <Button
                            class="tabular-nums"
                            size="small"
                            variant="text"
                        >
                            {{ data.visit_id }}
                        </Button>
                    </RouterLink>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
