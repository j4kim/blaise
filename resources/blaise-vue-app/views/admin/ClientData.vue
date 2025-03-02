<script setup>
import { ref } from "vue";
import ClientDetails from "../../components/ClientDetails.vue";
import { Button } from "primevue";
import { confirmDelete, pick } from "../../tools";
import EditClientDialog from "../../dialogs/EditClientDialog.vue";
import { useAdminClientsStore } from "../../stores/admin/clients";

const store = useAdminClientsStore();

const edited = ref({});

function openEditDialog() {
    edited.value = pick(
        store.client,
        "first_name",
        "last_name",
        "gender",
        "tel_1",
        "tel_2",
        "tel_3",
        "npa",
        "location",
        "type",
        "email"
    );
    store.showEditDialog = true;
}
</script>

<template>
    <div class="py-2 px-3">
        <ClientDetails :client="store.client"></ClientDetails>
        <div class="flex justify-end gap-2 mt-4">
            <Button
                v-if="store.client.deleted_at"
                @click="store.save({ deleted_at: null })"
                label="Restaurer"
                icon="pi pi-refresh"
                size="small"
                variant="text"
                severity="secondary"
            ></Button>
            <Button
                :disabled="!!store.client.deleted_at"
                @click="
                    confirmDelete(
                        $confirm,
                        `Voulez-vous vraiment supprimer ${store.client.first_name} ${store.client.last_name} ?`,
                        store.deleteClient
                    )
                "
                :label="`Supprimer ${store.client.title?.toLowerCase()}`"
                icon="pi pi-trash"
                size="small"
                variant="text"
                severity="danger"
            ></Button>
            <Button
                @click="openEditDialog"
                :disabled="!!store.client.deleted_at"
                label="Modifier les coordonnées"
                icon="pi pi-pencil"
                size="small"
                variant="text"
                severity="secondary"
            ></Button>
            <EditClientDialog
                v-model:visible="store.showEditDialog"
                :edited="edited"
                @save="store.save"
            />
        </div>
    </div>
</template>
