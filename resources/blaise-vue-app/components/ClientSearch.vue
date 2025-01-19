<script setup>
import { Card, IconField, InputIcon, InputText } from "primevue";
import { reactive } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

const state = reactive({
    query: "",
    clients: [],
    selected: -1,
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

function select(n) {
    if (n >= state.clients.length || n < -1) return;
    state.selected = n;
}

function to(client) {
    if (!client) return;
    router.push(`clients/${client.id}`);
}
</script>

<template>
    <IconField>
        <InputIcon class="pi pi-search" />
        <InputText
            placeholder="Recherche client-e"
            v-model="state.query"
            @input="search"
            @keydown.up.prevent="select(state.selected - 1)"
            @keydown.down.prevent="select(state.selected + 1)"
            @keydown.enter.prevent="to(state.clients[state.selected])"
        />
    </IconField>

    <div class="space-y-2 my-2">
        <Card
            v-for="(client, index) in state.clients"
            @click="to(client)"
            :class="[
                'cursor-pointer hover:bg-primary',
                {
                    '!bg-primary': state.selected === index,
                },
            ]"
        >
            <template #content>
                <div>{{ client.first_name }} {{ client.last_name }}</div>
            </template>
        </Card>
    </div>
</template>
