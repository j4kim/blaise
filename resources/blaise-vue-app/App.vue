<script setup>
import { Button } from "primevue";
import ClientSearch from "./components/ClientSearch.vue";
import { useVisitStore } from "./stores/visit";
import CurrentVisit from "./sidebars/CurrentVisit.vue";
import AdminBar from "./sidebars/AdminBar.vue";

const visit = useVisitStore();
</script>

<template>
    <div class="min-h-dvh h-dvh flex md:flex-row flex-col">
        <main class="flex flex-col w-full md:overflow-auto grow">
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
        <CurrentVisit v-if="visit.current" />
        <AdminBar v-if="$route.path.startsWith('/admin')" />
    </div>
</template>
