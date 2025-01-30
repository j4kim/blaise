import { defineStore } from "pinia";

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
            const response = await fetch(`/api/clients/search/${this.query}`, {
                headers: { Accept: "application/json" },
            });
            const data = await response.json();
            this.clients = data;
        },

        select(n) {
            if (n >= this.clients.length || n < -1) return;
            this.selected = n;
        },
    },
});
