<script setup>
import { Button, Column, DataTable, InputText } from "primevue";
import { useSaleablesStore } from "../../stores/saleables";

const store = useSaleablesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <span class="text-xl font-extralight">Services</span>
        </header>
        <DataTable :value="store.serviceCategories">
            <Column field="label" header="Catégorie">
                <template #editor="{ data, field }">
                    <InputText v-model="data.label" autofocus fluid></InputText>
                </template>
            </Column>
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
