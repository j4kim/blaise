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
        <form class="flex flex-col gap-6" @submit.prevent="save">
            <Textarea
                v-model="notes"
                rows="3"
                autofocus
                placeholder="Notes"
                required
            />
            <div class="flex justify-between">
                <Button
                    type="button"
                    label="Supprimer"
                    severity="danger"
                    icon="pi pi-trash"
                    variant="outlined"
                    @click="visit.deleteTechnicalSheet"
                ></Button>
                <Button type="submit" label="Sauver"></Button>
            </div>
        </form>
    </Dialog>
</template>
