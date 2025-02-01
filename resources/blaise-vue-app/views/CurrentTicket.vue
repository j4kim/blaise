<script setup>
import { useSidebarStore } from "../stores/sidebar";

const sidebar = useSidebarStore();
</script>

<template>
    <h2>Ticket en cours</h2>
    <button @click="sidebar.component = null">Annuler</button>
</template>
