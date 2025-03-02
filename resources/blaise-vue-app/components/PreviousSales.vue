<script setup>
import { ref } from "vue";
import { useClientStore } from "../stores/client";
import { useVisitStore } from "../stores/visit";
import { get } from "../api";

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
    <div class="my-2">
        <div v-for="sale in sales">{{ sale.label }}</div>
    </div>
</template>
