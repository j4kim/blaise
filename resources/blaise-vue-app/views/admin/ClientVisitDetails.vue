<script setup>
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { del, put } from "../../api";
import Attributes from "../../components/Attributes.vue";
import Attribute from "../../components/Attribute.vue";
import { Button, Column, DataTable, Message } from "primevue";
import {
    confirmDelete,
    formatDate,
    saleDiscountPercentage,
    saleHasDiscount,
} from "../../tools";
import { useVisitStore } from "../../stores/visit";
import VisitDateDialog from "../../dialogs/VisitDateDialog.vue";
import { useAdminClientsStore } from "../../stores/admin/clients";

const route = useRoute();
const router = useRouter();

const store = useAdminClientsStore();
const visitStore = useVisitStore();

const showDateDialog = ref(false);

store.fetchVisit(route.params.visitId);

async function replicate() {
    visitStore.replicate(store.visit.client_id, store.visit.id);
    router.push(`/clients/${store.visit.client_id}`);
}

async function cancel() {
    const { data, response } = await del(
        `/api/admin/visits/${store.visit.id}/cancel`
    );
    if (!response.ok) return;
    store.visit = data;
}

async function updateVisitDate(visit_date) {
    const { response, data } = await put(`/api/visits/${store.visit.id}`, {
        visit_date,
    });
    if (!response.ok) return;
    store.visit = data;
    showDateDialog.value = false;
}
</script>

<template>
    <div class="py-2 px-3 flex flex-col gap-6">
        <h2 class="text-xl font-extralight">
            <RouterLink
                :to="`/admin/clients/${route.params.clientId}/visits`"
                class="text-muted-color hover:text-color"
            >
                Toutes les visites
            </RouterLink>
            <span v-if="store.visit?.visit_date">
                <i
                    class="pi pi-chevron-right text-muted-color"
                    style="font-size: 0.7rem"
                ></i>
                Visite du
                {{ formatDate(store.visit.visit_date, true) }}
            </span>
        </h2>

        <template v-if="store.visit">
            <Message v-if="store.visit.deleted_at" severity="warn">
                Ticket annulé
            </Message>

            <div>
                <div class="text-sm text-muted-color">Ventes</div>
                <DataTable :value="store.visit.sales" size="small">
                    <Column field="label" header="Libellé"></Column>
                    <Column field="type" header="Type"></Column>
                    <Column field="notes" header="Notes"></Column>
                    <Column field="base_price" header="Prix de base"></Column>
                    <Column header="Remise">
                        <template #body="{ data }">
                            <span v-if="saleHasDiscount(data)">
                                {{ saleDiscountPercentage(data) }}
                            </span>
                        </template>
                    </Column>
                    <Column
                        field="price_charged"
                        header="Prix facturé"
                    ></Column>
                </DataTable>
            </div>

            <Attributes>
                <template #extra>
                    <Attribute
                        v-if="store.visit.tip"
                        label="Pourboire"
                        :value="`CHF ${store.visit.tip}`"
                    />
                    <Attribute
                        v-if="store.visit.rounding"
                        label="Arrondi"
                        :value="`CHF ${store.visit.rounding.toFixed(2)}`"
                    />
                    <Attribute
                        label="Total facturé"
                        :value="`CHF ${store.visit.billed}`"
                    />
                </template>
            </Attributes>

            <Attributes>
                <template #extra>
                    <Attribute
                        v-if="store.visit.cash_payment"
                        label="Paiement cash"
                        :value="`CHF ${store.visit.cash_payment}`"
                    />
                    <Attribute
                        v-if="store.visit.card_payment"
                        label="Paiement par carte"
                        :value="`CHF ${store.visit.card_payment}`"
                    />
                    <Attribute
                        v-if="store.visit.twint_payment"
                        label="Paiement par twint"
                        :value="`CHF ${store.visit.twint_payment}`"
                    />
                    <Attribute
                        v-if="store.visit.voucher_payment"
                        label="Paiement par bon"
                        :value="`CHF ${store.visit.voucher_payment}`"
                    />
                </template>
            </Attributes>

            <Attribute
                v-if="store.visit.technical_sheet"
                label="Fiche technique"
                class="whitespace-pre-line"
                :value="store.visit.technical_sheet.notes"
            />

            <div class="flex justify-end flex-wrap gap-2">
                <Button
                    :disabled="!!store.visit.deleted_at"
                    @click="
                        confirmDelete(
                            $confirm,
                            `Voulez-vous vraiment annuler le ticket ?`,
                            cancel
                        )
                    "
                    label="Annuler le ticket"
                    icon="pi pi-trash"
                    size="small"
                    variant="text"
                    severity="danger"
                ></Button>
                <Button
                    :disabled="!!store.visit.deleted_at"
                    @click="showDateDialog = true"
                    label="Modifier la date de la visite"
                    icon="pi pi-calendar"
                    size="small"
                    variant="text"
                    severity="secondary"
                ></Button>
                <Button
                    @click="replicate"
                    label="Récupérer dans le ticket"
                    icon="pi pi-clone"
                    size="small"
                    variant="text"
                    severity="secondary"
                ></Button>
            </div>

            <VisitDateDialog
                v-model:visible="showDateDialog"
                :value="store.visit.visit_date"
                @save="updateVisitDate"
            />
        </template>
    </div>
</template>
