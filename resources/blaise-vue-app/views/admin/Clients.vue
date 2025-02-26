<script setup>
import {
    Button,
    Column,
    DataTable,
    IconField,
    InputIcon,
    InputText,
    Paginator,
    SelectButton,
} from "primevue";
import EditClientDialog from "../../dialogs/EditClientDialog.vue";
import { useAdminClientsStore } from "../../stores/admin/clients";
import { formatDate } from "../../tools";

const store = useAdminClientsStore();

store.fetchClients();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <span class="text-xl font-extralight">Clients</span>

            <div class="grow"></div>

            <Button
                label="Ajouter"
                size="small"
                variant="text"
                icon="pi pi-user-plus"
                @click="store.showAddDialog = true"
            />
            <EditClientDialog
                header="Ajouter un·e client·e"
                btn="Créer"
                v-model:visible="store.showAddDialog"
                :edited="{}"
                @save="store.create"
            />

            <SelectButton
                v-model="store.queryParams.filter"
                @change="() => (store.queryParams.page = 1)"
                :options="[
                    { value: 'all', label: 'Tous' },
                    { value: 'active', label: 'Actifs' },
                    { value: 'trashed', label: 'Supprimés' },
                ]"
                optionValue="value"
                optionLabel="label"
                size="small"
            />

            <IconField>
                <InputIcon>
                    <i class="pi pi-search" />
                </InputIcon>
                <InputText
                    class="w-56"
                    size="small"
                    v-model="store.search"
                    placeholder="Filtrer par nom ou prénom"
                    variant="filled"
                />
            </IconField>
        </header>

        <DataTable
            :value="store.paginator.data"
            scrollable
            scrollHeight="100%"
            class="grow overflow-auto"
            :rowClass="(row) => (row.deleted_at ? '!text-muted-color' : '')"
            lazy
            @sort="store.sort"
            @row-click="({ data }) => $router.push(`/admin/clients/${data.id}`)"
            selectionMode="single"
            sortField="updated_at"
            :sortOrder="-1"
            :loading="store.loading"
            stateStorage="local"
            stateKey="dt-clients"
        >
            <Column
                field="created_at"
                header="Création"
                bodyClass="tabular-nums"
                sortable
            >
                <template #body="slotProps">
                    {{ formatDate(slotProps.data.created_at) }}
                </template>
            </Column>
            <Column
                field="updated_at"
                header="Mise à jour"
                bodyClass="tabular-nums"
                sortable
            >
                <template #body="slotProps">
                    {{ formatDate(slotProps.data.updated_at) }}
                </template>
            </Column>
            <Column
                v-if="store.queryParams.filter === 'trashed'"
                field="deleted_at"
                header="Suppression"
                bodyClass="tabular-nums"
                sortable
            >
                <template #body="slotProps">
                    {{ formatDate(slotProps.data.deleted_at) }}
                </template>
            </Column>
            <Column field="first_name" header="Prénom" sortable></Column>
            <Column field="last_name" header="Nom" sortable></Column>
            <Column field="gender" header="Genre" sortable>
                <template #body="{ data }">
                    {{ ["F", "H"][data.gender] }}
                </template>
            </Column>
            <Column field="visits_count" header="Visites" sortable></Column>
        </DataTable>

        <Paginator
            :rows="store.paginator.per_page"
            :totalRecords="store.paginator.total"
            :first="store.paginator.from - 1"
            @page="store.queryParams.page = $event.page + 1"
            template="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="clients {first} à {last} sur {totalRecords}"
        />
    </div>
</template>
