<script setup>
import { Button, Dialog, InputNumber } from "primevue";
import { useVisitStore } from "../stores/visit";

const visit = useVisitStore();
</script>

<template>
    <Dialog
        v-model:visible="visit.showTipDialog"
        modal
        dismissableMask
        header="Pourboire"
        class="max-w-full w-96"
    >
        <div class="flex flex-col gap-6">
            <InputNumber
                v-model="visit.current.tip"
                mode="currency"
                currency="CHF"
                locale="fr-CH"
                showButtons
                fluid
            />
            <div class="flex justify-between">
                <Button
                    type="button"
                    label="Supprimer"
                    severity="danger"
                    icon="pi pi-trash"
                    variant="outlined"
                    @click="visit.removeTip"
                ></Button>
                <Button
                    type="button"
                    label="Valider"
                    @click="visit.updateCurrent"
                ></Button>
            </div>
        </div>
    </Dialog>
</template>
