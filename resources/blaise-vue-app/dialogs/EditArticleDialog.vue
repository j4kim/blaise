<script setup>
import {
    Button,
    Dialog,
    FloatLabel,
    InputNumber,
    InputText,
    Select,
} from "primevue";
import { useArticlesStore } from "../stores/articles";

const store = useArticlesStore();

const props = defineProps({
    edited: Object,
    header: {
        type: String,
        default: "Modifier",
    },
    btn: {
        type: String,
        default: "Sauver",
    },
});
</script>

<template>
    <Dialog modal dismissableMask :header="header" class="w-full sm:w-auto">
        <form
            class="flex flex-col gap-6"
            @submit.prevent="$emit('save', edited)"
        >
            <div class="grid grid-cols-12 gap-4 mt-2">
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputNumber
                        v-model="edited.sort_order"
                        id="sort_order"
                        fluid
                        showButtons
                    />
                    <label for="sort_order">Order</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputText v-model="edited.barcode" id="barcode" fluid />
                    <label for="barcode">Code-barres</label>
                </FloatLabel>
                <FloatLabel class="col-span-12" variant="on">
                    <InputText v-model="edited.label" id="label" fluid />
                    <label for="label">Nom</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <Select
                        v-model="edited.brand_id"
                        :options="store.brands"
                        optionLabel="name"
                        optionValue="id"
                        id="brand"
                        fluid
                    />
                    <label for="brand">Marque</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <Select
                        v-model="edited.line_id"
                        :options="store.lines"
                        optionLabel="name"
                        optionValue="id"
                        id="line"
                        fluid
                    />
                    <label for="line">Gamme</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputNumber
                        v-model="edited.catalog_price"
                        id="catalog_price"
                        mode="currency"
                        currency="CHF"
                        locale="fr-CH"
                        showButtons
                        fluid
                    />
                    <label for="catalog_price">Prix catalogue</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputNumber
                        v-model="edited.retail_price"
                        id="retail_price"
                        mode="currency"
                        currency="CHF"
                        locale="fr-CH"
                        showButtons
                        fluid
                    />
                    <label for="retail_price">Prix de vente</label>
                </FloatLabel>
            </div>

            <div class="flex justify-between">
                <div class="grow"></div>
                <Button type="submit" :label="btn"></Button>
            </div>
        </form>
    </Dialog>
</template>
