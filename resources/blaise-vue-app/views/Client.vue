<script setup>
import { reactive, ref, shallowRef, watch } from "vue";
import { useRoute } from "vue-router";
import LastVisits from "../components/LastVisits.vue";
import { Button } from "primevue";
import { useSidebarStore } from "../stores/sidebar";
import { get } from "../api";
import CurrentVisit from "./CurrentVisit.vue";
import { useVisitStore } from "../stores/visit";
import dayjs from "dayjs";

const route = useRoute();

const sidebar = useSidebarStore();
const visit = useVisitStore();

const state = reactive({
    client: {},
});

watch(
    () => route.params.id,
    async (id) => {
        state.client = (await get(`/api/clients/${id}`)).data;
    },
    { immediate: true }
);

const showDetails = ref(false);
const showLastVisits = ref(true);

async function createTicket() {
    await visit.create(state.client);
    sidebar.component = shallowRef(CurrentVisit);
    showLastVisits.value = false;
}
</script>

<template>
    <div class="mt-2 mb-12 flex justify-between items-end flex-wrap gap-3">
        <div>
            <h5 class="mb-1">{{ state.client.title }}</h5>
            <h2 class="text-3xl font-extralight">
                {{ state.client.first_name }} {{ state.client.last_name }}
            </h2>
        </div>
        <Button
            v-if="!sidebar.component"
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
                <dd>{{ state.client.first_name }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Nom</dt>
                <dd>{{ state.client.last_name }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Date de création</dt>
                <dd>
                    {{ dayjs(state.client.created_at).format("DD.MM.YYYY") }}
                </dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Ville</dt>
                <dd>{{ state.client.npa }} {{ state.client.location }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Téléphone</dt>
                <dd>{{ state.client.tel_1 }}</dd>
                <dd>{{ state.client.tel_2 }}</dd>
                <dd>{{ state.client.tel_3 }}</dd>
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
            :visits="state.client.last_visits"
        ></LastVisits>
    </div>
</template>
