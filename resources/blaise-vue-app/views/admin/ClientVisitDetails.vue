<script setup>
import { reactive } from "vue";
import { useRoute, useRouter } from "vue-router";
import { del, get, put } from "../../api";
import Attributes from "../../components/Attributes.vue";
import Attribute from "../../components/Attribute.vue";
import { Button, Column, DataTable, Message } from "primevue";
import { confirmDelete, formatDate } from "../../tools";
import { useVisitStore } from "../../stores/visit";
import VisitDateDialog from "../../dialogs/VisitDateDialog.vue";

const route = useRoute();
const router = useRouter();

const state = reactive({ visit: null, showDateDialog: false });

const visitStore = useVisitStore();

async function fetchVisit(id) {
    const { data, response } = await get(`/api/admin/visits/${id}`);
    if (!response.ok) return;
    state.visit = data;
}

fetchVisit(route.params.visitId);

async function replicate() {
    visitStore.replicate(state.visit.client_id, state.visit.id);
    router.push(`/clients/${state.visit.client_id}`);
}

async function cancel() {
    const { data, response } = await del(
        `/api/admin/visits/${state.visit.id}/cancel`
    );
    if (!response.ok) return;
    state.visit = data;
}

async function updateVisitDate(visit_date) {
    const { response, data } = await put(`/api/visits/${state.visit.id}`, {
        visit_date,
    });
    if (!response.ok) return;
    state.visit = data;
    state.showDateDialog = false;
}
</script>

<template>
    <div class="py-2 px-3" v-if="state.visit">
        <h2 class="text-xl font-extralight mb-4">
            <RouterLink
                :to="`/admin/clients/${route.params.clientId}`"
                class="text-muted-color hover:text-color"
            >
                Toutes les visites
            </RouterLink>
            <span v-if="state.visit.visit_date">
                <i
                    class="pi pi-chevron-right text-muted-color"
                    style="font-size: 0.7rem"
                ></i>
                Visite du
                {{ formatDate(state.visit.visit_date, true) }}
            </span>
        </h2>
        <div class="mb-4" v-if="state.visit.deleted_at">
            <Message severity="warn"> Visite annulée </Message>
        </div>

        <div class="text-sm text-muted-color my-2">Ventes</div>

        <DataTable :value="state.visit.sales" size="small">
            <Column field="label" , header="Libellé"></Column>
            <Column field="type" , header="Type"></Column>
            <Column field="notes" , header="Notes"></Column>
            <Column field="base_price" , header="Prix de base"></Column>
            <Column field="price_charged" , header="Prix facturé"></Column>
        </DataTable>

        <Attributes class="my-4">
            <template #extra>
                <Attribute
                    v-if="state.visit.discount"
                    label="Remise"
                    :value="`- ${state.visit.discount * 100} %`"
                />
                <Attribute
                    v-if="state.visit.voucher_payment"
                    label="Paiement par bon"
                    :value="`- CHF ${state.visit.voucher_payment}`"
                />
                <Attribute
                    v-if="state.visit.rounding"
                    label="Arrondi"
                    :value="`CHF ${state.visit.rounding}`"
                />
                <Attribute
                    label="Total facturé"
                    :value="`CHF ${state.visit.billed}`"
                />
            </template>
        </Attributes>

        <div class="flex justify-end flex-wrap gap-2 mt-4">
            <Button
                :disabled="!!state.visit.deleted_at"
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
                :disabled="!!state.visit.deleted_at"
                @click="state.showDateDialog = true"
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
            v-model:visible="state.showDateDialog"
            :value="state.visit.visit_date"
            @save="updateVisitDate"
        />
    </div>
</template>
