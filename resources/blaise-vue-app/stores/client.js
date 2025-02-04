import { defineStore } from "pinia";
import { get } from "../api";
import { useVisitStore } from "./visit";

export const useClientStore = defineStore("client", {
    state: () => ({
        selected: {},
        showDetails: false,
        showLastVisits: false,
    }),

    actions: {
        async fetchClient(id) {
            const { data, response } = await get(`/api/clients/${id}`);
            if (!response.ok) return;
            this.selected = data;
            useVisitStore().current = this.selected.currentVisit;
            this.resetPanels();
        },
        resetPanels() {
            this.showDetails = false;
            const visit = useVisitStore();
            this.showLastVisits = !visit.current;
        },
        hidePanels() {
            this.showDetails = false;
            this.showLastVisits = false;
        },
    },
});
