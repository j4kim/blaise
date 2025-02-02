<script setup>
import { Button } from "primevue";
import { useSaleablesStore } from "../stores/saleables";

const saleables = useSaleablesStore();
</script>

<template>
    <div>
        <h5 class="mb-2">Ajouter articles et prestations</h5>
        <div
            class="grid gap-3 grid-cols-2 sm:grid-cols-4 md:grid-cols-2 lg:grid-cols-4"
        >
            <Button label="Vente" class="h-16 md:h-24" severity="secondary" />
            <Button
                v-for="cat in saleables.serviceCategories"
                :label="cat.label"
                class="h-16 md:h-24"
                severity="secondary"
            />
            <Button
                label="Bon cadeau"
                class="h-16 md:h-24"
                severity="secondary"
            />
            <Button label="Autre" class="h-16 md:h-24" severity="secondary" />
        </div>
    </div>
</template>
