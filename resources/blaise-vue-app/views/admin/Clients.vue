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
import { reactive, ref, watch } from "vue";
import { get, post } from "../../api";
import dayjs from "dayjs";
import { watchDebounced } from "@vueuse/core";
import EditClientDialog from "../../dialogs/EditClientDialog.vue";
import { useRouter } from "vue-router";

const router = useRouter();

const state = reactive({
    paginator: {},
    loading: false,
    params: { page: 1, search: "", filter: "active" },
});

const search = ref("");

const showAddDialog = ref(false);

async function fetchClients() {
    state.loading = true;
    const { data, response } = await get("/api/admin/clients", state.params);
    state.loading = false;
    if (!response.ok) return;
    state.paginator = data;
}

async function create(client) {
    const { data, response } = await post("/api/admin/clients", client);
    if (!response.ok) return;
    showAddDialog.value = false;
    router.push(`/admin/clients/${data.id}`);
}

watch(state.params, fetchClients, { immediate: true });

watchDebounced(search, (v) => (state.params.search = v), {
    debounce: 500,
});

function formatDate(isoDate) {
    const date = dayjs(isoDate);
    return date.isValid() ? date.format("DD.MM.YY") : isoDate;
}

function formatTel(row) {
    return ["tel_1", "tel_2", "tel_3"]
        .map((name) => row[name])
        .filter((v) => v)
        .join(", ");
}

function sort(e) {
    state.params.sortField = e.sortField;
    state.params.sortOrder = e.sortOrder === 1 ? "asc" : "desc";
    state.params.page = 1;
}
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
                @click="showAddDialog = true"
            />
            <EditClientDialog
                header="Ajouter un·e client·e"
                btn="Créer"
                v-model:visible="showAddDialog"
                :edited="{}"
                @save="create"
            />

            <SelectButton
                v-model="state.params.filter"
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
                    v-model="search"
                    placeholder="Filtrer par nom ou prénom"
                    variant="filled"
                />
            </IconField>
        </header>

        <DataTable
            :value="state.paginator.data"
            scrollable
            scrollHeight="100%"
            class="grow overflow-auto"
            :rowClass="(row) => (row.deleted_at ? '!text-muted-color' : '')"
            lazy
            @sort="sort"
            @row-click="({ data }) => $router.push(`/admin/clients/${data.id}`)"
            selectionMode="single"
        >
            <Column field="id" header="ID" sortable></Column>
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
            <Column field="first_name" header="Prénom" sortable></Column>
            <Column field="last_name" header="Nom" sortable></Column>
            <Column header="Tel" bodyClass="min-w-44">
                <template #body="{ data }">
                    {{ formatTel(data) }}
                </template>
            </Column>
            <Column field="npa" header="Ville" bodyClass="min-w-32" sortable>
                <template #body="{ data }">
                    {{ data.npa }} {{ data.location }}
                </template>
            </Column>
            <Column field="gender" header="Genre" sortable>
                <template #body="{ data }">
                    {{ ["F", "H"][data.gender] }}
                </template>
            </Column>
            <Column field="visits_count" header="Visites" sortable></Column>
        </DataTable>

        <Paginator
            :rows="state.paginator.per_page"
            :totalRecords="state.paginator.total"
            :first="state.paginator.from - 1"
            @page="state.params.page = $event.page + 1"
        >
            <template #start>
                <span class="text-sm w-20">
                    Total: {{ state.paginator.total }}
                </span>
            </template>
            <template #end>
                <div class="w-20 text-right">
                    <i class="pi pi-spin pi-spinner" v-if="state.loading"></i>
                </div>
            </template>
        </Paginator>
    </div>
</template>
