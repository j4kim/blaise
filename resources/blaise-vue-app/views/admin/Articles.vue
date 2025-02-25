<script setup>
import { useArticlesStore } from "../../stores/articles";
import ArticleArticles from "./ArticleArticles.vue";
import ArticleBrands from "./ArticleBrands.vue";
import ArticleLines from "./ArticleLines.vue";

const store = useArticlesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <ArticleArticles />

        <ArticleBrands class="my-10" />

        <ArticleLines />
    </div>
</template>
