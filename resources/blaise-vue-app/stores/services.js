import { defineStore } from "pinia";
import { ref } from "vue";
import { get } from "../api";

export const useServicesStore = defineStore("services", () => {
    const categories = ref([]);

    async function fetch() {
        const { data, response } = await get("/api/services");
        if (!response.ok) return;
        categories.value = data;
    }

    return { categories, fetch };
});
