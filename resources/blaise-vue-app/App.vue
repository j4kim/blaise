<script setup>
import ClientSearch from "./components/ClientSearch.vue";
import { useSidebarStore } from "./stores/sidebar";

const sidebar = useSidebarStore();
</script>

<template>
    <main class="flex flex-col w-full overflow-auto">
        <header
            v-if="!$route.meta.hideHeader"
            class="flex justify-between px-3 py-2 bg-surface-100 dark:bg-surface-950 items-center"
        >
            <RouterLink to="/" class="text-xl hover:text-primary">
                <h1>blaise</h1>
            </RouterLink>
            <ClientSearch size="small" class="w-52" />
        </header>
        <div class="md:max-w-screen-md md:mx-auto px-2 py-4 h-full w-full">
            <Suspense>
                <RouterView />
            </Suspense>
        </div>
        <footer v-if="!$route.meta.hideFooter" class="text-center p-3">
            Administration
        </footer>
    </main>
    <aside
        v-if="sidebar.open"
        class="bg-surface-100 dark:bg-surface-900 w-full sm:w-96 xl:w-1/3 shrink-0 border-l dark:border-surface-700"
    ></aside>
</template>
