<script setup>
import { Button, Dialog, InputNumber } from "primevue";
import { useVisitStore } from "../stores/visit";
import { computed } from "vue";

const visit = useVisitStore();

const percent = computed({
    get: () => visit.current.discount * 100,
    set: (v) => (visit.current.discount = v / 100),
});
</script>

<template>
    <Dialog
        v-model:visible="visit.showDiscountDialog"
        modal
        dismissableMask
        header="Remise"
        class="max-w-full w-96"
    >
        <div class="flex flex-col gap-6">
            <InputNumber
                v-model="percent"
                id="discount"
                suffix="%"
                showButtons
                fluid
                :step="5"
            />
            <div class="flex justify-between">
                <Button
                    type="button"
                    label="Supprimer"
                    severity="danger"
                    icon="pi pi-trash"
                    variant="outlined"
                    @click="visit.removeDiscount"
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
