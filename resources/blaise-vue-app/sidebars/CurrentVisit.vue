<script setup>
import { Button } from "primevue";
import dayjs from "dayjs";
import { useVisitStore } from "../stores/visit";

const visit = useVisitStore();

async function validate() {
    if (
        visit.current.sales?.length ||
        confirm(
            "Ce ticket n'a pas de vente associée, voulez-vous vraiment le valider ?"
        )
    ) {
        await visit.validateCurrent();
    }
}

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
                    <div class="whitespace-nowrap">
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
                        {{ sale.price_charged ?? 0 }}
                    </div>
                </div>
                <div class="text-sm text-muted-color">{{ sale.notes }}</div>
            </div>
        </div>

        <div class="grow"></div>

        <div class="overflow-y-auto -mx-5">
            <div
                v-if="visit.current.discount"
                @click="visit.showDiscountDialog = true"
                class="cursor-pointer hover:bg-surface-200 dark:hover:bg-surface-800 px-5 py-3"
            >
                <div
                    class="flex justify-between sm:text-lg xl:text-xl items-center gap-2"
                >
                    <div>Remise</div>
                    <div class="whitespace-nowrap">
                        {{ visit.current.discount * 100 }} %
                    </div>
                </div>
            </div>
            <div
                v-if="visit.current.voucher_payment"
                @click="visit.showVoucherPaymentDialog = true"
                class="cursor-pointer hover:bg-surface-200 dark:hover:bg-surface-800 px-5 py-3"
            >
                <div
                    class="flex justify-between sm:text-lg xl:text-xl items-center gap-2"
                >
                    <div>Paiement par bon</div>
                    <div class="whitespace-nowrap">
                        CHF {{ visit.current.voucher_payment }}
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-2 justify-end flex-wrap">
            <Button
                v-if="!visit.current.discount"
                @click="visit.addDiscount"
                label="Remise"
                type="button"
                size="small"
                icon="pi pi-percentage"
                severity="secondary"
                variant="outlined"
            />
            <Button
                v-if="!visit.current.voucher_payment"
                @click="visit.addVoucherPayment"
                label="Paiement par bon"
                type="button"
                size="small"
                icon="pi pi-gift"
                severity="secondary"
                variant="outlined"
            />
        </div>

        <div class="flex justify-between text-3xl gap-2 flex-wrap">
            <div>Total</div>
            <div class="whitespace-nowrap">
                CHF {{ (visit.current.total ?? 0).toFixed(2) }}
            </div>
        </div>

        <Button @click="validate" size="large">Valider</Button>
        <Button @click="del" variant="text" severity="secondary" size="small">
            Annuler
        </Button>
    </aside>
</template>
