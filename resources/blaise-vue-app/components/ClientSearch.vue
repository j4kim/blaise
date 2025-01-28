<script setup>
import { Card, IconField, InputIcon, InputText } from "primevue";
import { onMounted, useTemplateRef, nextTick } from "vue";
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

function to(client) {
    if (!client) return;
    store.focused = false;
    router.push(`clients/${client.id}`);
}

const input = useTemplateRef("input");

onMounted(async () => {
    store.selected = 0;
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

function focusout() {
    setTimeout(() => {
        store.focused = false;
    }, 100);
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
                @keydown.enter.prevent="to(store.clients[store.selected])"
                @focusin="store.focused = true"
                @focusout="focusout"
                ref="input"
            />
            <InputIcon @click="clear" class="pi pi-times cursor-pointer" />
        </IconField>

        <div class="space-y-2 my-2 absolute w-full" v-if="store.focused">
            <Card
                v-for="(client, index) in store.clients"
                @click="to(client)"
                :class="[
                    'cursor-pointer hover:bg-primary',
                    {
                        '!bg-primary': store.selected === index,
                    },
                ]"
            >
                <template #content>
                    <div>{{ client.first_name }} {{ client.last_name }}</div>
                </template>
            </Card>
        </div>
    </div>
</template>
