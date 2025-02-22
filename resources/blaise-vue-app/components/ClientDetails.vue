<script setup>
import { Button } from "primevue";
import EditClientDialog from "../dialogs/EditClientDialog.vue";
import dayjs from "dayjs";
import { ref } from "vue";
import { pick } from "../tools";

const props = defineProps({
    client: Object,
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
        <div class="grid lg:grid-cols-3 grid-cols-2 gap-4">
            <dl>
                <dt class="text-sm text-muted-color">Prénom</dt>
                <dd>{{ client.first_name }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Nom</dt>
                <dd>{{ client.last_name }}</dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Date de création</dt>
                <dd>
                    {{ dayjs(client.created_at).format("DD.MM.YYYY") }}
                </dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Ville</dt>
                <dd>
                    {{ client.npa }}
                    {{ client.location }}
                </dd>
            </dl>
            <dl>
                <dt class="text-sm text-muted-color">Téléphone</dt>
                <dd>{{ client.tel_1 }}</dd>
                <dd>{{ client.tel_2 }}</dd>
                <dd>{{ client.tel_3 }}</dd>
            </dl>
        </div>
        <div class="flex justify-end">
            <Button
                @click="openEditDialog"
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
