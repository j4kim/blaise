<script setup lang="ts">
import {
    Button,
    Dialog,
    FloatLabel,
    InputNumber,
    InputText,
    Select,
} from "primevue";
import { useClientStore } from "../stores/client";

const client = useClientStore();
</script>

<template>
    <Dialog
        v-model:visible="client.showEditDialog"
        modal
        dismissableMask
        header="Modification des coordonnées"
        class="w--min-full sm:max-w-screen-sm w-full"
    >
        <form class="flex flex-col gap-6" @submit.prevent="client.save">
            <div class="grid grid-cols-12 gap-4 mt-2">
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText
                        v-model="client.edited.first_name"
                        id="first_name"
                        fluid
                    />
                    <label for="first_name">Prénom</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText
                        v-model="client.edited.last_name"
                        id="last_name"
                        fluid
                    />
                    <label for="last_name">Nom</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <Select
                        v-model="client.edited.gender"
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
                    <InputText v-model="client.edited.tel_1" id="tel_1" fluid />
                    <label for="tel_1">Tel 1</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText v-model="client.edited.tel_2" id="tel_2" fluid />
                    <label for="tel_2">Tel 2</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-4" variant="on">
                    <InputText v-model="client.edited.tel_3" id="tel_3" fluid />
                    <label for="tel_3">Tel 3</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputNumber v-model="client.edited.npa" id="npa" fluid />
                    <label for="npa">NPA</label>
                </FloatLabel>
                <FloatLabel class="col-span-12 sm:col-span-6" variant="on">
                    <InputText
                        v-model="client.edited.location"
                        id="location"
                        fluid
                    />
                    <label for="location">Ville</label>
                </FloatLabel>
            </div>

            <div class="flex justify-between">
                <div class="grow"></div>
                <Button type="submit" label="Sauver"></Button>
            </div>
        </form>
    </Dialog>
</template>
