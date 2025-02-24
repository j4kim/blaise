import { defineStore } from "pinia";
import { ref, toRaw } from "vue";
import { del, get, put } from "../api";
import { pick } from "../tools";
import { useConfirm } from "primevue";

export const useServicesStore = defineStore("services", () => {
    const categories = ref([]);

    async function fetch() {
        const { data, response } = await get("/api/services");
        if (!response.ok) return;
        categories.value = data;
    }

    const showCatEditDialog = ref(false);
    const editedCat = ref({});

    function openCatEditDialog(service) {
        editedCat.value = structuredClone(toRaw(service));
        showCatEditDialog.value = true;
    }

    async function updateCat() {
        const id = editedCat.value.id;
        const { data, response } = await put(
            `/api/admin/service-categories/${id}`,
            pick(editedCat.value, "label", "sort_order")
        );
        if (!response.ok) return;
        const index = categories.value.findIndex((c) => c.id === id);
        categories.value.splice(index, 1, data);
        showCatEditDialog.value = false;
    }

    const confirm = useConfirm();

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
            message: `Voulez-vous vraiment supprimer la catégorie ${category.label} ?`,
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

    return {
        categories,
        fetch,
        showCatEditDialog,
        openCatEditDialog,
        editedCat,
        updateCat,
        confirmCatDelete,
    };
});
