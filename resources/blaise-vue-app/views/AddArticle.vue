<script setup>
import { Button, IconField, InputIcon, InputText } from "primevue";
import { useSaleablesStore } from "../stores/saleables";
import { useRouter } from "vue-router";
import { useVisitStore } from "../stores/visit";

const saleables = useSaleablesStore();
const visit = useVisitStore();

const router = useRouter();

async function add(article) {
    await visit.addArticle(service);
    router.replace(`/clients/${route.params.id}`);
}
</script>

<template>
    <div>
        <h5 class="mb-2">Ajouter article</h5>
        <div class="flex gap-3">
            <IconField class="grow">
                <InputIcon class="pi pi-search" />
                <InputText
                    v-model="value1"
                    placeholder="Recherche par nom ou marque"
                    size="large"
                    fluid
                />
            </IconField>
            <IconField class="grow">
                <InputIcon class="pi pi-barcode" />
                <InputText
                    v-model="value1"
                    placeholder="Scan code barre"
                    size="large"
                    fluid
                />
            </IconField>
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
