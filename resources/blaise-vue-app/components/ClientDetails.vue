<script setup>
import { formatDate } from "../tools";
import Attributes from "./Attributes.vue";

const props = defineProps({
    client: Object,
});
</script>

<template>
    <Attributes
        :attributes="[
            { label: 'Prénom', value: client.first_name },
            { label: 'Nom', value: client.last_name },
            {
                label: 'Date de création',
                value: formatDate(client.created_at),
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
</template>
