<script setup>
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";
import { useServicesStore } from "../stores/services";

const servicesStore = useServicesStore();

const visit = useVisitStore();
</script>

<template>
    <div>
        <h5 class="mb-2">Ajouter articles et prestations</h5>
        <div
            class="grid gap-3 grid-cols-2 sm:grid-cols-4 md:grid-cols-2 lg:grid-cols-4"
        >
            <Button
                label="Article"
                @click="
                    $router.replace(`/clients/${$route.params.id}/articles/`)
                "
                class="h-16 md:h-24"
                severity="secondary"
                size="large"
            />
            <Button
                v-for="cat in servicesStore.categories"
                :label="cat.label"
                @click="
                    $router.replace(
                        `/clients/${$route.params.id}/services/${cat.id}`
                    )
                "
                class="h-16 md:h-24"
                severity="secondary"
                size="large"
            />
            <Button
                label="Bon cadeau"
                @click="visit.addSale({ type: 'voucher', label: 'Bon cadeau' })"
                class="h-16 md:h-24"
                severity="secondary"
                size="large"
            />
            <Button
                label="Autre"
                @click="visit.addSale({ type: 'other', label: 'Autre' })"
                class="h-16 md:h-24"
                severity="secondary"
                size="large"
            />
        </div>
    </div>
</template>
