import { defineStore } from "pinia";
import { ref, toRaw } from "vue";
import { del, get, put } from "../api";
import { pick } from "../tools";
import { useConfirm } from "primevue";

export const useServicesStore = defineStore("services", () => {
    const confirm = useConfirm();
    const categories = ref([]);
    const expandedRows = ref([]);
    const showCatEditDialog = ref(false);
    const showServiceEditDialog = ref(false);
    const edited = ref({});

    async function fetch() {
        const { data, response } = await get("/api/services");
        if (!response.ok) return;
        categories.value = data;
    }

    function openCatEditDialog(category) {
        edited.value = structuredClone(toRaw(category));
        showCatEditDialog.value = true;
    }

    async function updateCat() {
        const id = edited.value.id;
        const { data, response } = await put(
            `/api/admin/service-categories/${id}`,
            pick(edited.value, "label", "sort_order")
        );
        if (!response.ok) return;
        await fetch();
        showCatEditDialog.value = false;
    }

    async function deleteCategory(id) {
        const { data, response } = await del(
            `/api/admin/service-categories/${id}`
        );
        if (!response.ok) return;
        const index = categories.value.findIndex((c) => c.id === id);
        categories.value.splice(index, 1);
    }

    function confirmCatDelete(category) {
        confirm.require({
            message: `Voulez-vous vraiment supprimer la catégorie ${category.label} ? Cette catégorie contient ${category.services.length} services.`,
            header: "Suppression",
            icon: "pi pi-info-circle",
            rejectProps: {
                label: "Annuler",
                severity: "secondary",
            },
            acceptProps: {
                label: "Oui, supprimer",
                severity: "danger",
            },
            accept: () => deleteCategory(category.id),
        });
    }

    function openServiceEditDialog(service) {
        edited.value = structuredClone(toRaw(service));
        showServiceEditDialog.value = true;
    }

    async function updateService() {
        const id = edited.value.id;
        const { data, response } = await put(
            `/api/admin/services/${id}`,
            pick(edited.value, "label", "sort_order", "price")
        );
        if (!response.ok) return;
        await fetch();
        showServiceEditDialog.value = false;
    }

    async function deleteService(id) {
        const { data, response } = await del(`/api/admin/services/${id}`);
        if (!response.ok) return;
        await fetch();
    }

    function confirmServiceDelete(service) {
        confirm.require({
            message: `Voulez-vous vraiment supprimer le service ${service.label} ?`,
            header: "Suppression",
            icon: "pi pi-info-circle",
            rejectProps: {
                label: "Annuler",
                severity: "secondary",
            },
            acceptProps: {
                label: "Oui, supprimer",
                severity: "danger",
            },
            accept: () => deleteService(service.id),
        });
    }

    return {
        categories,
        expandedRows,
        fetch,
        showCatEditDialog,
        openCatEditDialog,
        edited,
        updateCat,
        confirmCatDelete,
        showServiceEditDialog,
        openServiceEditDialog,
        updateService,
        confirmServiceDelete,
    };
});
