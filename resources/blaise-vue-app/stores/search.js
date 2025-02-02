import { defineStore } from "pinia";
import { get } from "../api";

export const useSearchStore = defineStore("search", {
    state: () => ({
        query: "",
        clients: [],
        selected: 0,
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
            if (this.selected >= this.clients.length) {
                this.selected = this.clients.length - 1;
            }
        },

        select(n) {
            if (n >= this.clients.length || n < -1) return;
            this.selected = n;
        },
    },
});
