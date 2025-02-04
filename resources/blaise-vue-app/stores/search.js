import { defineStore } from "pinia";
import { get, post } from "../api";

export const useSearchStore = defineStore("search", {
    state: () => ({
        query: "",
        clients: [],
        selected: 0,
        empty: false,
    }),

    actions: {
        async search() {
            if (this.query.length < 1) {
                this.$reset();
                return;
            }
            const { response, data } = await get(
                `/api/clients/search/${this.query}`
            );
            if (!response.ok) return;
            this.clients = data;
            if (this.selected > this.clients.length) {
                this.selected = this.clients.length - 1;
            }
            this.empty = !this.clients.length;
        },

        select(n) {
            if (n > this.clients.length || n < -1) return;
            this.selected = n;
        },

        async createFromQuery() {
            const { response, data } = await post(`/api/clients/${this.query}`);
            if (!response.ok) return;
            return data;
        },
    },
});
