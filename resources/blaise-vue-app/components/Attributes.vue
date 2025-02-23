<script setup lang="ts">
import Attribute from "./Attribute.vue";

defineProps<{
    attributes: { label: String; value: String }[];
}>();
</script>

<template>
    <div class="grid lg:grid-cols-3 grid-cols-2 gap-4">
        <Attribute v-for="a in attributes" :label="a.label" :value="a.value" />
        <slot name="extra"></slot>
    </div>
</template>
