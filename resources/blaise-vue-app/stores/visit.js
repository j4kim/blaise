import { defineStore } from "pinia";
import { get, del, post } from "../api";

export const useVisitStore = defineStore("visit", {
    state: () => ({
        current: null,
        client: {},
    }),

    actions: {
        async fetchClient(id) {
            const { data, response } = await get(`/api/clients/${id}`);
            if (!response.ok) return;
            this.client = data;
            this.current = this.client.currentVisit;
        },
        async create() {
            const { data, response } = await post(
                `/api/visits/${this.client.id}`
            );
            if (!response.ok) return;
            this.current = data;
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
        },
        async addService(service) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/services/${service.id}`
            );
            if (!response.ok) return;
            this.current = data;
        },
    },
});
