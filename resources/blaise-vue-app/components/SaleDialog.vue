<script setup lang="ts">
import {
    Button,
    Dialog,
    FloatLabel,
    InputNumber,
    InputText,
    Textarea,
} from "primevue";
import { useVisitStore } from "../stores/visit";

const visit = useVisitStore();
</script>

<template>
    <Dialog
        v-model:visible="visit.showSaleDialog"
        modal
        dismissableMask
        header="Détails vente"
        class="max-w-full w-96"
    >
        <div class="flex flex-col gap-6">
            <FloatLabel
                v-if="visit.selectedSale.type == 'other'"
                class="mt-2"
                variant="on"
            >
                <InputText
                    v-model="visit.selectedSale.label"
                    id="label"
                    fluid
                />
                <label for="label">Libellé</label>
            </FloatLabel>
            <div v-else>
                <div class="text-sm text-muted-color">Libellé</div>
                <div>{{ visit.selectedSale.label }}</div>
            </div>
            <div v-if="visit.selectedSale.base_price">
                <div class="text-sm text-muted-color">Prix de base</div>
                <div>CHF {{ visit.selectedSale.base_price }}</div>
            </div>
            <FloatLabel variant="on">
                <InputNumber
                    v-model="visit.selectedSale.price_charged"
                    id="price_charged"
                    mode="currency"
                    currency="CHF"
                    locale="fr-CH"
                    showButtons
                    fluid
                />
                <label for="price_charged">Prix</label>
            </FloatLabel>
            <FloatLabel variant="on">
                <Textarea
                    id="notes"
                    v-model="visit.selectedSale.notes"
                    autoResize
                    fluid
                />
                <label for="notes">Notes</label>
            </FloatLabel>
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
        </div>
    </Dialog>
</template>
