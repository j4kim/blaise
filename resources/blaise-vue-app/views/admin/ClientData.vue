<script setup>
import { reactive } from "vue";
import { RouterLink, RouterView, useRoute } from "vue-router";
import { get, put } from "../../api";
import ClientDetails from "../../components/ClientDetails.vue";
import { Button, Message } from "primevue";
import dayjs from "dayjs";

const route = useRoute();

const state = reactive({ client: {} });

async function fetchClient(id) {
    const { data, response } = await get(`/api/admin/clients/${id}`);
    if (!response.ok) return;
    state.client = data;
}

fetchClient(route.params.clientId);

async function save(edited) {
    const { data, response } = await put(
        `/api/clients/${route.params.clientId}`,
        edited
    );
    if (!response.ok) return;
    state.client = data;
}
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex justify-between flex-wrap">
            <h2 class="text-xl font-extralight">
                <RouterLink
                    to="/admin/clients"
                    class="opacity-50 hover:opacity-100"
                >
                    Clients
                </RouterLink>
                <i
                    class="pi pi-chevron-right opacity-50"
                    style="font-size: 0.7rem"
                ></i>
                {{ state.client.first_name }} {{ state.client.last_name }}
            </h2>

            <RouterLink :to="`/clients/${state.client.id}`">
                <Button
                    size="small"
                    variant="outlined"
                    :disabled="state.client.deleted_at"
                    icon="pi pi-arrow-up-right"
                    label="Vers ticket"
                ></Button>
            </RouterLink>
        </header>
        <div class="py-2 px-3" v-if="state.client.deleted_at">
            <Message severity="warn">
                {{ state.client.title }} supprimé<span
                    v-if="state.client.gender == 0"
                    >e</span
                >
                le {{ dayjs(state.client.deleted_at).format("DD.MM.YYYY") }}
            </Message>
        </div>
        <div class="py-2 px-3">
            <ClientDetails
                :client="state.client"
                @save="save"
                :disableBtn="!!state.client.deleted_at"
            />
        </div>
        <RouterView></RouterView>
    </div>
</template>
