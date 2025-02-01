<script setup>
import { reactive, ref, shallowRef, watch } from "vue";
import { useRoute } from "vue-router";
import LastVisits from "../components/LastVisits.vue";
import { Button } from "primevue";
import { useSidebarStore } from "../stores/sidebar";
import { get } from "../api";
import CurrentTicket from "./CurrentTicket.vue";

const route = useRoute();

const sidebar = useSidebarStore();

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

const showLastVisits = ref(true);

async function createTicket() {
    sidebar.component = shallowRef(CurrentTicket);
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
