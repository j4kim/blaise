<script setup>
import {
    Accordion,
    AccordionContent,
    AccordionHeader,
    AccordionPanel,
    Button,
} from "primevue";
import { RouterLink } from "vue-router";
import { formatDate } from "../tools";
import { ref } from "vue";

defineProps({
    client: Object,
});

const selected = ref(null);
</script>

<template>
    <Accordion v-model:value="selected" expand-icon=" " collapse-icon=" ">
        <AccordionPanel
            v-for="sheet in client.last_technical_sheets"
            :key="sheet.id"
            :value="sheet.id"
        >
            <AccordionHeader>
                <div class="flex justify-between w-full">
                    <div class="w-28 shrink-0">
                        {{ formatDate(sheet.created_at) }}
                    </div>
                    <div class="w-full truncate" v-if="sheet.id != selected">
                        {{ sheet.notes }}
                    </div>
                </div>
            </AccordionHeader>
            <AccordionContent class="whitespace-pre-line">
                {{ sheet.notes }}
            </AccordionContent>
        </AccordionPanel>
    </Accordion>
    <RouterLink
        v-if="client.technical_sheets_count > 5"
        :to="`/admin/clients/${client.id}/sheets`"
    >
        <Button
            :label="`Voir toutes les fiches techniques (${client.technical_sheets_count})`"
            size="small"
            variant="text"
            severity="secondary"
            class="mt-2"
        ></Button>
    </RouterLink>
</template>
