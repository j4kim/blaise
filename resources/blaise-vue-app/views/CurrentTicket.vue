<script setup>
import { Button } from "primevue";
import { useSidebarStore } from "../stores/sidebar";

const sidebar = useSidebarStore();
</script>

<template>
    <h2 class="text-3xl font-extralight">Ticket en cours</h2>

    <div class="grow"></div>

    <Button class="mb-3">Valider</Button>
    <button @click="sidebar.component = null" class="text-sm">Annuler</button>
</template>
