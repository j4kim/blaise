<script setup>
import { Tab, TabList, TabPanel, TabPanels, Tabs } from "primevue";
import ArticleArticles from "./ArticleArticles.vue";
import ArticleBrands from "./ArticleBrands.vue";
import ArticleLines from "./ArticleLines.vue";
import { useArticlesStore } from "../../stores/articles";

const store = useArticlesStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <Tabs v-model:value="store.tab">
            <TabList>
                <Tab value="articles">Articles</Tab>
                <Tab value="brands">Marques</Tab>
                <Tab value="lines">Gammes</Tab>
            </TabList>
            <TabPanels class="!p-0">
                <TabPanel value="articles">
                    <ArticleArticles />
                </TabPanel>
                <TabPanel value="brands">
                    <ArticleBrands />
                </TabPanel>
                <TabPanel value="lines">
                    <ArticleLines />
                </TabPanel>
            </TabPanels>
        </Tabs>
    </div>
</template>
