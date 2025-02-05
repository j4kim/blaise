<script setup>
import {
    onBeforeRouteLeave,
    onBeforeRouteUpdate,
    RouterView,
    useRoute,
} from "vue-router";
import LastVisits from "../components/LastVisits.vue";
import { Button } from "primevue";
import { useVisitStore } from "../stores/visit";
import dayjs from "dayjs";
import SaleDialog from "../dialogs/SaleDialog.vue";
import DiscountDialog from "../dialogs/DiscountDialog.vue";
import VoucherPaymentDialog from "../dialogs/VoucherPaymentDialog.vue";
import { useClientStore } from "../stores/client";
import EditClientDialog from "../dialogs/EditClientDialog.vue";

const route = useRoute();

const visit = useVisitStore();
const client = useClientStore();

await client.fetchClient(route.params.id);

onBeforeRouteUpdate((to, from) => {
    if (to.params.id !== from.params.id) {
        client.fetchClient(to.params.id);
    }
});

onBeforeRouteLeave(() => (visit.current = null));
</script>

<template v-if="client.selected">
    <div class="sm:max-w-screen-md sm:mx-auto px-2 py-4 h-full">
        <div class="mt-2 mb-8 flex justify-between items-end flex-wrap gap-3">
            <div>
                <h5 class="mb-1">{{ client.selected.title }}</h5>
                <h2 class="text-3xl font-extralight">
                    {{ client.selected.first_name }}
                    {{ client.selected.last_name }}
                </h2>
            </div>
            <Button
                v-if="!visit.current"
                label="Nouveau ticket"
                icon="pi pi-plus"
                @click="visit.create"
                variant="outlined"
            ></Button>
        </div>

        <div class="mb-8">
            <h5
                class="mb-2 inline-block cursor-pointer hover:text-color"
                @click="client.showDetails = !client.showDetails"
                :class="{
                    'text-muted-color': !client.showDetails,
                }"
            >
                <i
                    class="pi pi-angle-right transition"
                    :class="{ 'rotate-90': client.showDetails }"
                ></i>
                Coordonnées
            </h5>
            <div v-if="client.showDetails">
                <div class="grid lg:grid-cols-3 grid-cols-2 gap-4">
                    <dl>
                        <dt class="text-sm text-muted-color">Prénom</dt>
                        <dd>{{ client.selected.first_name }}</dd>
                    </dl>
                    <dl>
                        <dt class="text-sm text-muted-color">Nom</dt>
                        <dd>{{ client.selected.last_name }}</dd>
                    </dl>
                    <dl>
                        <dt class="text-sm text-muted-color">
                            Date de création
                        </dt>
                        <dd>
                            {{
                                dayjs(client.selected.created_at).format(
                                    "DD.MM.YYYY"
                                )
                            }}
                        </dd>
                    </dl>
                    <dl>
                        <dt class="text-sm text-muted-color">Ville</dt>
                        <dd>
                            {{ client.selected.npa }}
                            {{ client.selected.location }}
                        </dd>
                    </dl>
                    <dl>
                        <dt class="text-sm text-muted-color">Téléphone</dt>
                        <dd>{{ client.selected.tel_1 }}</dd>
                        <dd>{{ client.selected.tel_2 }}</dd>
                        <dd>{{ client.selected.tel_3 }}</dd>
                    </dl>
                </div>
                <div class="flex justify-end">
                    <Button
                        @click="client.openEditDialog"
                        label="Modifier"
                        icon="pi pi-pencil"
                        size="small"
                        variant="text"
                        severity="secondary"
                    ></Button>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h5
                class="mb-2 inline-block cursor-pointer hover:text-color"
                @click="client.showLastVisits = !client.showLastVisits"
                :class="{
                    'text-muted-color': !client.showLastVisits,
                }"
            >
                <i
                    class="pi pi-angle-right transition"
                    :class="{ 'rotate-90': client.showLastVisits }"
                ></i>
                Dernières visites
            </h5>
            <LastVisits
                v-if="client.showLastVisits"
                :visits="client.selected.last_visits"
            ></LastVisits>
        </div>
    </div>

    <RouterView class="mb-6 md:mb-8" v-if="visit.current" />

    <SaleDialog />
    <DiscountDialog />
    <VoucherPaymentDialog />
    <EditClientDialog />
</template>
