<script setup>
import { computed } from "vue";
import { RouterLink, RouterView, useRoute, useRouter } from "vue-router";
import { Button, Message, Tab, TabList, Tabs } from "primevue";
import { formatDate } from "../../tools";
import { useAdminClientsStore } from "../../stores/admin/clients";

const route = useRoute();
const router = useRouter();

const store = useAdminClientsStore();

store.fetchClient(route.params.clientId);

const tabRoutes = {
    clientData: `/admin/clients/${route.params.clientId}`,
    clientVisits: `/admin/clients/${route.params.clientId}/visits`,
    clientSheets: `/admin/clients/${route.params.clientId}/sheets`,
};

const tab = computed({
    get: () => route.meta.tabRoute,
    set: (v) => router.push(tabRoutes[v]),
});
</script>

<template>
    <div class="flex flex-col h-full" v-if="store.client">
        <header class="py-2 px-3 flex justify-between flex-wrap">
            <h2 class="text-xl font-extralight">
                <RouterLink
                    to="/admin/clients"
                    class="text-muted-color hover:text-color"
                >
                    Clients
                </RouterLink>
                <i
                    class="pi pi-chevron-right text-muted-color"
                    style="font-size: 0.7rem"
                ></i>
                {{ store.client.first_name }} {{ store.client.last_name }}
            </h2>

            <RouterLink :to="`/clients/${store.client.id}`">
                <Button
                    size="small"
                    variant="outlined"
                    :disabled="store.client.deleted_at"
                    icon="pi pi-arrow-up-right"
                    label="Vers ticket"
                ></Button>
            </RouterLink>
        </header>
        <div class="py-2 px-3" v-if="store.client.deleted_at">
            <Message severity="warn">
                {{ store.client.title }} supprimé<span
                    v-if="store.client.gender == 0"
                    >e</span
                >
                le {{ formatDate(store.client.deleted_at) }}
            </Message>
        </div>
        <Tabs v-model:value="tab">
            <TabList>
                <Tab value="clientData"> Coordonnées </Tab>
                <Tab value="clientVisits"> Visites </Tab>
                <Tab value="clientSheets"> Fiches techniques </Tab>
            </TabList>
        </Tabs>
        <RouterView class="mt-4" />
    </div>
</template>
