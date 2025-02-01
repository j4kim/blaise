<script setup>
import { Button } from "primevue";
import { useSidebarStore } from "../stores/sidebar";

const sidebar = useSidebarStore();
</script>

<template>
    <h2 class="text-3xl font-extralight">Ticket en cours</h2>

    <div class="grow"></div>

    <Button class="mb-3">Valider</Button>
    <Button
        @click="sidebar.component = null"
        variant="text"
        severity="secondary"
        size="small"
    >
        Annuler
    </Button>
</template>
