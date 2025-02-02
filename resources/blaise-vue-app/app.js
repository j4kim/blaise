import "./css/app.css";
import "primeicons/primeicons.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import PrimeVue from "primevue/config";
import router from "./router";
import theme from "./theme";

const pinia = createPinia();

const app = createApp(App);

app.use(PrimeVue, { theme });

app.use(router);

app.use(pinia);

app.mount("#app");

if (!document.body.dataset.user) {
    router.push("/login");
}
