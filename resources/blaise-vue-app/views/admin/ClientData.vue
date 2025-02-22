<script setup>
import { RouterLink } from "vue-router";
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-4 flex justify-between flex-wrap">
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
                {{ $route.params.clientId }}
            </span>
        </header>
    </div>
</template>
