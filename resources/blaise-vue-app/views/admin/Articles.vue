<script setup>
import { Tab, TabList, Tabs } from "primevue";
import { computed } from "vue";
import { RouterView, useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();

const tab = computed({
    get: () => route.path,
    set: (v) => router.push(v),
});
</script>

<template>
    <div class="flex flex-col h-full">
        <Tabs v-model:value="tab">
            <TabList>
                <Tab value="/admin/articles">Articles</Tab>
                <Tab value="/admin/articles/brands">Marques</Tab>
                <Tab value="/admin/articles/lines">Gammes</Tab>
            </TabList>
        </Tabs>
        <RouterView></RouterView>
    </div>
</template>
