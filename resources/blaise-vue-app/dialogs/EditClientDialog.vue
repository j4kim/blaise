<script setup>
import {
    Button,
    Dialog,
    FloatLabel,
    InputNumber,
    InputText,
    Select,
} from "primevue";

const props = defineProps({
    edited: Object,
    header: {
        type: String,
        default: "Modification des coordonnées",
    },
    btn: {
        type: String,
        default: "Sauver",
    },
});
</script>

<template>
    <Dialog
        modal
        dismissableMask
        :header="header"
        class="w--min-full sm:max-w-screen-sm w-full"
    >
        <form
            class="flex flex-col gap-6"
            @submit.prevent="$emit('save', edited)"
        >
            <div class="grid grid-cols-12 gap-4 mt-2">
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText
                        v-model="edited.first_name"
                        id="first_name"
                        fluid
                    />
                    <label for="first_name">Prénom</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText
                        v-model="edited.last_name"
                        id="last_name"
                        fluid
                    />
                    <label for="last_name">Nom</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <Select
                        v-model="edited.gender"
                        id="gender"
                        :options="[
                            { value: 0, label: 'Femme' },
                            { value: 1, label: 'Homme' },
                        ]"
                        optionLabel="label"
                        optionValue="value"
                        fluid
                        showClear
                    />
                    <label for="gender">Genre</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText v-model="edited.tel_1" id="tel_1" fluid />
                    <label for="tel_1">Tel 1</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText v-model="edited.tel_2" id="tel_2" fluid />
                    <label for="tel_2">Tel 2</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText v-model="edited.tel_3" id="tel_3" fluid />
                    <label for="tel_3">Tel 3</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputNumber v-model="edited.npa" id="npa" fluid />
                    <label for="npa">NPA</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputText v-model="edited.location" id="location" fluid />
                    <label for="location">Ville</label>
                </FloatLabel>
            </div>

            <div class="flex justify-between">
                <div class="grow"></div>
                <Button type="submit" :label="btn"></Button>
            </div>
        </form>
    </Dialog>
</template>
