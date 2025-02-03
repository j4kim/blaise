import { defineStore } from "pinia";
import { get } from "../api";

export const useSaleablesStore = defineStore("saleables", {
    state: () => ({
        articles: [],
        serviceCategories: [],
    }),

    actions: {
        prepareArticle(article) {
            const parts = [
                article.label,
                article.brand?.name,
                article.line?.name,
            ];
            article.searchText = parts
                .filter((s) => s)
                .map((s) => s.toLowerCase())
                .join(" ");
            return article;
        },
        async fetchServices() {
            const { data, response } = await get("/api/services");
            if (response.ok) {
                this.serviceCategories = data;
            }
        },
        async fetchArticles() {
            const { data, response } = await get("/api/articles");
            if (response.ok) {
                this.articles = data.map((a) => this.prepareArticle(a));
            }
        },
    },
});
