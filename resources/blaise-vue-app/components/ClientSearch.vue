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
        </div>
    </div>
</template>
