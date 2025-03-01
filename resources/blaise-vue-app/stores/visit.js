import { defineStore } from "pinia";
import { del, post, put } from "../api";
import { toRaw } from "vue";
import { useClientStore } from "./client";
import { useArticlesStore } from "./articles";
import { useServicesStore } from "./services";
import { pick } from "../tools";

export const useVisitStore = defineStore("visit", {
    state: () => ({
        current: null,
        showSaleDialog: false,
        selectedSale: null,
        showDiscountDialog: false,
        showDateDialog: false,
        showPaymentDialog: false,
    }),

    actions: {
        async create() {
            const client = useClientStore();
            const { data, response } = await post(
                `/api/visits/${client.selected.id}`
            );
            if (!response.ok) return;
            this.current = data;
            client.hidePanels();
        },
        async replicate(clientId, visitId) {
            const { data, response } = await post(
                `/api/visits/replicate/${clientId}/${visitId}`
            );
            if (!response.ok) return;
            this.current = data;
            useClientStore().hidePanels();
        },
        async validateCurrent() {
            const { response } = await post(
                `/api/visits/${this.current.id}/validate`,
                pick(
                    this.current,
                    "rounding",
                    "tip",
                    "cash",
                    "twint",
                    "card",
                    "voucher_payment",
                    "client_email",
                    "send_by_email",
                    "email_changed"
                )
            );
            if (!response.ok) return;
            this.showPaymentDialog = false;
            const client = useClientStore();
            await client.fetchClient(client.selected.id);
            useArticlesStore().fetch();
            useServicesStore().fetch();
        },
        async deleteCurrent() {
            const { response } = await del(`/api/visits/${this.current.id}`);
            if (!response.ok) return;
            this.current = null;
            useClientStore().resetPanels();
        },
        async addService(service) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/services/${service.id}`
            );
            if (!response.ok) return;
            this.current = data;
        },
        async addArticle(article) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/article/${article.id}`
            );
            if (!response.ok) return;
            this.current = data;
        },
        async addSale({ type, label }) {
            const { response, data } = await post(
                `/api/visits/${this.current.id}/sale`,
                { type, label, price_charged: 50 }
            );
            if (!response.ok) return;
            this.current = data.visit;
            this.openSaleDialog(data.sale);
        },
        openSaleDialog(sale) {
            this.selectedSale = structuredClone(toRaw(sale));
            this.showSaleDialog = true;
        },
        async saveSelectedSale() {
            const { response, data } = await put(
                `/api/visits/${this.current.id}/sale/${this.selectedSale.id}`,
                this.selectedSale
            );
            if (!response.ok) return;
            this.current = data;
            this.showSaleDialog = false;
        },
        async deleteSelectedSale() {
            const { response, data } = await del(
                `/api/visits/${this.current.id}/sale/${this.selectedSale.id}`
            );
            if (!response.ok) return;
            this.current = data;
            this.showSaleDialog = false;
        },
        async updateCurrent() {
            const { response, data } = await put(
                `/api/visits/${this.current.id}`,
                this.current
            );
            if (!response.ok) return;
            this.current = data;
            this.showDiscountDialog = false;
        },
        async updateVisitDate(visitDate) {
            this.current.visit_date = visitDate;
            await this.updateCurrent();
            this.showDateDialog = false;
        },
        async addDiscount(percent, filter) {
            const { response, data } = await put(
                `/api/visits/${this.current.id}/discount`,
                { percent, filter }
            );
            if (!response.ok) return;
            this.current = data;
            this.showDiscountDialog = false;
        },
    },
});
