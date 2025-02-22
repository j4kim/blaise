<script setup>
import { reactive } from "vue";
import { useRoute } from "vue-router";
import { get } from "../../api";
import { Column, DataTable } from "primevue";
import dayjs from "dayjs";

const route = useRoute();

const state = reactive({ visits: [] });

async function fetchVisits(id) {
    const { data, response } = await get(`/api/admin/clients/${id}/visits`);
    if (!response.ok) return;
    state.visits = data;
}

fetchVisits(route.params.clientId);
</script>

<template>
    <div class="py-2 px-3">
        <h2 class="text-xl font-extralight mb-2">Toutes les visites</h2>
        <DataTable
            :value="state.visits"
            paginator
            :rows="10"
            @row-click="
                ({ data }) =>
                    $router.push(
                        `/admin/clients/${route.params.clientId}/visit/${data.id}`
                    )
            "
            selectionMode="single"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="visites {first} à {last} sur {totalRecords}"
            stateStorage="session"
            :stateKey="`${$route.params.clientId}-visits`"
        >
            <Column field="id" header="ID" sortable bodyClass="tabular-nums">
            </Column>
            <Column
                field="created_at"
                header="Date de la visite"
                sortable
                bodyClass="tabular-nums"
            >
                <template #body="{ data }">
                    {{ dayjs(data.visit_date).format("DD.MM.YYYY HH:mm") }}
                </template>
            </Column>
            <Column field="billed" header="Total CHF" sortable> </Column>
        </DataTable>
    </div>
</template>
