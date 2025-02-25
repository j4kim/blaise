<script setup>
import {
    Button,
    Column,
    DataTable,
    IconField,
    InputIcon,
    InputText,
} from "primevue";
import { useArticlesStore } from "../../stores/articles";
import { confirmDelete, formatDate } from "../../tools";
import { ref } from "vue";
import EditNameDialog from "../../dialogs/EditNameDialog.vue";

const store = useArticlesStore();

const search = ref("");
</script>

<template>
    <div>
        <DataTable
            :value="store.lines"
            paginator
            :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="gammes {first} à {last} sur {totalRecords}"
            :alwaysShowPaginator="false"
            sortField="name"
            :sortOrder="1"
            :filters="{
                global: {
                    value: search,
                },
            }"
            :globalFilterFields="['name']"
        >
            <template #header>
                <div class="flex justify-end gap-3">
                    <Button
                        label="Ajouter"
                        size="small"
                        variant="text"
                        icon="pi pi-plus"
                        @click="store.showAddLineDialog = true"
                    />
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText
                            v-model="search"
                            placeholder="Filtrer"
                            size="small"
                            variant="filled"
                        />
                    </IconField>
                </div>
            </template>
            <template #empty> Aucune marque trouvée </template>
            <Column
                field="created_at"
                header="Création"
                bodyClass="tabular-nums w-32"
                sortable
            >
                <template #body="slotProps">
                    {{ formatDate(slotProps.data.created_at) }}
                </template>
            </Column>
            <Column field="name" header="Nom" sortable></Column>
            <Column
                field="articles_count"
                header="Articles"
                sortable
                bodyClass="tabular-nums w-28"
            ></Column>
            <Column bodyClass="w-28">
                <template #body="{ data }">
                    <div>
                        <Button
                            icon="pi pi-pencil"
                            aria-label="Modifier"
                            size="small"
                            variant="text"
                            rounded
                            severity="secondary"
                            @click="store.openLineEditDialog(data)"
                        />
                        <Button
                            icon="pi pi-trash"
                            aria-label="Supprimer"
                            size="small"
                            variant="text"
                            rounded
                            severity="secondary"
                            :disabled="data.articles_count > 0"
                            @click="
                                confirmDelete(
                                    $confirm,
                                    `Voulez-vous vraiment supprimer la gamme ${data.name} ?`,
                                    () => store.deleteLine(data.id)
                                )
                            "
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
        <EditNameDialog
            header="Modifier la gamme"
            btn="Sauver"
            v-model:visible="store.showEditLineDialog"
            :edited="store.edited"
            @save="store.updateLine"
        />
        <EditNameDialog
            header="Ajouter gamme"
            btn="Créer"
            v-model:visible="store.showAddLineDialog"
            :edited="{}"
            @save="store.createLine"
        />
    </div>
</template>
