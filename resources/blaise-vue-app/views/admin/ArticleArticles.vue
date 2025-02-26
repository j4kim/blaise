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
import EditArticleDialog from "../../dialogs/EditArticleDialog.vue";

const store = useArticlesStore();
</script>

<template>
    <div>
        <DataTable
            :value="store.filteredArticles"
            paginator
            :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="articles {first} à {last} sur {totalRecords}"
            sortField="sort_order"
            :sortOrder="1"
        >
            <template #header>
                <div class="flex justify-end gap-3">
                    <Button
                        label="Ajouter"
                        size="small"
                        variant="text"
                        icon="pi pi-plus"
                        @click="store.showAddArticleDialog = 1"
                    />
                    <IconField>
                        <InputIcon>
                            <i class="pi pi-search" />
                        </InputIcon>
                        <InputText
                            v-model="store.articleFilter"
                            placeholder="Filtrer"
                            size="small"
                            variant="filled"
                        />
                    </IconField>
                </div>
            </template>
            <template #empty> Aucun article trouvé </template>
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
            <Column field="sort_order" header="Ordre" sortable></Column>
            <Column field="barcode" header="Code-barres" sortable></Column>
            <Column field="label" header="Nom" sortable>
                <template #body="{ data }">
                    <div class="w-60 text-sm">{{ data.label }}</div>
                </template>
            </Column>
            <Column field="brand.name" header="Marque" sortable></Column>
            <Column field="line.name" header="Gamme" sortable></Column>
            <Column field="catalog_price" header="Prix cat." sortable>
                <template #body="{ data }">
                    {{ data.catalog_price?.toFixed(2) }}
                </template>
            </Column>
            <Column field="retail_price" header="Prix" sortable></Column>
            <Column field="sales_count" header="Ventes" sortable></Column>
            <Column>
                <template #body="{ data }">
                    <div class="w-20">
                        <Button
                            icon="pi pi-pencil"
                            aria-label="Modifier"
                            size="small"
                            variant="text"
                            rounded
                            severity="secondary"
                            @click="store.openArticleEditDialog(data)"
                        />
                        <Button
                            icon="pi pi-trash"
                            aria-label="Supprimer"
                            size="small"
                            variant="text"
                            rounded
                            severity="secondary"
                            @click="
                                confirmDelete(
                                    $confirm,
                                    `Voulez-vous vraiment supprimer l'article ${data.label} ?`,
                                    () => store.deleteArticle(data.id)
                                )
                            "
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
        <EditArticleDialog
            header="Modifier l'article"
            btn="Sauver"
            v-model:visible="store.showEditArticleDialog"
            :edited="store.edited"
            @save="store.updateArticle"
        />
        <EditArticleDialog
            header="Ajouter un article"
            btn="Créer"
            v-model:visible="store.showAddArticleDialog"
            :edited="{}"
            @save="store.createArticle"
        />
    </div>
</template>
