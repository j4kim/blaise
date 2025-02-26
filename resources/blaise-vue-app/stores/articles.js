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
        showAddBrandDialog: false,
        showEditBrandDialog: false,
        showAddLineDialog: false,
        showEditLineDialog: false,
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
            await this.fetchArticles();
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
            await this.fetchArticles();
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
        async createBrand(brand) {
            const { data, response } = await post(
                `/api/admin/articles/brands`,
                brand
            );
            if (!response.ok) return;
            await this.fetch();
            this.showAddBrandDialog = false;
        },
        openBrandEditDialog(brand) {
            this.edited = structuredClone(toRaw(brand));
            this.showEditBrandDialog = true;
        },
        async updateBrand(brand) {
            const { data, response } = await put(
                `/api/admin/articles/brands/${brand.id}`,
                pick(brand, "name")
            );
            if (!response.ok) return;
            await this.fetch();
            this.showEditBrandDialog = false;
        },
        async createLine(line) {
            const { data, response } = await post(
                `/api/admin/articles/lines`,
                line
            );
            if (!response.ok) return;
            await this.fetch();
            this.showAddLineDialog = false;
        },
        openLineEditDialog(line) {
            this.edited = structuredClone(toRaw(line));
            this.showEditLineDialog = true;
        },
        async updateLine(line) {
            const { data, response } = await put(
                `/api/admin/articles/lines/${line.id}`,
                pick(line, "name")
            );
            if (!response.ok) return;
            await this.fetch();
            this.showEditLineDialog = false;
        },
    },
});
