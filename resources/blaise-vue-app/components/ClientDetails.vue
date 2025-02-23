<script setup>
import { Button } from "primevue";
import EditClientDialog from "../dialogs/EditClientDialog.vue";
import dayjs from "dayjs";
import { ref } from "vue";
import { pick } from "../tools";
import Attributes from "./Attributes.vue";

const props = defineProps({
    client: Object,
    disableBtn: Boolean,
});

const emits = defineEmits(["save"]);

const edited = ref({});

const showEditDialog = ref(false);

function openEditDialog() {
    edited.value = pick(
        props.client,
        "first_name",
        "last_name",
        "gender",
        "tel_1",
        "tel_2",
        "tel_3",
        "npa",
        "location"
    );
    showEditDialog.value = true;
}

function save(data) {
    emits("save", data);
    showEditDialog.value = false;
}
</script>

<template>
    <div>
        <Attributes
            :attributes="[
                { label: 'Prénom', value: client.first_name },
                { label: 'Nom', value: client.last_name },
                {
                    label: 'Date de création',
                    value: dayjs(client.created_at).format('DD.MM.YYYY'),
                },
                {
                    label: 'Ville',
                    value: [client.npa, client.location].join(' '),
                },
                {
                    label: 'Téléphone',
                    value: [client.tel_1, client.tel_2, client.tel_3]
                        .filter((t) => t)
                        .join('<br>'),
                },
                { label: 'Genre', value: ['Femme', 'Homme'][client.gender] },
            ]"
        />
        <div class="flex justify-end">
            <Button
                @click="openEditDialog"
                :disabled="disableBtn"
                label="Modifier"
                icon="pi pi-pencil"
                size="small"
                variant="text"
                severity="secondary"
            ></Button>
        </div>
        <EditClientDialog
            :edited="edited"
            v-model:visible="showEditDialog"
            @save="save"
        />
    </div>
</template>
