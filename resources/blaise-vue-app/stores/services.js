import { defineStore } from "pinia";
import { ref, toRaw } from "vue";
import { del, get, post, put } from "../api";
import { pick } from "../tools";

export const useServicesStore = defineStore("services", () => {
    const categories = ref([]);
    const expandedRows = ref([]);
    const showCatEditDialog = ref(false);
    const showCatCreateDialog = ref(false);
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

    async function createCat(category) {
        const { data, response } = await post(
            `/api/admin/service-categories`,
            category
        );
        if (!response.ok) return;
        await fetch();
        showCatCreateDialog.value = false;
    }

    async function deleteCategory(id) {
        const { data, response } = await del(
            `/api/admin/service-categories/${id}`
        );
        if (!response.ok) return;
        const index = categories.value.findIndex((c) => c.id === id);
        categories.value.splice(index, 1);
    }

    function openServiceEditDialog(service) {
        edited.value = structuredClone(toRaw(service));
        showServiceEditDialog.value = true;
    }

    async function updateService() {
        const id = edited.value.id;
        const { data, response } = await put(
            `/api/admin/services/${id}`,
            pick(
                edited.value,
                "label",
                "sort_order",
                "price",
                "service_category_id"
            )
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

    return {
        categories,
        expandedRows,
        fetch,
        showCatEditDialog,
        showCatCreateDialog,
        openCatEditDialog,
        edited,
        updateCat,
        createCat,
        deleteCategory,
        showServiceEditDialog,
        openServiceEditDialog,
        updateService,
        deleteService,
    };
});
