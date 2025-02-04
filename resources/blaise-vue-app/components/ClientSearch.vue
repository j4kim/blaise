<script setup>
import { Card, IconField, InputIcon, InputText } from "primevue";
import { onMounted, useTemplateRef, nextTick, ref } from "vue";
import { useRouter } from "vue-router";
import { useSearchStore } from "../stores/search";

const props = defineProps({
    size: {
        type: String,
        default: "large",
    },
    autofocus: Boolean,
});

const router = useRouter();

const store = useSearchStore();

const focused = ref(false);

function to(client) {
    if (!client) return;
    store.$reset();
    router.push(`/clients/${client.id}`);
}

async function createFromQuery() {
    const newClient = await store.createFromQuery();
    to(newClient);
}

const input = useTemplateRef("input");

onMounted(async () => {
    if (props.autofocus) {
        await nextTick();
        input.value.$el.focus();
    }
});

function clear() {
    store.query = "";
    store.clients = [];
    input.value.$el.focus();
}

async function enter() {
    if (store.query && store.empty) {
        await createFromQuery();
    } else {
        to(store.clients[store.selected]);
    }
}
</script>

<template>
    <div class="relative">
        <IconField>
            <InputIcon class="pi pi-search" />
            <InputText
                class="w-full"
                placeholder="Recherche client·e"
                :size="size"
                v-model="store.query"
                @input="store.search"
                @keydown.up.prevent="store.select(store.selected - 1)"
                @keydown.down.prevent="store.select(store.selected + 1)"
                @keydown.enter.prevent="enter"
                @focus="focused = true"
                @blur="focused = false"
                ref="input"
            />
            <InputIcon @click="clear" class="pi pi-times cursor-pointer" />
        </IconField>

        <div
            class="space-y-2 my-2 absolute w-full z-10"
            v-if="props.autofocus || focused"
        >
            <Card
                v-for="(client, index) in store.clients"
                @mousedown="to(client)"
                :class="[
                    'cursor-pointer hover:!bg-highlight',
                    {
                        '!bg-primary !text-white': store.selected === index,
                    },
                ]"
            >
                <template #content>
                    <div>{{ client.first_name }} {{ client.last_name }}</div>
                </template>
            </Card>
            <Card
                v-if="store.query && store.empty"
                @mousedown="createFromQuery"
                :class="[
                    'cursor-pointer hover:!bg-emerald-500',
                    {
                        '!bg-emerald-400 !text-white': store.selected === 0,
                    },
                ]"
            >
                <template #content>
                    <div>Créer client·e {{ store.query }}</div>
                </template>
            </Card>
        </div>
    </div>
</template>
