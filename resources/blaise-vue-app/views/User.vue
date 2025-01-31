<script setup>
import { ref } from "vue";
import { get } from "../api";

const user = ref({});

get("/api/user").then(({ data }) => (user.value = data));
</script>

<template>
    Vous êtes connecté·e en tant que {{ user.name }} ( {{ user.email }} )
</template>
