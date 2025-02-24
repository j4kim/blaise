<script setup>
import { Button, Dialog, FloatLabel, InputNumber, InputText } from "primevue";

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
    <Dialog modal dismissableMask :header="header">
        <form
            class="flex flex-col gap-6"
            @submit.prevent="$emit('save', edited)"
        >
            <div class="grid grid-cols-12 gap-4 mt-2">
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputText v-model="edited.label" id="label" fluid />
                    <label for="label">Libellé</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputNumber
                        v-model="edited.sort_order"
                        id="sort_order"
                        fluid
                        showButtons
                    />
                    <label for="sort_order">Order</label>
                </FloatLabel>
            </div>

            <div class="flex justify-between">
                <div class="grow"></div>
                <Button type="submit" :label="btn"></Button>
            </div>
        </form>
    </Dialog>
</template>
