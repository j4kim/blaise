<script setup>
import { reactive } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { get } from "../../api";

const route = useRoute();

const state = reactive({ client: {} });

async function fetchClient(id) {
    const { data, response } = await get(`/api/admin/clients/${id}`);
    if (!response.ok) return;
    state.client = data;
}

fetchClient(route.params.clientId);
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex justify-between flex-wrap">
            <span class="text-xl font-extralight">
                <RouterLink
                    to="/admin/clients"
                    class="opacity-50 hover:opacity-100"
                >
                    Clients
                </RouterLink>
                <i
                    class="pi pi-chevron-right opacity-50"
                    style="font-size: 0.7rem"
                ></i>
                {{ state.client.first_name }} {{ state.client.last_name }}
            </span>
        </header>
    </div>
</template>
