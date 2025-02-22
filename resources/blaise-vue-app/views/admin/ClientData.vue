<script setup>
import { reactive } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { get, put } from "../../api";
import ClientDetails from "../../components/ClientDetails.vue";
import { Button, Column, DataTable, Message } from "primevue";
import dayjs from "dayjs";

const route = useRoute();

const state = reactive({ client: {}, visits: [] });

async function fetchClient(id) {
    const { data, response } = await get(`/api/admin/clients/${id}`);
    if (!response.ok) return;
    state.client = data;
}

async function fetchVisits(id) {
    const { data, response } = await get(`/api/admin/clients/${id}/visits`);
    if (!response.ok) return;
    state.visits = data;
}

fetchClient(route.params.clientId);
fetchVisits(route.params.clientId);

async function save(edited) {
    const { data, response } = await put(
        `/api/clients/${route.params.clientId}`,
        edited
    );
    if (!response.ok) return;
    state.client = data;
}
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex justify-between flex-wrap">
            <h2 class="text-xl font-extralight">
                <RouterLink
                    to="/admin/clients"
                    class="opacity-50 hover:opacity-100"
                >
                    Clients
                </RouterLink>
                <i
                    class="pi pi-chevron-right opacity-50"
                    style="font-size: 0.7rem"
                ></i>
                {{ state.client.first_name }} {{ state.client.last_name }}
            </h2>
        </header>
        <div class="py-2 px-3" v-if="state.client.deleted_at">
            <Message severity="warn">
                {{ state.client.title }} supprimé<span
                    v-if="state.client.gender == 0"
                    >e</span
                >
                le {{ dayjs(state.client.deleted_at).format("DD.MM.YYYY") }}
            </Message>
        </div>
        <div class="py-2 px-3">
            <ClientDetails
                :client="state.client"
                @save="save"
                :disableBtn="!!state.client.deleted_at"
            >
                <dl>
                    <dt class="text-sm text-muted-color">Genre</dt>
                    <dd>
                        {{ ["Femme", "Homme"][state.client.gender] }}
                    </dd>
                </dl>
            </ClientDetails>
        </div>
        <div class="py-2 px-3">
            <RouterLink :to="`/clients/${state.client.id}`">
                <Button
                    size="small"
                    variant="outlined"
                    :disabled="state.client.deleted_at"
                >
                    Vers ticket
                </Button>
            </RouterLink>
        </div>
        <div class="py-2 px-3">
            <h2 class="text-xl font-extralight">Toutes les visites</h2>
            <DataTable
                :value="state.visits"
                paginator
                :rows="10"
                @row-click="
                    ({ data }) =>
                        $router.push(
                            `/admin/clients/${state.client.id}/visit/${data.id}`
                        )
                "
                selectionMode="single"
                paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
                currentPageReportTemplate="visites {first} à {last} sur {totalRecords}"
            >
                <Column
                    field="id"
                    header="ID"
                    sortable
                    bodyClass="tabular-nums"
                >
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
    </div>
</template>
