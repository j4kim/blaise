<script setup>
import { reactive, watch } from "vue";
import { useRoute } from "vue-router";
import LastVisits from "../components/LastVisits.vue";
import { Button } from "primevue";

const route = useRoute();

const state = reactive({
    client: {},
});

async function fetchClient(id) {
    const response = await fetch(`/api/clients/${id}`);
    const data = await response.json();
    return data;
}

watch(
    () => route.params.id,
    async (id) => {
        state.client = await fetchClient(id);
    },
    { immediate: true }
);
</script>

<template>
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h5 class="mb-1">{{ state.client.title }}</h5>
            <h2 class="text-3xl font-extralight">
                {{ state.client.first_name }} {{ state.client.last_name }}
            </h2>
        </div>
        <Button label="Nouveau ticket" icon="pi pi-plus" />
    </div>

    <h5 class="mb-2">Dernières visites</h5>
    <LastVisits :visits="state.client.last_visits"></LastVisits>
</template>
