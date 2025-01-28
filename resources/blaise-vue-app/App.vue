<script setup>
import ClientSearch from "./components/ClientSearch.vue";
</script>

<template>
    <header
        v-if="$route.path != '/'"
        class="flex justify-between px-3 py-2 bg-surface-950 items-center"
    >
        <RouterLink to="/" class="text-xl hover:text-primary">
            <h1>blaise</h1>
        </RouterLink>
        <ClientSearch size="small" />
    </header>
    <div class="md:max-w-screen-md md:mx-auto p-2 h-full w-full">
        <Suspense>
            <RouterView />
        </Suspense>
    </div>
    <footer class="text-center p-3">Administration</footer>
</template>
