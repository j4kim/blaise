<script setup>
import { RouterLink } from "vue-router";

const links = [
    { title: "Profil", to: "/admin/profile" },
    { title: "Clients", to: "/admin/clients" },
    { title: "Services", to: "/admin/services" },
    { title: "Articles", to: "/admin/articles" },
    { title: "Compta", to: "/admin/compta" },
];
</script>

<template>
    <aside
        class="bg-surface-100 dark:bg-surface-900 w-full md:w-64 shrink-0 border-t md:border-l md:border-t-0 dark:border-surface-700 px-5 py-3 flex flex-col gap-5"
    >
        <h2 class="text-3xl font-extralight mb-1">Administration</h2>

        <div class="overflow-y-auto -mx-5">
            <RouterLink
                v-for="{ to, title } in links"
                :to="to"
                class="block cursor-pointer hover:bg-surface-200 dark:hover:bg-surface-800 px-5 py-3 sm:text-lg"
                exactActiveClass="font-bold text-primary"
            >
                {{ title }}
            </RouterLink>
        </div>
    </aside>
</template>
