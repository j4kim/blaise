import { defineStore } from "pinia";
import { get, del, post, put } from "../api";
import { toRaw } from "vue";

export const useVisitStore = defineStore("visit", {
    state: () => ({
        current: null,
        client: {},
        showClientDetails: false,
        showClientLastVisits: false,
        showSaleDialog: false,
        selectedSale: null,
    }),

    actions: {
        async fetchClient(id) {
            const { data, response } = await get(`/api/clients/${id}`);
            if (!response.ok) return;
            this.client = data;
            this.current = this.client.currentVisit;
            this.showClientDetails = false;
            this.showClientLastVisits = true;
        },
        async create() {
            const { data, response } = await post(
                `/api/visits/${this.client.id}`
            );
            if (!response.ok) return;
            this.current = data;
            this.showClientDetails = false;
            this.showClientLastVisits = false;
        },
        async validateCurrent() {
            const { response } = await post(
                `/api/visits/${this.current.id}/validate`
            );
            if (!response.ok) return;
            await this.fetchClient(this.client.id);
        },
        async deleteCurrent() {
            const { response } = await del(`/api/visits/${this.current.id}`);
            if (!response.ok) return;
            this.current = null;
            this.showClientDetails = false;
            this.showClientLastVisits = true;
        },
        async addService(service) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/services/${service.id}`
            );
            if (!response.ok) return;
            this.current = data;
        },
        async addArticle(article) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/article/${article.id}`
            );
            if (!response.ok) return;
            this.current = data;
        },
        async addSale({ type, label }) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/sale`,
                { type, label, price_charged: 50 }
            );
            if (!response.ok) return;
            this.current = data;
        },
        openSaleDialog(sale) {
            this.selectedSale = structuredClone(toRaw(sale));
            this.showSaleDialog = true;
        },
        async saveSelectedSale() {
            const { response, data } = await put(
                `/api/visits/${this.current.id}/sale/${this.selectedSale.id}`,
                this.selectedSale
            );
            if (!response.ok) return;
            this.current = data;
            this.showSaleDialog = false;
        },
    },
});
