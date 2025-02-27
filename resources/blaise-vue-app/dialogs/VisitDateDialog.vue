<script setup>
import { Button, DatePicker, Dialog } from "primevue";
import dayjs from "dayjs";
import { ref } from "vue";

const props = defineProps({
    value: String,
});

const newValue = ref(dayjs(props.value).toDate());
</script>

<template>
    <Dialog
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
                    @click="$emit('save', dayjs(newValue).format())"
                ></Button>
            </div>
        </div>
    </Dialog>
</template>
