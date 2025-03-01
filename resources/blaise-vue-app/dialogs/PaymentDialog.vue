<script setup>
import {
    Button,
    Dialog,
    FloatLabel,
    InputNumber,
    InputText,
    ToggleSwitch,
} from "primevue";
import { useVisitStore } from "../stores/visit";
import { computed, ref, watch } from "vue";
import { useClientStore } from "../stores/client";

const visit = useVisitStore();
const client = useClientStore();

const paid = computed(
    () =>
        (visit.current.cash ?? 0) +
        (visit.current.twint ?? 0) +
        (visit.current.card ?? 0) +
        (visit.current.voucher_payment ?? 0)
);

const rest = computed(() =>
    Math.round(
        visit.current.subtotal - paid.value + (visit.current.rounding ?? 0)
    )
);

watch(
    () => visit.showPaymentDialog,
    (show) => {
        if (show) {
            visit.current.client_email = client.selected.email;
            const rounded = Math.round(visit.current.subtotal);
            visit.current.rounding = rounded - visit.current.subtotal;
        }
    }
);

const missingEmail = computed(
    () => visit.current.send_by_email && !visit.current.client_email
);

const methods = ref({
    cash: { label: "Cash", icon: "pi pi-money-bill" },
    card: { label: "Carte", icon: "pi pi-credit-card" },
    twint: { label: "Twint", icon: "pi pi-mobile" },
    voucher_payment: { label: "Bon", icon: "pi pi-gift" },
});
</script>

<template>
    <Dialog
        v-model:visible="visit.showPaymentDialog"
        modal
        dismissableMask
        header="Paiement"
    >
        <form
            class="flex flex-col gap-6"
            @submit.prevent="visit.validateCurrent"
        >
            <div class="flex justify-between">
                <span>Total</span>
                <span>CHF {{ visit.current.subtotal.toFixed(2) }}</span>
            </div>
            <div class="flex justify-between items-center gap-2">
                <div>Arrondi</div>
                <Button
                    size="small"
                    severity="secondary"
                    icon="pi pi-minus"
                    rounded
                    @click="visit.current.rounding--"
                ></Button>
                <Button
                    size="small"
                    severity="secondary"
                    icon="pi pi-plus"
                    rounded
                    @click="visit.current.rounding++"
                ></Button>
                <div class="grow"></div>
                <div class="whitespace-nowrap">
                    CHF {{ visit.current.rounding.toFixed(2) }}
                </div>
            </div>
            <template v-for="({ label }, key) in methods">
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
                            :step="key === 'voucher_payment' ? 10 : 1"
                        />
                        <label :for="`input-${key}`">{{ label }}</label>
                    </FloatLabel>
                </div>
            </template>
            <div class="flex flex-wrap gap-2">
                <Button
                    v-for="({ label, icon }, key) in methods"
                    @click="
                        visit.current[key] =
                            key === 'voucher_payment' ? 50 : rest
                    "
                    :label="label"
                    rounded
                    :disabled="visit.current[key] || rest === 0"
                    severity="secondary"
                    :icon="icon"
                ></Button>
            </div>
            <div
                class="flex justify-between"
                :class="{
                    'text-muted-color': rest === 0,
                }"
            >
                <span>Reste à payer</span>
                <span>CHF {{ rest.toFixed(2) }}</span>
            </div>
            <div class="flex gap-2">
                <ToggleSwitch
                    v-model="visit.current.send_by_email"
                    inputId="send_by_email"
                />
                <label
                    :class="{
                        'text-muted-color': !visit.current.send_by_email,
                    }"
                    for="send_by_email"
                >
                    Envoyer le ticket par email
                </label>
            </div>
            <FloatLabel v-if="visit.current.send_by_email" variant="on">
                <InputText
                    v-model="visit.current.client_email"
                    @update:modelValue="visit.current.email_changed = true"
                    id="client_email"
                    fluid
                    type="email"
                />
                <label for="client_email">Email</label>
            </FloatLabel>
            <div class="flex justify-end">
                <Button
                    type="submit"
                    label="Valider"
                    :disabled="rest !== 0 || missingEmail"
                ></Button>
            </div>
        </form>
    </Dialog>
</template>
