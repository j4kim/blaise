import { defineStore } from "pinia";
import { post } from "../api";

export const useVisitStore = defineStore("visit", {
    state: () => ({
        current: null,
    }),

    actions: {
        async create(client) {
            this.current = (await post(`/api/clients/${client.id}/visit`)).data;
        },
    },
});
