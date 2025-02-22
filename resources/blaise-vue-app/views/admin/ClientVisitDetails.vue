<script setup>
import { useRoute } from "vue-router";

const route = useRoute();
</script>

<template>
    <div class="py-2 px-3">
        <h2 class="text-xl font-extralight mb-2">
            <RouterLink
                :to="`/admin/clients/${route.params.clientId}`"
                class="opacity-50 hover:opacity-100"
            >
                Toutes les visites
            </RouterLink>
            <i
                class="pi pi-chevron-right opacity-50"
                style="font-size: 0.7rem"
            ></i>
            Visite {{ route.params.visitId }}
        </h2>
    </div>
</template>
