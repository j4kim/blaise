<script setup>
import {
    Button,
    Column,
    DataTable,
    IconField,
    InputIcon,
    InputText,
    Message,
} from "primevue";
import { useArticlesStore } from "../stores/articles";
import { useRoute, useRouter } from "vue-router";
import { useVisitStore } from "../stores/visit";
import { computed, reactive } from "vue";

const store = useArticlesStore();
const visit = useVisitStore();

const router = useRouter();
const route = useRoute();

const state = reactive({
    search: "",
    barcode: "",
    message: "",
});

const filtered = computed(() => {
    const parts = state.search.split(" ");
    return store.articles.filter((a) =>
        parts.every((part) => a.searchText.includes(part))
    );
});

async function find() {
    state.message = "";
    if (!state.barcode.length) return;
    const article = store.articles.find((a) => a.barcode == state.barcode);
    if (!article) {
        state.message = "Article inconnu";
        return;
    }
    await add(article);
}

async function add(article) {
    await visit.addArticle(article);
    router.replace(`/clients/${route.params.id}`);
}
</script>

<template>
    <div>
        <h5>Ajouter article</h5>
        <div class="flex gap-3 my-2">
            <IconField class="grow">
                <InputIcon class="pi pi-search" />
                <InputText
                    v-model="state.search"
                    placeholder="Recherche par nom, marque, gamme"
                    size="large"
                    fluid
                />
            </IconField>
            <IconField class="grow">
                <InputIcon class="pi pi-barcode" />
                <InputText
                    v-model="state.barcode"
                    placeholder="Scan Code-barres"
                    size="large"
                    fluid
                    @keydown.enter="find"
                />
            </IconField>
        </div>
        <div>
            <Message v-if="state.message" severity="warn">
                {{ state.message }}
            </Message>

            <DataTable
                v-if="state.search"
                :value="filtered"
                paginator
                :rows="5"
                size="small"
                @row-click="add($event.data)"
                :pt="{
                    bodyRow: {
                        class: 'cursor-pointer hover:bg-surface-100 dark:hover:bg-surface-800',
                    },
                }"
            >
                <template #empty> Aucun article trouvé </template>
                <Column field="label" header="Nom"></Column>
                <Column field="brand.name" header="Marque"></Column>
                <Column field="line.name" header="Gamme"></Column>
                <Column field="stock" header="Stock">
                    <template #body="{ data }">
                        <span
                            :class="{
                                'text-red-600': data.stock === 0,
                                'text-amber-400':
                                    data.stock > 0 && data.stock < 3,
                            }"
                        >
                            {{ data.stock }}
                        </span>
                    </template>
                </Column>
                <Column field="retail_price" header="Prix"></Column>
            </DataTable>
        </div>
        <Button
            @click="$router.replace(`/clients/${$route.params.id}`)"
            label="Retour"
            severity="secondary"
            variant="outlined"
            icon="pi pi-arrow-left"
            class="my-3"
        />
    </div>
</template>
