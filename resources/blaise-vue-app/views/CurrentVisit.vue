<script setup>
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";
import dayjs from "dayjs";

const visit = useVisitStore();

async function del() {
    if (
        !visit.current.sales?.length ||
        confirm(
            "Ce ticket n'est pas finalisé, voulez-vous supprimer le ticket et les ventes associées ?"
        )
    ) {
        await visit.deleteCurrent();
    }
}
</script>

<template>
    <aside
        class="bg-surface-100 dark:bg-surface-900 w-full md:w-96 xl:w-1/3 shrink-0 border-t md:border-l md:border-t-0 dark:border-surface-700 px-5 py-3 flex flex-col gap-5"
    >
        <div>
            <h2 class="text-3xl font-extralight mb-1">Ticket en cours</h2>
            <h5 class="text-muted-color text-sm">
                Visite du
                {{ dayjs(visit.current.visit_date).format("DD.MM.YYYY HH:mm") }}
            </h5>
        </div>

        <div
            v-for="sale in visit.current.sales"
            class="flex justify-between text-xl items-center gap-2"
        >
            <div>{{ sale.label }}</div>
            <div>CHF&nbsp;{{ sale.price_charged }}</div>
        </div>

        <div class="grow"></div>

        <div class="flex gap-2 justify-end flex-wrap">
            <Button
                label="Notes"
                type="button"
                size="small"
                icon="pi pi-comment"
                severity="secondary"
                variant="outlined"
            />
            <Button
                label="Remise"
                type="button"
                size="small"
                icon="pi pi-percentage"
                severity="secondary"
                variant="outlined"
            />
            <Button
                label="Bon cadeau"
                type="button"
                size="small"
                icon="pi pi-gift"
                severity="secondary"
                variant="outlined"
            />
        </div>

        <div class="flex justify-between text-3xl">
            <div>Total</div>
            <div>CHF {{ visit.current.total }}</div>
        </div>

        <Button @click="visit.validateCurrent" size="large">Valider</Button>
        <Button @click="del" variant="text" severity="secondary" size="small">
            Annuler
        </Button>
    </aside>
</template>
