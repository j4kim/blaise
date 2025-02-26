<script setup>
import { ref } from "vue";
import { RouterLink, RouterView, useRoute } from "vue-router";
import { del, get, put } from "../../api";
import ClientDetails from "../../components/ClientDetails.vue";
import { Button, Message } from "primevue";
import { confirmDelete, formatDate, pick } from "../../tools";
import EditClientDialog from "../../dialogs/EditClientDialog.vue";

const route = useRoute();

const client = ref({});

const edited = ref({});

const showEditDialog = ref(false);

async function fetchClient(id) {
    const { data, response } = await get(`/api/admin/clients/${id}`);
    if (!response.ok) return;
    client.value = data;
}

fetchClient(route.params.clientId);

async function save(edited) {
    const { data, response } = await put(
        `/api/clients/${route.params.clientId}`,
        edited
    );
    if (!response.ok) return;
    client.value = data;
    showEditDialog.value = false;
}

async function deleteClient() {
    const { data, response } = await del(
        `/api/admin/clients/${client.value.id}`
    );
    if (!response.ok) return;
    client.value = data;
}

function openEditDialog() {
    edited.value = pick(
        client.value,
        "first_name",
        "last_name",
        "gender",
        "tel_1",
        "tel_2",
        "tel_3",
        "npa",
        "location"
    );
    showEditDialog.value = true;
}
</script>

<template>
    <div class="flex flex-col h-full" v-if="client">
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
                {{ client.first_name }} {{ client.last_name }}
            </h2>

            <RouterLink :to="`/clients/${client.id}`">
                <Button
                    size="small"
                    variant="outlined"
                    :disabled="client.deleted_at"
                    icon="pi pi-arrow-up-right"
                    label="Vers ticket"
                ></Button>
            </RouterLink>
        </header>
        <div class="py-2 px-3" v-if="client.deleted_at">
            <Message severity="warn">
                {{ client.title }} supprimé<span v-if="client.gender == 0"
                    >e</span
                >
                le {{ formatDate(client.deleted_at) }}
            </Message>
        </div>
        <div class="py-2 px-3">
            <ClientDetails :client="client"></ClientDetails>
            <div class="flex justify-end gap-2 mt-4">
                <Button
                    v-if="client.deleted_at"
                    @click="save({ deleted_at: null })"
                    label="Restaurer"
                    icon="pi pi-refresh"
                    size="small"
                    variant="text"
                    severity="secondary"
                ></Button>
                <Button
                    :disabled="!!client.deleted_at"
                    @click="
                        confirmDelete(
                            $confirm,
                            `Voulez-vous vraiment supprimer ${client.first_name} ${client.last_name} ?`,
                            deleteClient
                        )
                    "
                    :label="`Supprimer ${client.title?.toLowerCase()}`"
                    icon="pi pi-trash"
                    size="small"
                    variant="text"
                    severity="danger"
                ></Button>
                <Button
                    @click="openEditDialog"
                    :disabled="!!client.deleted_at"
                    label="Modifier les coordonnées"
                    icon="pi pi-pencil"
                    size="small"
                    variant="text"
                    severity="secondary"
                ></Button>
                <EditClientDialog
                    v-model:visible="showEditDialog"
                    :edited="edited"
                    @save="save"
                />
            </div>
        </div>
        <RouterView class="mt-8"></RouterView>
    </div>
</template>
