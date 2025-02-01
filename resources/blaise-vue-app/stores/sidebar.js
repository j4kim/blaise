import { defineStore } from "pinia";

export const useSidebarStore = defineStore("sidebar", {
    state: () => ({
        component: null,
    }),
});
