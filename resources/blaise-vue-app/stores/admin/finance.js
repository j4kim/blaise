import { defineStore } from "pinia";
import { ref, watch } from "vue";
import { get } from "../../api";
import dayjs from "dayjs";

export const useAdminFinanceStore = defineStore("admin-finance", () => {
    const dateFrom = ref(dayjs().startOf("day").toDate());
    const dateTo = ref(dayjs().startOf("day").toDate());
    const result = ref(null);
    const loading = ref(false);
    const column = ref("billed");

    async function computeRevenue() {
        loading.value = true;
        const { response, data } = await get(
            "api/admin/finance/compute-revenue",
            {
                from: dayjs(dateFrom.value).format("YYYY-MM-DD"),
                to: dayjs(dateTo.value).format("YYYY-MM-DD"),
                column: column.value,
            }
        );
        loading.value = false;
        if (!response.ok) return;
        result.value = data;
    }

    watch([dateFrom, dateTo, column], computeRevenue);

    return { dateFrom, dateTo, result, loading, column, computeRevenue };
});
