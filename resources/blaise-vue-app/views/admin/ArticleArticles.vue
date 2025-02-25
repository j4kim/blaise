<script setup>
import { Column, DataTable } from "primevue";
import { useArticlesStore } from "../../stores/articles";
import { formatDate } from "../../tools";

const store = useArticlesStore();
</script>

<template>
    <div>
        <DataTable
            :value="store.articles"
            paginator
            :rows="10"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="articles {first} à {last} sur {totalRecords}"
            sortField="sort_order"
            :sortOrder="1"
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
            <Column field="sort_order" header="Ordre" sortable></Column>
            <Column field="barcode" header="Code-barres" sortable></Column>
            <Column
                field="label"
                header="Nom"
                sortable
                bodyClass="min-w-80"
            ></Column>
            <Column field="brand.name" header="Marque" sortable></Column>
            <Column field="line.name" header="Gamme" sortable></Column>
            <Column field="catalog_price" header="Prix cat." sortable></Column>
            <Column field="retail_price" header="Prix" sortable></Column>
            <Column field="sales_count" header="Ventes" sortable></Column>
        </DataTable>
    </div>
</template>
