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
import dayjs from "dayjs";

const route = useRoute();

const visit = useVisitStore();

await visit.fetchClient(route.params.id);

onBeforeRouteUpdate((to, from) => {
    if (to.params.id !== from.params.id) {
        visit.fetchClient(to.params.id);
    }
});

onBeforeRouteLeave(() => (visit.current = null));
</script>

<template v-if="visit.client">
    <div class="mt-2 mb-8 flex justify-between items-end flex-wrap gap-3">
        <div>
            <h5 class="mb-1">{{ visit.client.title }}</h5>
            <h2 class="text-3xl font-extralight">
                {{ visit.client.first_name }} {{ visit.client.last_name }}
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
            @click="visit.showClientDetails = !visit.showClientDetails"
            :class="{
                'text-muted-color': !visit.showClientDetails,
            }"
        >
            <i
                class="pi pi-angle-right transition"
                :class="{ 'rotate-90': visit.showClientDetails }"
            ></i>
            Coordonnées
        </h5>
        <div
            v-if="visit.showClientDetails"
            class="grid lg:grid-cols-3 grid-cols-2 gap-4"
        >
            <dl>
                <dt class="text-sm text-muted-color">Prénom</dt>
                <dd>{{ visit.client.first_name }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Nom</dt>
                <dd>{{ visit.client.last_name }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Date de création</dt>
                <dd>
                    {{ dayjs(visit.client.created_at).format("DD.MM.YYYY") }}
                </dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Ville</dt>
                <dd>{{ visit.client.npa }} {{ visit.client.location }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Téléphone</dt>
                <dd>{{ visit.client.tel_1 }}</dd>
                <dd>{{ visit.client.tel_2 }}</dd>
                <dd>{{ visit.client.tel_3 }}</dd>
            </dl>
        </div>
    </div>

    <div class="mb-8">
        <h5
            class="mb-2 inline-block cursor-pointer hover:text-color"
            @click="visit.showClientLastVisits = !visit.showClientLastVisits"
            :class="{
                'text-muted-color': !visit.showClientLastVisits,
            }"
        >
            <i
                class="pi pi-angle-right transition"
                :class="{ 'rotate-90': visit.showClientLastVisits }"
            ></i>
            Dernières visites
        </h5>
        <LastVisits
            v-if="visit.showClientLastVisits"
            :visits="visit.client.last_visits"
        ></LastVisits>
    </div>

    <RouterView class="mb-6 md:mb-8" v-if="visit.current" />
</template>
