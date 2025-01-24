<script setup>
import { reactive } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const state = reactive({
    client: {},
});

async function fetchClient(id) {
    const response = await fetch(`/api/clients/${id}`);
    const data = await response.json();
    return data;
}

state.client = await fetchClient(route.params.id);
</script>

<template>
    <template v-if="state.client">
        <label v-if="state.client.gender == 0">Cliente</label>
        <label v-else>Client</label>
        <h2>{{ state.client.first_name }} {{ state.client.last_name }}</h2>
    </template>
</template>
