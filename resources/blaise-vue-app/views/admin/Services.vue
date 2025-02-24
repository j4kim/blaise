<script setup>
import { Button, Column, DataTable } from "primevue";
import { useSaleablesStore } from "../../stores/saleables";

const saleables = useSaleablesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <span class="text-xl font-extralight">Services</span>
        </header>
        <DataTable :value="saleables.serviceCategories">
            <Column field="label" header="Catégorie"></Column>
            <Column field="sort_order" header="Ordre"></Column>
            <Column class="w-32">
                <template #body>
                    <Button
                        icon="pi pi-pencil"
                        aria-label="Modifier"
                        size="small"
                        variant="text"
                        rounded
                        severity="secondary"
                    />
                    <Button
                        icon="pi pi-trash"
                        aria-label="Supprimer"
                        size="small"
                        variant="text"
                        rounded
                        severity="secondary"
                    />
                </template>
            </Column>
        </DataTable>
    </div>
</template>
