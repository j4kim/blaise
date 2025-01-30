import { defineStore } from "pinia";
import { get } from "../api";

export const useSearchStore = defineStore("search", {
    state: () => ({
        query: "",
        clients: [],
        selected: -1,
    }),

    actions: {
        async search() {
            if (this.query.length < 1) {
                this.clients = [];
                return;
            }
            this.clients = await get(`/api/clients/search/${this.query}`);
        },

        select(n) {
            if (n >= this.clients.length || n < -1) return;
            this.selected = n;
        },
    },
});
