<script setup>
import { Card, DatePicker, FloatLabel } from "primevue";
import { useAdminFinanceStore } from "../../stores/admin/finance";

const store = useAdminFinanceStore();
</script>

<template>
    <div class="px-2 py-4 sm:max-w-screen-md sm:mx-auto">
        <h2 class="text-3xl font-extralight mt-4">Comptabilité</h2>
        <div class="my-8">
            <h3 class="text-xl font-extralight my-4">
                Bilan financier par période
            </h3>
            <div class="grid grid-cols-2 gap-2 md:gap-4">
                <FloatLabel variant="on">
                    <DatePicker
                        v-model="store.dateFrom"
                        showIcon
                        inputId="date-from"
                        iconDisplay="input"
                        showButtonBar
                        :maxDate="store.dateTo"
                        fluid
                        dateFormat="dd.mm.yy"
                        pt:pcInputText:root:required
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
                        fluid
                        dateFormat="dd.mm.yy"
                        required
                        pt:pcInputText:root:required
                    />
                    <label for="date-to">Jusqu'au</label>
                </FloatLabel>
                <template v-if="store.result">
                    <Card
                        pt:content="text-4xl text-center py-8 text-primary font-mono"
                        pt:title="!text-base md:!text-xl"
                        pt:body="!p-3 md:!p-5"
                    >
                        <template #title>Nombre de visites</template>
                        <template #content>
                            {{ store.result.visits_count.toLocaleString() }}
                        </template>
                    </Card>
                    <Card
                        pt:content="text-4xl text-center py-8 text-primary font-mono"
                        pt:title="!text-base md:!text-xl"
                        pt:body="!p-3 md:!p-5"
                    >
                        <template #title>Chiffre d'affaire</template>
                        <template #content>
                            CHF {{ store.result.total_billed.toLocaleString() }}
                        </template>
                    </Card>
                </template>
            </div>
        </div>
    </div>
</template>
