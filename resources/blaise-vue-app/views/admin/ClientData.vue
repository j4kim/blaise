<script setup>
import { reactive } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { get, put } from "../../api";
import ClientDetails from "../../components/ClientDetails.vue";
import { Message } from "primevue";
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
            <span class="text-xl font-extralight">
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
            </span>
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
                :disableBtn="state.client.deleted_at"
            >
                <dl>
                    <dt class="text-sm text-muted-color">Genre</dt>
                    <dd>
                        {{ ["Femme", "Homme"][state.client.gender] }}
                    </dd>
                </dl>
            </ClientDetails>
        </div>
    </div>
</template>
