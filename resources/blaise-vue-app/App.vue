<script setup>
import { Button } from "primevue";
import ClientSearch from "./components/ClientSearch.vue";
import { useVisitStore } from "./stores/visit";
import CurrentVisit from "./sidebars/CurrentVisit.vue";

const visit = useVisitStore();
</script>

<template>
    <div
        class="min-h-dvh md:h-dvh flex md:flex-row dark:bg-surface-900"
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
            <div class="h-full w-full overflow-auto">
                <div class="sm:max-w-screen-md sm:mx-auto px-2 py-4 h-full">
                    <Suspense>
                        <RouterView />
                    </Suspense>
                </div>
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
        <CurrentVisit v-if="visit.current" />
    </div>
</template>
