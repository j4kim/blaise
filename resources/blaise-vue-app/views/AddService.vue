<script setup>
import { Button } from "primevue";
import { useRoute, useRouter } from "vue-router";
import { computed } from "vue";
import { useVisitStore } from "../stores/visit";
import { useServicesStore } from "../stores/services";

const store = useServicesStore();
const visit = useVisitStore();

const route = useRoute();
const router = useRouter();

const category = computed(() =>
    store.categories.find((c) => c.id == route.params.catId)
);

async function add(service) {
    await visit.addService(service);
    router.replace(`/clients/${route.params.id}`);
}
</script>

<template>
    <div>
        <h5 class="mb-2">Ajouter {{ category.label }}</h5>
        <div class="flex gap-3 flex-col">
            <Button
                v-for="service in category.services"
                @click="add(service)"
                severity="secondary"
                size="large"
            >
                <div class="grow text-left">{{ service.label }}</div>
                <div>CHF&nbsp;{{ service.price }}</div>
            </Button>
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
