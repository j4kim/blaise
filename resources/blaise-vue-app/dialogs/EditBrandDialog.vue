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
    <Dialog modal dismissableMask :header="header" class="w-full sm:w-96">
        <form
            class="flex flex-col gap-6"
            @submit.prevent="$emit('save', edited)"
        >
            <div class="grid grid-cols-12 gap-4 mt-2">
                <FloatLabel class="col-span-12" variant="on">
                    <InputText v-model="edited.name" id="name" fluid />
                    <label for="name">Nom</label>
                </FloatLabel>
            </div>

            <div class="flex justify-between">
                <div class="grow"></div>
                <Button type="submit" :label="btn"></Button>
            </div>
        </form>
    </Dialog>
</template>
