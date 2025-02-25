<script setup>
import { Column, DataTable } from "primevue";
import { useArticlesStore } from "../../stores/articles";

const store = useArticlesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <span class="text-xl font-extralight">Articles</span>
        </header>

        <DataTable
            :value="store.articles"
            paginator
            :rows="15"
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink"
            currentPageReportTemplate="articles {first} à {last} sur {totalRecords}"
            sortField="sort_order"
            :sortOrder="1"
        >
            <Column field="sort_order" header="Ordre" sortable></Column>
            <Column field="barcode" header="Code barre" sortable></Column>
            <Column field="label" header="Nom" sortable></Column>
            <Column field="brand.name" header="Marque" sortable></Column>
            <Column field="line.name" header="Gamme" sortable></Column>
            <Column
                field="catalog_price"
                header="Prix catalogue"
                sortable
            ></Column>
            <Column field="retail_price" header="Prix" sortable></Column>
        </DataTable>
    </div>
</template>
