<script setup>
import { Message } from "primevue";
import { get } from "../api";
import ClientSearch from "../components/ClientSearch.vue";
import { RouterLink } from "vue-router";
import { computed, ref } from "vue";

const currents = ref({
    count: 0,
    slice: [],
});

const rest = computed(() => currents.value.count - currents.value.slice.length);

const { data, response } = await get("/api/visits/currents");

if (response.ok) {
    currents.value = data;
} else {
    alert(data.message ?? response.statusText);
}
</script>

<template>
    <div class="sm:h-1/3">
        <Message
            v-if="currents.count"
            severity="warn"
            icon="pi pi-exclamation-triangle"
        >
            Vous avez
            {{
                currents.count === 1
                    ? "un ticket non finalisé"
                    : "des tickets non finalisés"
            }}:
            <template v-for="(t, index) in currents.slice">
                <RouterLink :to="`/clients/${t.client_id}`" class="underline">
                    {{ t.client.first_name }} {{ t.client.last_name }}
                </RouterLink>
                <span v-if="index < currents.slice.length - 1"
                    >,
                </span></template
            ><span v-if="rest">
                et {{ rest }} {{ rest === 1 ? "autre" : "autres" }}</span
            >.
        </Message>
    </div>
    <div
        class="flex flex-col justify-center gap-12 items-center sm:max-w-screen-md sm:mx-auto px-2 py-4"
    >
        <h1 class="text-4xl">blaise</h1>
        <ClientSearch class="w-full sm:w-2/3" autofocus />
    </div>
</template>
