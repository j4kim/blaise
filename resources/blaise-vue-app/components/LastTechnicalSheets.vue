<script setup>
import { Button, Column, DataTable } from "primevue";
import { RouterLink } from "vue-router";
import { formatDate } from "../tools";
import { useClientStore } from "../stores/client";

const client = useClientStore();
</script>

<template>
    <DataTable :value="client.selected.last_technical_sheets" size="small">
        <template #empty> Aucune fiche technique </template>
        <Column field="created_at" header="Date de création">
            <template #body="{ data }">
                {{ formatDate(data.created_at) }}
            </template>
        </Column>
        <Column field="notes" header="Notes"></Column>
    </DataTable>
    <RouterLink
        v-if="client.selected.technical_sheets_count > 5"
        :to="`/admin/clients/${client.selected.id}/sheets`"
    >
        <Button
            :label="`Voir toutes les fiches techniques (${client.selected.technical_sheets_count})`"
            size="small"
            variant="text"
            severity="secondary"
            class="mt-2"
        ></Button>
    </RouterLink>
</template>
