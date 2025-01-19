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
    <label>Cliente</label>
    <template v-if="state.client">
        <h2>{{ state.client.first_name }} {{ state.client.last_name }}</h2>
    </template>
</template>
