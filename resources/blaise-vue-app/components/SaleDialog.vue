<script setup lang="ts">
import { Button, Dialog, InputNumber } from "primevue";
import { useVisitStore } from "../stores/visit";

const visit = useVisitStore();
</script>

<template>
    <Dialog
        v-model:visible="visit.showSaleDialog"
        modal
        dismissableMask
        header="Détails vente"
        class="max-w-full"
    >
        <div class="mb-8">
            {{ visit.selectedSale.label }}
        </div>
        <div class="flex items-center gap-4 mb-8">
            <label for="email" class="font-semibold w-24">Prix</label>
            <InputNumber
                v-model="visit.selectedSale.price_charged"
                mode="currency"
                currency="CHF"
                locale="fr-CH"
                showButtons
                fluid
            />
        </div>
        <div class="flex justify-between">
            <Button
                type="button"
                label="Supprimer"
                severity="danger"
                icon="pi pi-trash"
                variant="outlined"
                @click="visit.deleteSelectedSale"
            ></Button>
            <Button
                type="button"
                label="Valider"
                @click="visit.saveSelectedSale"
            ></Button>
        </div>
    </Dialog>
</template>
