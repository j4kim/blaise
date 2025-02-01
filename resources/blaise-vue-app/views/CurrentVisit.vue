<script setup>
import { Button } from "primevue";
import { useSidebarStore } from "../stores/sidebar";

const sidebar = useSidebarStore();
</script>

<template>
    <h2 class="text-3xl font-extralight mb-3">Ticket en cours</h2>

    <div class="grow"></div>

    <Button class="my-3">Valider</Button>
    <Button
        @click="sidebar.component = null"
        variant="text"
        severity="secondary"
        size="small"
    >
        Annuler
    </Button>
</template>
