<script setup>
import { Button, Card, DatePicker, FloatLabel } from "primevue";
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
            <form
                class="my-2 grid lg:grid-cols-3 grid-cols-2 gap-3"
                @submit.prevent="store.computeRevenue"
            >
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
                <Button
                    class="col-span-2 lg:col-auto"
                    label="Calculer"
                    type="submit"
                ></Button>
            </form>
            <div class="my-2 grid grid-cols-2 gap-3" v-if="store.result">
                <Card
                    pt:content:class="text-4xl text-center py-8 text-primary tabular-nums"
                >
                    <template #title>Nombre de visites</template>
                    <template #content>
                        {{ store.result.visits_count.toLocaleString() }}
                    </template>
                </Card>
                <Card
                    pt:content:class="text-4xl text-center py-8 text-primary tabular-nums"
                >
                    <template #title>Chiffre d'affaire</template>
                    <template #content>
                        CHF {{ store.result.total_billed.toLocaleString() }}
                    </template>
                </Card>
            </div>
        </div>
    </div>
</template>
