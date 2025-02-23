<script setup>
import { reactive } from "vue";
import { useRoute } from "vue-router";
import { get } from "../../api";
import dayjs from "dayjs";
import Attributes from "../../components/Attributes.vue";

const route = useRoute();

const state = reactive({ visit: {} });

async function fetchVisit(id) {
    const { data, response } = await get(`/api/admin/visits/${id}`);
    if (!response.ok) return;
    state.visit = data;
}

fetchVisit(route.params.visitId);
</script>

<template>
    <div class="py-2 px-3">
        <h2 class="text-xl font-extralight mb-2">
            <RouterLink
                :to="`/admin/clients/${route.params.clientId}`"
                class="opacity-50 hover:opacity-100"
            >
                Toutes les visites
            </RouterLink>
            <i
                class="pi pi-chevron-right opacity-50"
                style="font-size: 0.7rem"
            ></i>
            Visite du
            {{ dayjs(state.visit.visit_date).format("DD.MM.YYYY HH:mm") }}
        </h2>
        <Attributes
            :attributes="[
                { label: 'Prix facturé', value: `CHF ${state.visit.billed}` },
            ]"
        ></Attributes>
    </div>
</template>
