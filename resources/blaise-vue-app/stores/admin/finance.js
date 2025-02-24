import { defineStore } from "pinia";
import { ref } from "vue";

export const useAdminFinanceStore = defineStore("admin-finance", () => {
    const dateFrom = ref(null);
    const dateTo = ref(null);

    return { dateFrom, dateTo };
});
