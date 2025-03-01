<script setup>
import {
    Accordion,
    AccordionContent,
    AccordionHeader,
    AccordionPanel,
    Button,
    Chip,
} from "primevue";
import { ref } from "vue";
import { RouterLink } from "vue-router";
import { formatDate, saleDiscountPercentage, saleHasDiscount } from "../tools";
import { useVisitStore } from "../stores/visit";

defineProps({
    client: Object,
});

const visitStore = useVisitStore();

const selected = ref(null);

function getSalesSummary(sales) {
    const labels = sales.map((s) => s.label);
    const slice = labels.slice(0, 2);
    const diff = labels.length - slice.length;
    return slice.join(", ") + (diff > 0 ? ` +${diff}` : "");
}
</script>

<template>
    <Accordion v-model:value="selected" expand-icon=" " collapse-icon=" ">
        <AccordionPanel
            v-for="visit in client.last_visits"
            :key="visit.id"
            :value="visit.id"
        >
            <AccordionHeader>
                <div class="flex justify-between w-full">
                    <div class="w-28 shrink-0">
                        {{ formatDate(visit.visit_date) }}
                    </div>
                    <div class="w-full truncate">
                        <span v-if="visit.id != selected">
                            {{ getSalesSummary(visit.sales) }}
                        </span>
                        <div v-else class="text-right">Total</div>
                    </div>
                    <div class="ml-4">CHF&nbsp;{{ visit.billed }}</div>
                </div>
            </AccordionHeader>
            <AccordionContent>
                <div
                    v-for="sale in visit.sales"
                    class="flex justify-between mb-2 gap-1 flex-wrap"
                >
                    <div class="grow">
                        {{ sale.label }}
                        <span class="text-muted-color" v-if="sale.notes">
                            ({{ sale.notes }})
                        </span>
                    </div>
                    <div class="grow flex gap-2 items-center justify-end">
                        <template v-if="saleHasDiscount(sale)">
                            <span class="line-through text-muted-color">
                                CHF {{ sale.base_price }}
                            </span>
                            <Chip
                                class="text-sm !px-3 !py-1 whitespace-nowrap"
                                :label="saleDiscountPercentage(sale)"
                            />
                        </template>
                        <span> CHF {{ sale.price_charged.toFixed(2) }} </span>
                    </div>
                </div>
                <div
                    v-if="visit.tip"
                    class="flex justify-between mb-2 text-muted-color"
                >
                    <div>Pourboire</div>
                    <div>CHF {{ visit.tip }}</div>
                </div>
                <div
                    v-if="visit.rounding"
                    class="flex justify-between mb-2 text-muted-color"
                >
                    <div>Arrondi</div>
                    <div>CHF {{ visit.rounding.toFixed(2) }}</div>
                </div>
                <div class="text-center">
                    <RouterLink
                        :to="`/admin/clients/${visit.client_id}/visit/${visit.id}`"
                    >
                        <Button
                            label="Détails"
                            size="small"
                            variant="text"
                            severity="secondary"
                        ></Button>
                    </RouterLink>
                    <Button
                        label="Récupérer"
                        size="small"
                        variant="text"
                        severity="secondary"
                        @click="visitStore.replicate(visit.client_id, visit.id)"
                    ></Button>
                </div>
            </AccordionContent>
        </AccordionPanel>
    </Accordion>
</template>
