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
            this.current = (await post(`/api/visits/${this.client.id}`)).data;
        },
        async deleteCurrent() {
            await del(`/api/visits/${this.current.id}`);
            this.current = null;
        },
    },
});
