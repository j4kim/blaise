<script setup>
import { ref } from "vue";
import { useClientStore } from "../stores/client";
import { useVisitStore } from "../stores/visit";
import { get } from "../api";
import { Column, DataTable } from "primevue";

const props = defineProps({
    category: Object,
});

const visit = useVisitStore();
const client = useClientStore();

const sales = ref([]);

async function fetch() {
    const { data, response } = await get(
        `/api/clients/${client.selected.id}/previous-sales/${props.category.id}`
    );
    if (!response.ok) return;
    sales.value = data;
}

fetch();
</script>

<template>
    <h5>Dernières ventes {{ category.label }}</h5>
    <div class="mt-1 mb-4">
        <DataTable :value="sales" size="small">
            <Column field="label" header="Libellé"></Column>
            <Column field="notes" header="Notes"></Column>
            <Column field="price_charged" header="Prix facturé"></Column>
        </DataTable>
    </div>
</template>
