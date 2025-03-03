<script setup>
import {
    onBeforeRouteLeave,
    onBeforeRouteUpdate,
    RouterView,
    useRoute,
} from "vue-router";
import LastVisits from "../components/LastVisits.vue";
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";
import { useClientStore } from "../stores/client";
import ClientDetails from "../components/ClientDetails.vue";
import LastTechnicalSheets from "../components/LastTechnicalSheets.vue";

const route = useRoute();

const visit = useVisitStore();
const client = useClientStore();

client.fetchClient(route.params.id);

onBeforeRouteUpdate((to, from) => {
    if (to.params.id !== from.params.id) {
        client.fetchClient(to.params.id);
    }
});

onBeforeRouteLeave(() => (visit.current = null));
</script>

<template>
    <div
        class="sm:max-w-screen-md sm:mx-auto px-2 py-4 h-full flex flex-col gap-7"
        v-if="client.selected"
    >
        <div class="flex justify-between items-end flex-wrap gap-3">
            <div>
                <h5 class="mb-1">
                    {{ client.selected.gender === 0 ? "Cliente" : "Client" }}
                </h5>
                <h2 class="text-3xl font-extralight">
                    {{ client.selected.first_name }}
                    {{ client.selected.last_name }}
                </h2>
            </div>
            <Button
                v-if="!visit.current"
                label="Nouveau ticket"
                icon="pi pi-plus"
                @click="visit.create"
                variant="outlined"
            ></Button>
        </div>

        <div>
            <h5
                class="inline-block cursor-pointer hover:text-color"
                @click="client.showDetails = !client.showDetails"
                :class="{
                    'text-muted-color': !client.showDetails,
                }"
            >
                <i
                    class="pi pi-angle-right transition"
                    :class="{ 'rotate-90': client.showDetails }"
                ></i>
                Coordonnées
            </h5>
            <ClientDetails
                v-if="client.showDetails"
                :client="client.selected"
                class="mt-2 mb-4"
            ></ClientDetails>
        </div>

        <div v-if="client.selected.visits_count > 0">
            <h5
                class="inline-block cursor-pointer hover:text-color"
                @click="client.showLastVisits = !client.showLastVisits"
                :class="{
                    'text-muted-color': !client.showLastVisits,
                }"
            >
                <i
                    class="pi pi-angle-right transition"
                    :class="{ 'rotate-90': client.showLastVisits }"
                ></i>
                Dernières visites
            </h5>
            <LastVisits
                v-if="client.showLastVisits"
                :client="client.selected"
                class="mb-4"
            ></LastVisits>
        </div>

        <div v-if="client.selected.technical_sheets_count > 0">
            <h5
                class="inline-block cursor-pointer hover:text-color"
                @click="
                    client.showTechnicalSheets = !client.showTechnicalSheets
                "
                :class="{
                    'text-muted-color': !client.showTechnicalSheets,
                }"
            >
                <i
                    class="pi pi-angle-right transition"
                    :class="{ 'rotate-90': client.showTechnicalSheets }"
                ></i>
                Fiches techniques
            </h5>
            <LastTechnicalSheets
                v-if="client.showTechnicalSheets"
                :client="client.selected"
                class="mb-4"
            />
        </div>

        <RouterView class="mb-6 md:mb-8" v-if="visit.current" />
    </div>
</template>
