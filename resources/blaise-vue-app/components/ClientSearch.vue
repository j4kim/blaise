<script setup>
import { Card, IconField, InputIcon, InputText } from "primevue";
import { reactive } from "vue";

const state = reactive({
    query: "",
    clients: [],
});

async function search() {
    if (state.query.length < 2) {
        state.clients = [];
        return;
    }
    const response = await fetch(`/api/clients/search/${state.query}`);
    const data = await response.json();
    state.clients = data;
}
</script>

<template>
    <IconField>
        <InputIcon class="pi pi-search" />
        <InputText
            placeholder="Recherche client-e"
            v-model="state.query"
            @input="search"
        />
    </IconField>

    <div class="space-y-2 my-2">
        <Card
            v-for="client in state.clients"
            @click="$router.push(`clients/${client.id}`)"
            class="cursor-pointer"
        >
            <template #content>
                <div>{{ client.first_name }} {{ client.last_name }}</div>
            </template>
        </Card>
    </div>
</template>
