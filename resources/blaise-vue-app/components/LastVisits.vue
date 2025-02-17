<script setup>
import dayjs from "dayjs";
import {
    Accordion,
    AccordionContent,
    AccordionHeader,
    AccordionPanel,
} from "primevue";
import { ref } from "vue";

defineProps({
    visits: Array,
});

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
            v-for="visit in visits"
            :key="visit.id"
            :value="visit.id"
        >
            <AccordionHeader>
                <div class="flex justify-between w-full">
                    <div class="w-28 shrink-0">
                        {{ dayjs(visit.visit_date).format("DD.MM.YYYY") }}
                    </div>
                    <div class="w-full truncate">
                        <span v-if="visit.id != selected">
                            {{ getSalesSummary(visit.sales) }}
                        </span>
                        <div v-else class="text-right">Total</div>
                    </div>
                    <div class="ml-4">
                        CHF&nbsp;{{ visit.billed.toFixed(2) }}
                    </div>
                </div>
            </AccordionHeader>
            <AccordionContent>
                <div
                    v-for="sale in visit.sales"
                    class="flex justify-between mb-2"
                >
                    <div>
                        {{ sale.label }}
                        <span class="text-muted-color" v-if="sale.notes">
                            ({{ sale.notes }})
                        </span>
                    </div>
                    <div>
                        CHF
                        <span
                            v-if="
                                sale.base_price &&
                                sale.price_charged != sale.base_price
                            "
                            class="line-through opacity-50"
                        >
                            {{ sale.base_price }}
                        </span>
                        {{ sale.price_charged }}
                    </div>
                </div>
                <div
                    v-if="visit.discount"
                    class="flex justify-between mb-2 text-muted-color"
                >
                    <div>Remise</div>
                    <div>- {{ visit.discount * 100 }} %</div>
                </div>
                <div
                    v-if="visit.voucher_payment"
                    class="flex justify-between mb-2 text-muted-color"
                >
                    <div>Paiement par bon cadeau</div>
                    <div>- CHF {{ visit.voucher_payment }}</div>
                </div>
            </AccordionContent>
        </AccordionPanel>
    </Accordion>
</template>
