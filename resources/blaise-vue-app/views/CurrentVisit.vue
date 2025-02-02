<script setup>
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";
import dayjs from "dayjs";

const visit = useVisitStore();
</script>

<template>
    <aside
        class="bg-surface-100 dark:bg-surface-900 w-full md:w-96 xl:w-1/3 shrink-0 border-l dark:border-surface-700 px-5 py-3 flex flex-col gap-4"
    >
        <div>
            <h2 class="text-3xl font-extralight mb-1">Ticket en cours</h2>
            <h5 class="text-muted-color text-sm">
                Visite du
                {{ dayjs(visit.current.visit_date).format("DD.MM.YYYY HH:mm") }}
            </h5>
        </div>

        <div class="grow"></div>

        <div class="flex gap-2 justify-end">
            <Button
                label="Remise"
                type="button"
                size="small"
                icon="pi pi-plus"
                severity="secondary"
                variant="outlined"
            />
            <Button
                label="Bon cadeau"
                type="button"
                size="small"
                icon="pi pi-plus"
                severity="secondary"
                variant="outlined"
            />
        </div>

        <div class="flex justify-between text-2xl">
            <div>Total</div>
            <div>CHF 0</div>
        </div>

        <Button>Valider</Button>
        <Button
            @click="visit.deleteCurrent()"
            variant="text"
            severity="secondary"
            size="small"
        >
            Annuler
        </Button>
    </aside>
</template>
