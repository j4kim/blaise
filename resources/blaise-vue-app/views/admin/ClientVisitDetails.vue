<script setup>
import { reactive } from "vue";
import { useRoute, useRouter } from "vue-router";
import { get } from "../../api";
import Attributes from "../../components/Attributes.vue";
import Attribute from "../../components/Attribute.vue";
import { Button, Column, DataTable } from "primevue";
import { formatDate } from "../../tools";
import { useVisitStore } from "../../stores/visit";

const route = useRoute();
const router = useRouter();

const state = reactive({ visit: {} });

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
</script>

<template>
    <div class="py-2 px-3">
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
        <Attributes
            :attributes="[
                { label: 'Total facturé', value: `CHF ${state.visit.billed}` },
            ]"
        >
            <template #extra>
                <Attribute
                    v-if="state.visit.discount"
                    label="Remise"
                    :value="`- ${state.visit.discount * 100} %`"
                />
                <Attribute
                    v-if="state.visit.voucher_payment"
                    label="Remise"
                    :value="`- CHF ${state.visit.voucher_payment}`"
                />
            </template>
        </Attributes>

        <div class="text-sm text-muted-color my-2">Ventes</div>

        <DataTable :value="state.visit.sales" size="small">
            <Column field="label" , header="Libellé"></Column>
            <Column field="type" , header="Type"></Column>
            <Column field="notes" , header="Notes"></Column>
            <Column field="base_price" , header="Prix de base"></Column>
            <Column field="price_charged" , header="Prix facturé"></Column>
        </DataTable>

        <div class="flex justify-end gap-2 mt-4">
            <Button
                @click="replicate"
                label="Récupérer dans le ticket"
                icon="pi pi-clone"
                size="small"
                variant="text"
                severity="secondary"
            ></Button>
        </div>
    </div>
</template>
