import { defineStore } from "pinia";
import { ref } from "vue";
import { get } from "../../api";
import dayjs from "dayjs";

export const useAdminFinanceStore = defineStore("admin-finance", () => {
    const dateFrom = ref(new Date());
    const dateTo = ref(new Date());
    const result = ref(null);

    async function computeRevenue() {
        const { response, data } = await get(
            "api/admin/finance/compute-revenue",
            {
                from: dayjs(dateFrom.value).format("YYYY-MM-DD"),
                to: dayjs(dateTo.value).format("YYYY-MM-DD"),
            }
        );
        if (!response.ok) return;
        result.value = data;
    }

    return { dateFrom, dateTo, result, computeRevenue };
});
