import { defineStore } from "pinia";
import { get } from "../api";
import { useVisitStore } from "./visit";

export const useClientStore = defineStore("client", {
    state: () => ({
        selected: null,
        showDetails: false,
        showLastVisits: false,
        showTechnicalSheets: false,
        edited: {},
    }),

    actions: {
        async fetchClient(id) {
            this.selected = null;
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
            this.showTechnicalSheets = false;
        },
        hidePanels() {
            this.showDetails = false;
            this.showLastVisits = false;
            this.showTechnicalSheets = false;
        },
    },
});
