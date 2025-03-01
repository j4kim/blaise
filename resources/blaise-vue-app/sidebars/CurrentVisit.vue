<script setup>
import { Button, Chip } from "primevue";
import { useVisitStore } from "../stores/visit";
import { formatDate, saleDiscountPercentage, saleHasDiscount } from "../tools";
import SaleDialog from "../dialogs/SaleDialog.vue";
import DiscountDialog from "../dialogs/DiscountDialog.vue";
import VisitDateDialog from "../dialogs/VisitDateDialog.vue";
import PaymentDialog from "../dialogs/PaymentDialog.vue";

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
                {{ formatDate(visit.current.visit_date, true) }}
                <button
                    class="pi pi-calendar hover:bg-surface-200 dark:hover:bg-surface-800 rounded-full p-2 -my-2"
                    style="font-size: 0.8em"
                    @click="visit.showDateDialog = true"
                ></button>
            </h5>
        </div>

        <div class="overflow-y-auto -mx-5">
            <div
                v-for="sale in visit.current.sales"
                @click="visit.openSaleDialog(sale)"
                class="cursor-pointer hover:bg-surface-200 dark:hover:bg-surface-800 px-5 py-3"
            >
                <div
                    class="flex justify-between sm:text-lg xl:text-xl items-center gap-2"
                >
                    <div>{{ sale.label }}</div>
                    <div class="grow"></div>
                    <Chip
                        v-if="saleHasDiscount(sale)"
                        class="text-sm !px-3 !py-1 whitespace-nowrap"
                        :label="saleDiscountPercentage(sale)"
                    />
                    <div class="whitespace-nowrap">
                        CHF
                        {{ (sale.price_charged ?? 0).toFixed(2) }}
                    </div>
                </div>
                <div class="text-sm text-muted-color">{{ sale.notes }}</div>
            </div>
        </div>

        <div class="grow"></div>

        <div class="flex gap-2 justify-end flex-wrap">
            <Button
                @click="visit.showDiscountDialog = true"
                :disabled="!visit.current.sales?.length"
                label="Remise"
                type="button"
                size="small"
                icon="pi pi-percentage"
                severity="secondary"
                variant="outlined"
            />
        </div>

        <div class="flex justify-between text-3xl gap-2 flex-wrap">
            <div>Total</div>
            <div class="whitespace-nowrap">
                CHF {{ (visit.current.subtotal ?? 0).toFixed(2) }}
            </div>
        </div>

        <Button
            @click="visit.showPaymentDialog = true"
            :disabled="!visit.current.sales?.length"
            size="large"
        >
            Vers paiement
        </Button>
        <Button @click="del" variant="text" severity="secondary" size="small">
            Annuler
        </Button>

        <SaleDialog />
        <DiscountDialog />
        <VisitDateDialog
            v-model:visible="visit.showDateDialog"
            :value="visit.current.visit_date"
            @save="visit.updateVisitDate"
        />
        <PaymentDialog />
    </aside>
</template>
