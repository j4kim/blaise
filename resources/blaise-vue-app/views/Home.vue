<script setup>
import ClientSearch from "../components/ClientSearch.vue";
</script>

<template>
    <div class="sm:h-1/3"></div>
    <div
        class="flex flex-col justify-center gap-12 items-center sm:max-w-screen-md sm:mx-auto px-2 py-4"
    >
        <h1 class="text-4xl">blaise</h1>
        <ClientSearch class="w-full sm:w-2/3" autofocus />
    </div>
</template>
