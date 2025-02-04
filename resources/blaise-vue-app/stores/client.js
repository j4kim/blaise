import { defineStore } from "pinia";
import { get, put } from "../api";
import { useVisitStore } from "./visit";
import { toRaw } from "vue";

export const useClientStore = defineStore("client", {
    state: () => ({
        selected: {},
        showDetails: false,
        showLastVisits: false,
        showEditDialog: false,
        edited: {},
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
        openEditDialog() {
            this.edited = pick(
                this.selected,
                "first_name",
                "last_name",
                "gender",
                "tel_1",
                "tel_2",
                "tel_3",
                "npa",
                "location"
            );
            this.showEditDialog = true;
        },
        async save() {
            const { data, response } = await put(
                `/api/clients/${this.selected.id}`,
                this.edited
            );
            if (!response.ok) return;
            this.selected = data;
            this.showEditDialog = false;
        },
    },
});
