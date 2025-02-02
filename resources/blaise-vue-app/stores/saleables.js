import { defineStore } from "pinia";
import { get, del, post } from "../api";

export const useSaleablesStore = defineStore("saleables", {
    state: () => ({
        articles: [],
        servicecategories: [],
    }),

    actions: {
        async fetchServices() {
            const { data, response } = await get("/api/services");
            if (response.ok) {
                this.servicecategories = data;
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
