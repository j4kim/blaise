import { defineStore } from "pinia";
import { get } from "../api";

export const useSaleablesStore = defineStore("saleables", {
    state: () => ({
        articles: [],
        serviceCategories: [],
    }),

    actions: {
        async fetchServices() {
            const { data, response } = await get("/api/services");
            if (response.ok) {
                this.serviceCategories = data;
            }
        },
        async fetchArticles() {
            const { data, response } = await get("/api/articles");
            if (response.ok) {
                this.articles = data;
            }
        },
    },
});
