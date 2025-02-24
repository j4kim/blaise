<script setup>
import { DatePicker, FloatLabel } from "primevue";
import { useAdminFinanceStore } from "../../stores/admin/finance";

const store = useAdminFinanceStore();
</script>

<template>
    <div class="flex flex-col h-full">
        <header class="py-2 px-3 flex gap-3 justify-between flex-wrap">
            <h2 class="text-xl font-extralight">Comptabilité</h2>
        </header>
        <div class="py-2 px-3">
            <h3>Bilan financier par période</h3>
            <div class="flex gap-2 my-2">
                <FloatLabel variant="on">
                    <DatePicker
                        v-model="store.dateFrom"
                        showIcon
                        inputId="date-from"
                        iconDisplay="input"
                        showButtonBar
                        :maxDate="store.dateTo"
                    />
                    <label for="date-from">Depuis le</label>
                </FloatLabel>
                <FloatLabel variant="on">
                    <DatePicker
                        v-model="store.dateTo"
                        showIcon
                        inputId="date-to"
                        iconDisplay="input"
                        showButtonBar
                        :minDate="store.dateFrom"
                    />
                    <label for="date-to">Jusqu'au</label>
                </FloatLabel>
            </div>
        </div>
    </div>
</template>
