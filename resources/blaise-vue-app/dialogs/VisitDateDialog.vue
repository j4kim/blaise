<script setup>
import { Button, DatePicker, Dialog } from "primevue";
import { useVisitStore } from "../stores/visit";
import dayjs from "dayjs";
import { ref } from "vue";

const visit = useVisitStore();

const newValue = ref(dayjs(visit.current.visit_date).toDate());
</script>

<template>
    <Dialog
        v-model:visible="visit.showDateDialog"
        modal
        dismissableMask
        header="Date de la visite"
        class="max-w-full w-96"
    >
        <div class="flex flex-col gap-6">
            <DatePicker
                v-model="newValue"
                showWeek
                inline
                class="w-full"
                showTime
                :stepMinute="5"
            />
            <div class="flex justify-end">
                <Button
                    type="button"
                    label="Valider"
                    @click="visit.updateVisitDate(dayjs(newValue).format())"
                ></Button>
            </div>
        </div>
    </Dialog>
</template>
