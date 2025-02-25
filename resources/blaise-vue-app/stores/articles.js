import { defineStore } from "pinia";
import { get } from "../api";

export const useArticlesStore = defineStore("articles", {
    state: () => ({
        articles: [],
        brands: [],
        lines: [],
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
        async fetch() {
            const [articles, brands, lines] = await Promise.all([
                get("/api/articles"),
                get("/api/admin/articles/brands"),
                get("/api/admin/articles/lines"),
            ]);
            if (articles.response.ok) {
                this.articles = articles.data.map((a) =>
                    this.prepareArticle(a)
                );
            }
            if (brands.response.ok) {
                this.brands = brands.data;
            }
            if (lines.response.ok) {
                this.lines = lines.data;
            }
        },
    },
});
