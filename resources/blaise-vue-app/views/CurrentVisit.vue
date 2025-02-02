<script setup>
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";
import dayjs from "dayjs";

const visit = useVisitStore();
</script>

<template>
    <h2 class="text-3xl font-extralight mb-1">Ticket en cours</h2>
    <h5 class="text-muted-color text-sm">
        Visite du
        {{ dayjs(visit.current.visit_date).format("DD.MM.YYYY HH:mm") }}
    </h5>

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
