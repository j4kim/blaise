<script setup>
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";

const visit = useVisitStore();
</script>

<template>
    <h2 class="text-3xl font-extralight mb-3">Ticket en cours</h2>

    <div class="grow"></div>

    <Button class="my-3">Valider</Button>
    <Button
        @click="visit.deleteCurrent()"
        variant="text"
        severity="secondary"
        size="small"
    >
        Annuler
    </Button>
</template>
