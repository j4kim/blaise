<script setup>
import { reactive, watch } from "vue";
import { useRoute } from "vue-router";
import LastVisits from "../components/LastVisits.vue";

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
    <h5>{{ state.client.title }}</h5>
    <h2 class="text-3xl font-extralight mb-8">
        {{ state.client.first_name }} {{ state.client.last_name }}
    </h2>

    <h5>Dernières visites</h5>
    <LastVisits :visits="state.client.last_visits"></LastVisits>
</template>
