<script setup>
import { Button, Column, DataTable } from "primevue";
import { useArticlesStore } from "../../stores/articles";
import { confirmDelete, formatDate } from "../../tools";

const store = useArticlesStore();
</script>

<template>
    <div>
        <DataTable
            :value="store.brands"
            paginator
            :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="marques {first} à {last} sur {totalRecords}"
            :alwaysShowPaginator="false"
            sortField="name"
            :sortOrder="1"
        >
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
            <Column bodyClass="w-20">
                <template #body="{ data }">
                    <div>
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
                                    `Voulez-vous vraiment supprimer la marque ${data.name} ?`,
                                    () => store.deleteBrand(data.id)
                                )
                            "
                        />
                    </div>
                </template>
            </Column>
        </DataTable>
    </div>
</template>
