<script setup>
import { Button, Column, DataTable } from "primevue";
import { useServicesStore } from "../../stores/services";
import EditServiceCatDialog from "../../dialogs/EditServiceCatDialog.vue";
import EditServiceDialog from "../../dialogs/EditServiceDialog.vue";
import { confirmDelete } from "../../tools";

const store = useServicesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <span class="text-xl font-extralight">Services</span>

            <div class="grow"></div>

            <Button
                label="Ajouter catégorie"
                size="small"
                variant="text"
                icon="pi pi-plus"
                @click="store.showCatCreateDialog = true"
            />
        </header>
        <DataTable
            :value="store.categories"
            v-model:expandedRows="store.expandedRows"
        >
            <Column expander />
            <Column field="label" header="Catégorie"></Column>
            <Column field="sort_order" header="Ordre"></Column>
            <Column field="services.length" header="Services"></Column>
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
                        @click="
                            confirmDelete(
                                $confirm,
                                `Voulez-vous vraiment supprimer la catégorie ${data.label} ? Cette catégorie contient ${data.services.length} services.`,
                                () => store.deleteCategory(data.id)
                            )
                        "
                        :disabled="data.options?.preventDelete"
                    />
                </template>
            </Column>
            <template #expansion="{ data }">
                <div class="p-4">
                    <div class="flex justify-end">
                        <Button
                            label="Ajouter service"
                            size="small"
                            variant="text"
                            icon="pi pi-plus"
                            @click="
                                store.edited = { service_category_id: data.id };
                                store.showServiceCreateDialog = true;
                            "
                        />
                    </div>
                    <DataTable :value="data.services" size="small">
                        <template #empty>
                            Aucun service dans cette catégorie.
                        </template>
                        <Column field="label" header="Service"></Column>
                        <Column field="sort_order" header="Ordre"></Column>
                        <Column field="sales_count" header="Ventes"></Column>
                        <Column field="price" header="Prix">
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
                                    @click="store.openServiceEditDialog(data)"
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
                                            `Voulez-vous vraiment supprimer le service ${data.label} ?`,
                                            () => store.deleteService(data.id)
                                        )
                                    "
                                />
                            </template>
                        </Column>
                    </DataTable>
                </div>
            </template>
        </DataTable>
        <EditServiceCatDialog
            v-model:visible="store.showCatEditDialog"
            :edited="store.edited"
            header="Modifier catégorie"
            @save="store.updateCat"
        />
        <EditServiceCatDialog
            header="Ajouter une catégorie"
            btn="Créer"
            v-model:visible="store.showCatCreateDialog"
            :edited="{}"
            @save="store.createCat"
        />
        <EditServiceDialog
            v-model:visible="store.showServiceEditDialog"
            header="Modifier service"
            :edited="store.edited"
            @save="store.updateService"
        />
        <EditServiceDialog
            v-model:visible="store.showServiceCreateDialog"
            header="Modifier service"
            :edited="store.edited"
            @save="store.createService"
        />
    </div>
</template>
