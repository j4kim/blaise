<script setup>
import { reactive } from "vue";
import { RouterLink, RouterView, useRoute } from "vue-router";
import { del, get, put } from "../../api";
import ClientDetails from "../../components/ClientDetails.vue";
import { Button, Message } from "primevue";
import { confirmDelete, formatDate } from "../../tools";

const route = useRoute();

const state = reactive({ client: null, error: "" });

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

async function deleteClient() {
    const { data, response } = await del(
        `/api/admin/clients/${state.client.id}`
    );
    if (!response.ok) return;
    state.client = data;
}
</script>

<template>
    <div class="flex flex-col h-full" v-if="state.client">
        <header class="py-2 px-3 flex justify-between flex-wrap">
            <h2 class="text-xl font-extralight">
                <RouterLink
                    to="/admin/clients"
                    class="text-muted-color hover:text-color"
                >
                    Clients
                </RouterLink>
                <i
                    class="pi pi-chevron-right text-muted-color"
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
                le {{ formatDate(state.client.deleted_at) }}
            </Message>
        </div>
        <div class="py-2 px-3">
            <ClientDetails
                :client="state.client"
                @save="save"
                :disableBtn="!!state.client.deleted_at"
            >
                <template #buttons>
                    <Button
                        v-if="state.client.deleted_at"
                        @click="save({ deleted_at: null })"
                        label="Restaurer"
                        icon="pi pi-refresh"
                        size="small"
                        variant="text"
                        severity="secondary"
                    ></Button>
                    <Button
                        :disabled="!!state.client.deleted_at"
                        @click="
                            confirmDelete(
                                $confirm,
                                `Voulez-vous vraiment supprimer ${state.client.first_name} ${state.client.last_name} ?`,
                                deleteClient
                            )
                        "
                        label="Supprimer"
                        icon="pi pi-trash"
                        size="small"
                        variant="text"
                        severity="danger"
                    ></Button>
                </template>
            </ClientDetails>
        </div>
        <RouterView></RouterView>
    </div>
</template>
