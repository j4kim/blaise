<script setup>
import { Button, Dialog, InputNumber, Textarea } from "primevue";
import { useVisitStore } from "../stores/visit";
import { ref, watch } from "vue";

const visit = useVisitStore();

const notes = ref("");

watch(
    () => visit.showTechnicalSheetDialog,
    (open) => open && (notes.value = visit.current.technical_sheet?.notes ?? "")
);

function save() {
    visit.updateTechnicalSheet(notes.value);
}
</script>

<template>
    <Dialog
        v-model:visible="visit.showTechnicalSheetDialog"
        modal
        dismissableMask
        header="Fiche technique"
        class="max-w-full w-96"
    >
        <div class="flex flex-col gap-6">
            <Textarea v-model="notes" rows="3" autofocus placeholder="notes" />
            <div class="flex justify-between">
                <Button
                    type="button"
                    label="Supprimer"
                    severity="danger"
                    icon="pi pi-trash"
                    variant="outlined"
                    @click="visit.removeTechnicalSheet"
                ></Button>
                <Button type="button" label="Sauver" @click="save"></Button>
            </div>
        </div>
    </Dialog>
</template>
