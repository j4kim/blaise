<script setup>
import { Button, Dialog, FloatLabel, InputNumber } from "primevue";
import { useVisitStore } from "../stores/visit";
import { computed } from "vue";

const visit = useVisitStore();

const paid = computed(
    () => visit.current.cash + visit.current.twint + visit.current.card
);

const rest = computed(() => visit.current.total - paid.value);
</script>

<template>
    <Dialog
        v-model:visible="visit.showPaymentDialog"
        modal
        dismissableMask
        header="Paiement"
        class="max-w-full w-96"
    >
        <div class="flex flex-col gap-6">
            <template
                v-for="(label, key) in {
                    cash: 'Cash',
                    card: 'Carte',
                    twint: 'Twint',
                }"
            >
                <div v-if="visit.current[key]" class="flex items-baseline">
                    <Button
                        class="mr-1"
                        icon="pi pi-times"
                        severity="secondary"
                        rounded
                        variant="text"
                        @click="visit.current[key] = null"
                    />
                    <FloatLabel class="mt-2 grow" variant="on">
                        <InputNumber
                            v-model="visit.current[key]"
                            :id="`input-${key}`"
                            mode="currency"
                            currency="CHF"
                            locale="fr-CH"
                            showButtons
                            fluid
                        />
                        <label :for="`input-${key}`">{{ label }}</label>
                    </FloatLabel>
                </div>
            </template>
            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="(label, key) in {
                        cash: 'Cash',
                        card: 'Carte',
                        twint: 'Twint',
                    }"
                    @click="visit.current[key] = rest"
                    :label="label"
                    rounded
                    :disabled="visit.current[key] || rest === 0"
                    severity="secondary"
                ></Button>
            </div>
            <div class="flex justify-between">
                <span>Reste à payer</span>
                <span>CHF {{ rest }}</span>
            </div>
            <div class="flex justify-end">
                <Button
                    type="button"
                    label="Valider"
                    @click="visit.validateCurrent"
                    :disabled="rest !== 0"
                ></Button>
            </div>
        </div>
    </Dialog>
</template>
