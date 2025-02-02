import "./css/app.css";
import "primeicons/primeicons.css";
import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";
import router from "./router";
import { get } from "./api";

const pinia = createPinia();

const app = createApp(App);

app.use(PrimeVue, {
    theme: {
        preset: Aura,
    },
});

app.use(router);

app.use(pinia);

app.mount("#app");

if (!document.body.dataset.user) {
    router.push("/login");
}
