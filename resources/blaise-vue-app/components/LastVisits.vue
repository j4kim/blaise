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
                            {{ visit.sales.map((s) => s.label).join(", ") }}
                        </span>
                        <div v-else class="text-right">Total</div>
                    </div>
                    <div class="ml-4">CHF&nbsp;{{ visit.billed }}</div>
                </div>
            </AccordionHeader>
            <AccordionContent>
                <div
                    v-for="sale in visit.sales"
                    class="flex justify-between mb-2"
                >
                    <div>{{ sale.label }}</div>
                    <div>CHF&nbsp;{{ sale.price_charged }}</div>
                </div>
            </AccordionContent>
        </AccordionPanel>
    </Accordion>
</template>
