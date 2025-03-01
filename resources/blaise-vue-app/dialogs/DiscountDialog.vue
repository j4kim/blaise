<script setup>
import { Button, Checkbox, Dialog, InputNumber } from "primevue";
import { useVisitStore } from "../stores/visit";
import { ref } from "vue";

const visit = useVisitStore();

const percent = ref(10);

const filter = ref(["service", "article"]);
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
                Sur:
                <div class="flex items-center gap-2">
                    <Checkbox
                        v-model="filter"
                        inputId="service"
                        value="service"
                    />
                    <label for="service"> Services </label>
                </div>
                <div class="flex items-center gap-2">
                    <Checkbox
                        v-model="filter"
                        inputId="article"
                        value="article"
                    />
                    <label for="article"> Articles </label>
                </div>
            </div>
            <InputNumber
                v-model="percent"
                id="discount"
                suffix="%"
                showButtons
                fluid
                :step="5"
            />
            <div class="flex justify-end">
                <Button
                    type="button"
                    label="Valider"
                    @click="visit.addDiscount(percent, filter)"
                ></Button>
            </div>
        </div>
    </Dialog>
</template>
