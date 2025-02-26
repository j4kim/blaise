<script setup>
import { get } from "../api";
import ClientSearch from "../components/ClientSearch.vue";
import { RouterLink } from "vue-router";
import { ref } from "vue";

const currents = ref([]);

const { data, response } = await get("/api/visits/currents");

if (response.ok) {
    currents.value = data;
} else {
    alert(data.message ?? response.statusText);
}
</script>

<template>
    <div
        class="flex md:h-full flex-col justify-center gap-12 items-center md:max-w-screen-md md:mx-auto px-2 pt-8 pb-48"
    >
        <h1 class="text-4xl">blaise</h1>
        <div
            class="flex w-full gap-28 md:gap-8 items-center flex-col md:flex-row"
        >
            <div
                :class="{
                    'md:w-1/2': currents.length,
                    'w-full': !currents.length,
                }"
            >
                <ClientSearch class="max-w-md mx-auto" autofocus />
            </div>
            <div
                v-if="currents.length"
                class="bg-emphasis w-full h-px md:w-px md:h-full"
            ></div>
            <div v-if="currents.length" class="w-full md:w-1/2">
                <h2 class="text-xl font-extralight mb-4">Tickets en attente</h2>
                <div class="sm:max-h-96 overflow-y-auto">
                    <div class="flex flex-col gap-2">
                        <RouterLink
                            v-for="visit in currents"
                            :to="`/clients/${visit.client.id}`"
                            class="px-4 py-2 rounded-md bg-emphasis hover:bg-highlight"
                        >
                            {{ visit.client.first_name }}
                            {{ visit.client.last_name }}
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
