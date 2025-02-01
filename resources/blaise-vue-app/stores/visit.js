import { defineStore } from "pinia";
import { del, post } from "../api";

export const useVisitStore = defineStore("visit", {
    state: () => ({
        current: null,
    }),

    actions: {
        async create(client) {
            this.current = (await post(`/api/visits/${client.id}`)).data;
        },
        async deleteCurrent() {
            await del(`/api/visits/${this.current.id}`);
            this.current = null;
        },
    },
});
