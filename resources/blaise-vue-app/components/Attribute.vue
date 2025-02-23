<script setup lang="ts">
defineProps<{
    label: String;
    value: String;
}>();
</script>

<template>
    <dl>
        <dt class="text-sm text-muted-color">{{ label }}</dt>
        <dd v-html="value"></dd>
    </dl>
</template>
