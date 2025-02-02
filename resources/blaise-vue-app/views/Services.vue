<script setup>
import { Button } from "primevue";
import { useSaleablesStore } from "../stores/saleables";
import { useRoute } from "vue-router";
import { computed } from "vue";

const saleables = useSaleablesStore();

const route = useRoute();

const category = computed(() =>
    saleables.serviceCategories.find((c) => c.id == route.params.catId)
);
</script>

<template>
    <div>
        <h5 class="mb-2">Ajouter {{ category.label }}</h5>
        <div class="flex gap-3 flex-col">
            <Button
                v-for="service in category.services"
                :label="service.label"
                severity="secondary"
            />
        </div>
        <Button
            @click="$router.replace(`/clients/${$route.params.id}`)"
            label="Retour"
            severity="secondary"
            variant="outlined"
            icon="pi pi-arrow-left"
            class="my-3"
        />
    </div>
</template>
