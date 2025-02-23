import { defineStore } from "pinia";
import { reactive, ref, watch } from "vue";
import { get, post } from "../../api";
import { useRouter } from "vue-router";
import { watchDebounced } from "@vueuse/core";

export const useAdminClientsStore = defineStore("admin-clients", () => {
    const paginator = ref({});
    const loading = ref(false);
    const search = ref("");
    const showAddDialog = ref(false);

    const queryParams = reactive({
        page: 1,
        search: "",
        filter: "active",
        sortField: "updated_at",
        sortOrder: "desc",
    });

    const router = useRouter();

    async function fetchClients() {
        loading.value = true;
        const { data, response } = await get("/api/admin/clients", queryParams);
        loading.value = false;
        if (!response.ok) return;
        paginator.value = data;
    }

    async function create(client) {
        const { data, response } = await post("/api/admin/clients", client);
        if (!response.ok) return;
        showAddDialog.value = false;
        router.push(`/admin/clients/${data.id}`);
    }

    function sort(e) {
        queryParams.sortField = e.sortField;
        queryParams.sortOrder = e.sortOrder === 1 ? "asc" : "desc";
        queryParams.page = 1;
    }

    watch(queryParams, fetchClients);

    watchDebounced(search, (v) => (queryParams.search = v), {
        debounce: 500,
    });

    return {
        paginator,
        loading,
        search,
        showAddDialog,
        queryParams,
        fetchClients,
        create,
        sort,
    };
});
