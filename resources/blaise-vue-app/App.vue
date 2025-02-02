<script setup>
import { Button } from "primevue";
import ClientSearch from "./components/ClientSearch.vue";
import { useVisitStore } from "./stores/visit";
import CurrentVisit from "./views/CurrentVisit.vue";

const visit = useVisitStore();
</script>

<template>
    <div
        class="min-h-dvh flex md:flex-row dark:bg-surface-900"
        :class="{
            'flex-col': visit.current,
        }"
    >
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
            <div class="sm:max-w-screen-md sm:mx-auto px-2 py-4 h-full w-full">
                <Suspense>
                    <RouterView />
                </Suspense>
            </div>
            <footer
                v-if="!$route.meta.hideFooter"
                class="text-center p-3 text-sm md:block"
                :class="{
                    hidden: visit.current,
                }"
            >
                <Button
                    @click="$router.push('/admin')"
                    variant="text"
                    severity="secondary"
                    size="small"
                >
                    Administration
                </Button>
            </footer>
        </main>
        <aside
            v-if="visit.current"
            class="bg-surface-100 dark:bg-surface-900 w-full md:w-96 xl:w-1/3 shrink-0 border-l dark:border-surface-700 px-5 py-3 flex flex-col"
        >
            <CurrentVisit />
        </aside>
    </div>
</template>
