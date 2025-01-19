<script setup>
import { Card, IconField, InputIcon, InputText } from "primevue";
import { onMounted, useTemplateRef, nextTick } from "vue";
import { useRouter } from "vue-router";
import { useSearchStore } from "../stores/search";

const router = useRouter();

const store = useSearchStore();

function to(client) {
    if (!client) return;
    router.push(`clients/${client.id}`);
}

const input = useTemplateRef("input");

onMounted(async () => {
    await nextTick();
    input.value.$el.focus();
});
</script>

<template>
    <IconField>
        <InputIcon class="pi pi-search" />
        <InputText
            placeholder="Recherche client-e"
            v-model="store.query"
            @input="store.search"
            @keydown.up.prevent="store.select(store.selected - 1)"
            @keydown.down.prevent="store.select(store.selected + 1)"
            @keydown.enter.prevent="to(store.clients[store.selected])"
            ref="input"
        />
    </IconField>

    <div class="space-y-2 my-2">
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
</template>
