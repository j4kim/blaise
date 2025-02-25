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
        articleFilter: "",
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
            await this.fetch();
            this.showArticleDialog = false;
        },
        async deleteArticle(id) {
            const { data, response } = await del(`/api/admin/articles/${id}`);
            if (!response.ok) return;
            await this.fetch();
        },
    },
});
