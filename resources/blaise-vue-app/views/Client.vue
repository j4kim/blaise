<script setup>
import { ref } from "vue";
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

const showDetails = ref(false);
const showLastVisits = ref(true);

async function createTicket() {
    await visit.create();
    showDetails.value = false;
    showLastVisits.value = false;
}

await visit.fetchClient(route.params.id);

onBeforeRouteUpdate((to, from) => {
    if (to.params.id !== from.params.id) {
        visit.fetchClient(to.params.id);
    }
});

onBeforeRouteLeave(() => (visit.current = null));
</script>

<template v-if="visit.client">
    <div class="mt-2 mb-12 flex justify-between items-end flex-wrap gap-3">
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
            @click="createTicket"
            variant="outlined"
        ></Button>
    </div>

    <div class="mb-12">
        <h5
            class="mb-2 inline-block cursor-pointer hover:text-color"
            @click="showDetails = !showDetails"
            :class="{
                'text-muted-color': !showDetails,
            }"
        >
            <i
                class="pi pi-angle-right transition"
                :class="{ 'rotate-90': showDetails }"
            ></i>
            Coordonnées
        </h5>
        <div v-if="showDetails" class="grid lg:grid-cols-3 grid-cols-2 gap-4">
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

    <div class="mb-12">
        <h5
            class="mb-2 inline-block cursor-pointer hover:text-color"
            @click="showLastVisits = !showLastVisits"
            :class="{
                'text-muted-color': !showLastVisits,
            }"
        >
            <i
                class="pi pi-angle-right transition"
                :class="{ 'rotate-90': showLastVisits }"
            ></i>
            Dernières visites
        </h5>
        <LastVisits
            v-if="showLastVisits"
            :visits="visit.client.last_visits"
        ></LastVisits>
    </div>

    <RouterView class="mb-6 md:mb-12" v-if="visit.current" />
</template>
