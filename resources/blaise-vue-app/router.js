import { createWebHashHistory, createRouter } from "vue-router";

import Home from "./views/Home.vue";
import Client from "./views/Client.vue";

const routes = [
    { path: "/", component: Home },
    { path: "/clients/:id", component: Client },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
