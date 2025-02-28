<script setup>
import { Button, Dialog, InputNumber } from "primevue";
import { useVisitStore } from "../stores/visit";
import { computed } from "vue";

const visit = useVisitStore();
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
            <div class="flex justify-between">
                <Button
                    type="button"
                    label="Valider"
                    @click="console.log"
                ></Button>
            </div>
        </div>
    </Dialog>
</template>
