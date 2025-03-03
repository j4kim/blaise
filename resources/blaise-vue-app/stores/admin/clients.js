import { defineStore } from "pinia";
import { reactive, ref, watch } from "vue";
import { del, get, post, put } from "../../api";
import { useRouter } from "vue-router";
import { watchDebounced } from "@vueuse/core";

export const useAdminClientsStore = defineStore("admin-clients", () => {
    const paginator = ref({});
    const loading = ref(false);
    const search = ref("");
    const showAddDialog = ref(false);
    const showEditDialog = ref(false);

    const queryParams = reactive({
        page: 1,
        search: "",
        filter: "active",
        sortField: "updated_at",
        sortOrder: "desc",
    });

    const client = ref(null);
    const visits = ref([]);
    const visit = ref(null);
    const sheets = ref([]);

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

    async function fetchClient(id) {
        const { data, response } = await get(`/api/admin/clients/${id}`);
        if (!response.ok) return;
        client.value = data;
    }

    async function save(edited) {
        const id = client.value.id;
        const { data, response } = await put(`/api/clients/${id}`, edited);
        if (!response.ok) return;
        client.value = data;
        showEditDialog.value = false;
    }

    async function deleteClient() {
        const id = client.value.id;
        const { data, response } = await del(`/api/admin/clients/${id}`);
        if (!response.ok) return;
        client.value = data;
    }

    async function fetchVisits() {
        const id = client.value.id;
        const { data, response } = await get(`/api/admin/clients/${id}/visits`);
        if (!response.ok) return;
        visits.value = data;
    }

    async function fetchVisit(id) {
        const { data, response } = await get(`/api/admin/visits/${id}`);
        if (!response.ok) return;
        visit.value = data;
    }

    async function fetchSheets(id) {
        const { data, response } = await get(`/api/admin/clients/${id}/sheets`);
        if (!response.ok) return;
        sheets.value = data;
    }

    return {
        paginator,
        loading,
        search,
        showAddDialog,
        showEditDialog,
        queryParams,
        client,
        visits,
        visit,
        sheets,
        fetchClients,
        fetchClient,
        create,
        sort,
        save,
        deleteClient,
        fetchVisits,
        fetchVisit,
        fetchSheets,
    };
});
