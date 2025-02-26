<script setup>
import { Button, Card, DatePicker, FloatLabel } from "primevue";
import { useAdminFinanceStore } from "../../stores/admin/finance";
import dayjs from "dayjs";
import quarterOfYear from "dayjs/plugin/quarterOfYear";

dayjs.extend(quarterOfYear);

const store = useAdminFinanceStore();

store.computeRevenue();

const today = dayjs().startOf("day");
const yesterday = today.subtract(1, "day");
const monday = today.startOf("week").add(1, "day");
const firstOfMonth = today.startOf("month");
const firstOfQuarter = today.startOf("quarter");
const firstOfYear = today.startOf("year");

const buttons = [
    {
        label: "Ajourd'hui",
        from: today,
        to: today,
    },
    {
        label: "Hier",
        from: yesterday,
        to: yesterday,
    },
    {
        label: "Cette semaine",
        from: monday,
        to: today.endOf("week").add(1, "day"),
    },
    {
        label: "Dernière semaine",
        from: monday.subtract(1, "week"),
        to: monday.subtract(1, "day"),
    },
    {
        label: "Ce mois",
        from: firstOfMonth,
        to: today.endOf("month"),
    },
    {
        label: "Dernier mois",
        from: firstOfMonth.subtract(1, "month"),
        to: firstOfMonth.subtract(1, "day"),
    },
    {
        label: "Ce trimestre",
        from: firstOfQuarter,
        to: today.endOf("quarter"),
    },
    {
        label: "Dernier trimestre",
        from: firstOfQuarter.subtract(1, "quarter"),
        to: firstOfQuarter.subtract(1, "day"),
    },
    {
        label: "Cette année",
        from: firstOfYear,
        to: today.endOf("year"),
    },
    {
        label: "Dernière année",
        from: firstOfYear.subtract(1, "year"),
        to: firstOfYear.subtract(1, "day"),
    },
    {
        label: "Ce siècle",
        from: dayjs("2000-01-01"),
        to: dayjs("2099-12-31"),
    },
];
</script>

<template>
    <div class="px-2 py-4 sm:max-w-screen-md sm:mx-auto">
        <h2 class="text-3xl font-extralight mt-4">Comptabilité</h2>
        <div class="my-8">
            <h3 class="text-xl font-extralight my-4">
                Bilan financier par période
            </h3>
            <div class="flex flex-wrap gap-2 mb-6">
                <Button
                    v-for="b in buttons"
                    @click="
                        store.dateFrom = b.from.toDate();
                        store.dateTo = b.to.toDate();
                    "
                    :label="b.label"
                    rounded
                    :severity="
                        store.dateFrom.getTime() == b.from.toDate().getTime() &&
                        store.dateTo.getTime() == b.to.toDate().getTime()
                            ? 'primary'
                            : 'secondary'
                    "
                ></Button>
            </div>
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
                            <i
                                v-if="store.loading"
                                class="pi pi-spin pi-spinner"
                                style="font-size: 2rem"
                            ></i>
                            <span v-else>
                                {{ store.result.visits_count.toLocaleString() }}
                            </span>
                        </template>
                    </Card>
                    <Card
                        pt:content="text-4xl text-center py-8 text-primary font-mono"
                        pt:title="!text-base md:!text-xl"
                        pt:body="!p-3 md:!p-5"
                    >
                        <template #title>Chiffre d'affaire</template>
                        <template #content>
                            <i
                                v-if="store.loading"
                                class="pi pi-spin pi-spinner"
                                style="font-size: 2rem"
                            ></i>
                            <span v-else>
                                CHF
                                {{ store.result.total_billed.toLocaleString() }}
                            </span>
                        </template>
                    </Card>
                </template>
            </div>
        </div>
    </div>
</template>
