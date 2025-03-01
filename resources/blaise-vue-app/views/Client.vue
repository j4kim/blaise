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
        class="sm:max-w-screen-md sm:mx-auto px-2 py-4 h-full"
        v-if="client.selected"
    >
        <div class="mt-2 mb-8 flex justify-between items-end flex-wrap gap-3">
            <div>
                <h5 class="mb-1">{{ client.selected.title }}</h5>
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

        <div class="mb-8">
            <h5
                class="mb-2 inline-block cursor-pointer hover:text-color"
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
            ></ClientDetails>
        </div>

        <div class="mb-8">
            <h5
                class="mb-2 inline-block cursor-pointer hover:text-color"
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
            ></LastVisits>
        </div>

        <RouterView class="mb-6 md:mb-8" v-if="visit.current" />
    </div>
</template>
