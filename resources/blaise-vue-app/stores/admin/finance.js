import { defineStore } from "pinia";
import { ref, watch } from "vue";
import { get } from "../../api";
import dayjs from "dayjs";

export const useAdminFinanceStore = defineStore("admin-finance", () => {
    const dateFrom = ref(new Date());
    const dateTo = ref(new Date());
    const result = ref(null);
    const loading = ref(false);

    async function computeRevenue() {
        loading.value = true;
        const { response, data } = await get(
            "api/admin/finance/compute-revenue",
            {
                from: dayjs(dateFrom.value).format("YYYY-MM-DD"),
                to: dayjs(dateTo.value).format("YYYY-MM-DD"),
            }
        );
        loading.value = false;
        if (!response.ok) return;
        result.value = data;
    }

    watch([dateFrom, dateTo], computeRevenue, { immediate: true });

    return { dateFrom, dateTo, result, loading };
});
