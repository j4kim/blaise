import { defineStore } from "pinia";
import { get } from "../api";

export const useArticlesStore = defineStore("articles", {
    state: () => ({
        articles: [],
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
        async fetchArticles() {
            const { data, response } = await get("/api/articles");
            if (response.ok) {
                this.articles = data.map((a) => this.prepareArticle(a));
            }
        },
    },
});
