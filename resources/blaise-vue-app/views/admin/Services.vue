<script setup>
import { Button, Column, DataTable } from "primevue";
import { useServicesStore } from "../../stores/services";
import EditServiceCatDialog from "../../dialogs/EditServiceCatDialog.vue";

const store = useServicesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <span class="text-xl font-extralight">Services</span>
        </header>
        <DataTable
            :value="store.categories"
            sortField="sort_order"
            :sortOrder="1"
            :expandedRows="[]"
        >
            <Column expander />
            <Column field="label" header="Catégorie" sortable></Column>
            <Column field="sort_order" header="Ordre" sortable></Column>
            <Column field="services.length" header="Services" sortable></Column>
            <Column class="w-32">
                <template #body="{ data }">
                    <Button
                        icon="pi pi-pencil"
                        aria-label="Modifier"
                        size="small"
                        variant="text"
                        rounded
                        severity="secondary"
                        @click="store.openCatEditDialog(data)"
                    />
                    <Button
                        icon="pi pi-trash"
                        aria-label="Supprimer"
                        size="small"
                        variant="text"
                        rounded
                        severity="secondary"
                        @click="store.confirmCatDelete(data)"
                    />
                </template>
            </Column>
            <template #expansion="{ data }">
                <DataTable
                    :value="data.services"
                    sortField="sort_order"
                    :sortOrder="1"
                    class="p-4"
                >
                    <template #empty>
                        Aucun service dans cette catégorie.
                    </template>
                    <Column field="label" header="Service" sortable></Column>
                    <Column field="sort_order" header="Ordre" sortable></Column>
                    <Column field="price" header="Prix" sortable>
                        <template #body="{ data }">
                            CHF {{ data.price }}
                        </template>
                    </Column>
                    <Column class="w-32">
                        <template #body="{ data }">
                            <Button
                                icon="pi pi-pencil"
                                aria-label="Modifier"
                                size="small"
                                variant="text"
                                rounded
                                severity="secondary"
                                @click="console.log('update', data)"
                            />
                            <Button
                                icon="pi pi-trash"
                                aria-label="Supprimer"
                                size="small"
                                variant="text"
                                rounded
                                severity="secondary"
                                @click="console.log('delete', data)"
                            />
                        </template>
                    </Column>
                </DataTable>
            </template>
        </DataTable>
        <EditServiceCatDialog
            v-model:visible="store.showCatEditDialog"
            :edited="store.editedCat"
            header="Modifier"
            @save="store.updateCat"
        />
    </div>
</template>
