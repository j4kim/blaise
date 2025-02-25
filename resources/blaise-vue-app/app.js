import "./css/app.css";
import "primeicons/primeicons.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import PrimeVue from "primevue/config";
import ConfirmationService from "primevue/confirmationservice";
import primelocale from "primelocale/fr.json";
import theme from "./theme";
import router from "./router";
import { useArticlesStore } from "./stores/articles";
import { useServicesStore } from "./stores/services";

const pinia = createPinia();

const app = createApp(App);

app.use(PrimeVue, { theme, locale: primelocale.fr });
app.use(ConfirmationService);

app.use(router);

app.use(pinia);

app.mount("#app");

if (document.body.dataset.user) {
    useArticlesStore().fetch();
    useServicesStore().fetch();
} else {
    router.push("/login");
}
