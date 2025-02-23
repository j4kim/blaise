import { defineStore } from "pinia";
import { get, put } from "../api";
import { useVisitStore } from "./visit";

export const useClientStore = defineStore("client", {
    state: () => ({
        selected: null,
        showDetails: false,
        showLastVisits: false,
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
        },
        hidePanels() {
            this.showDetails = false;
            this.showLastVisits = false;
        },
        async save(edited) {
            const { data, response } = await put(
                `/api/clients/${this.selected.id}`,
                edited
            );
            if (!response.ok) return;
            this.selected = data;
        },
    },
});
