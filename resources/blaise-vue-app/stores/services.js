import { defineStore } from "pinia";
import { computed, ref, toRaw } from "vue";
import { del, get, post, put } from "../api";
import { pick } from "../tools";

export const useServicesStore = defineStore("services", () => {
    const categories = ref([]);
    const expandedRows = ref([]);
    const showCatEditDialog = ref(false);
    const showCatCreateDialog = ref(false);
    const showServiceEditDialog = ref(false);
    const showServiceCreateDialog = ref(false);
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

    async function updateCat(category) {
        const { data, response } = await put(
            `/api/admin/service-categories/${category.id}`,
            pick(category, "label", "sort_order")
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

    async function updateService(service) {
        const { data, response } = await put(
            `/api/admin/services/${service.id}`,
            pick(service, "label", "sort_order", "price", "service_category_id")
        );
        if (!response.ok) return;
        await fetch();
        showServiceEditDialog.value = false;
    }

    async function createService(service) {
        const { data, response } = await post(`/api/admin/services`, service);
        if (!response.ok) return;
        await fetch();
        showServiceCreateDialog.value = false;
    }

    async function deleteService(id) {
        const { data, response } = await del(`/api/admin/services/${id}`);
        if (!response.ok) return;
        await fetch();
    }

    const idsThatRequiresTechSheet = computed(() =>
        categories.value
            .filter((c) => c.options?.forceTechnicalSheet)
            .flatMap((c) => c.services)
            .map((s) => s.id)
    );

    return {
        categories,
        expandedRows,
        showCatEditDialog,
        showCatCreateDialog,
        showServiceCreateDialog,
        showServiceEditDialog,
        edited,
        fetch,
        openCatEditDialog,
        updateCat,
        createCat,
        deleteCategory,
        openServiceEditDialog,
        updateService,
        deleteService,
        createService,
        idsThatRequiresTechSheet,
    };
});
