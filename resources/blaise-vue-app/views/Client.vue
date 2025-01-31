<script setup>
import { reactive, watch } from "vue";
import { useRoute } from "vue-router";
import LastVisits from "../components/LastVisits.vue";
import { Button } from "primevue";
import { useSidebarStore } from "../stores/sidebar";
import { get } from "../api";

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
</script>

<template>
    <div class="mb-8 flex justify-between items-end flex-wrap gap-3">
        <div>
            <h5 class="mb-1">{{ state.client.title }}</h5>
            <h2 class="text-3xl font-extralight">
                {{ state.client.first_name }} {{ state.client.last_name }}
            </h2>
        </div>
        <Button
            label="Nouveau ticket"
            icon="pi pi-plus"
            @click="sidebar.open = !sidebar.open"
            variant="outlined"
        ></Button>
    </div>

    <h5 class="mb-2">Dernières visites</h5>
    <LastVisits :visits="state.client.last_visits"></LastVisits>
</template>
