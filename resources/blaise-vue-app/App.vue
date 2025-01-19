<script setup>
import { RouterView } from "vue-router";
</script>

<template>
    <div class="md:max-w-screen-md md:mx-auto">
        <RouterLink to="/">
            <h1 class="text-xl py-4">blaise</h1>
        </RouterLink>
        <Suspense>
            <RouterView />
        </Suspense>
    </div>
</template>
