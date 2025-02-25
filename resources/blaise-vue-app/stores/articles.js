import { defineStore } from "pinia";
import { del, get, put } from "../api";
import { toRaw } from "vue";
import { pick } from "../tools";

export const useArticlesStore = defineStore("articles", {
    state: () => ({
        articles: [],
        brands: [],
        lines: [],
        tab: "articles",
        showArticleDialog: false,
        edited: {},
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
            const { response, data } = await get("/api/articles");
            if (response.ok) {
                this.articles = data.map((a) => this.prepareArticle(a));
            }
        },
        async fetchBrands() {
            const { response, data } = await get("/api/admin/articles/brands");
            if (response.ok) {
                this.brands = data;
            }
        },
        async fetchLines() {
            const { response, data } = await get("/api/admin/articles/lines");
            if (response.ok) {
                this.lines = data;
            }
        },
        async fetch() {
            await Promise.all([
                this.fetchArticles(),
                this.fetchBrands(),
                this.fetchLines(),
            ]);
        },
        openArticleEditDialog(article) {
            this.edited = structuredClone(toRaw(article));
            this.showArticleDialog = true;
        },
        async updateArticle(article) {
            const { data, response } = await put(
                `/api/admin/articles/${article.id}`,
                pick(
                    article,
                    "sort_order",
                    "barcode",
                    "label",
                    "brand_id",
                    "line_id",
                    "catalog_price",
                    "retail_price"
                )
            );
            if (!response.ok) return;
            await this.fetchArticles();
            this.showArticleDialog = false;
        },
        async deleteArticle(id) {
            const { data, response } = await del(`/api/admin/articles/${id}`);
            if (!response.ok) return;
            await this.fetchArticles();
        },
    },
});
