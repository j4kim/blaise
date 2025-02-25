import { defineStore } from "pinia";
import { del, get, post, put } from "../api";
import { toRaw } from "vue";
import { pick } from "../tools";

export const useArticlesStore = defineStore("articles", {
    state: () => ({
        articles: [],
        brands: [],
        lines: [],
        showArticleDialog: false,
        edited: {},
        articleFilter: "",
        articleDialogHeader: "",
        articleDialogBtn: "",
    }),

    getters: {
        filteredArticles() {
            const parts = this.articleFilter.split(" ");
            return this.articles.filter((a) =>
                parts.every((part) => a.searchText.includes(part))
            );
        },
    },

    actions: {
        prepareArticle(article) {
            const parts = [
                article.label,
                article.brand?.name,
                article.line?.name,
                article.barcode,
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
            this.articleDialogHeader = "Modifier l'article";
            this.articleDialogBtn = "Sauver";
            this.edited = structuredClone(toRaw(article));
            this.showArticleDialog = true;
        },
        openArticleCreateDialog() {
            this.edited = {};
            this.articleDialogHeader = "Nouvel article";
            this.articleDialogBtn = "Créer";
            this.showArticleDialog = true;
        },
        async updateOrCreateArticle(article) {
            const attrs = pick(
                article,
                "sort_order",
                "barcode",
                "label",
                "brand_id",
                "line_id",
                "catalog_price",
                "retail_price"
            );
            const promise = article.id
                ? this.updateArticle(article.id, attrs)
                : this.createArticle(attrs);
            const { data, response } = await promise;
            if (!response.ok) return;
            await this.fetch();
            this.showArticleDialog = false;
        },
        async updateArticle(id, attrs) {
            return await put(`/api/admin/articles/${id}`, attrs);
        },
        async createArticle(attrs) {
            return await post(`/api/admin/articles`, attrs);
        },
        async deleteArticle(id) {
            const { data, response } = await del(`/api/admin/articles/${id}`);
            if (!response.ok) return;
            await this.fetch();
        },
        async deleteBrand(id) {
            const { data, response } = await del(
                `/api/admin/articles/brands/${id}`
            );
            if (!response.ok) return;
            await this.fetch();
        },
        async deleteLine(id) {
            const { data, response } = await del(
                `/api/admin/articles/lines/${id}`
            );
            if (!response.ok) return;
            await this.fetch();
        },
    },
});
