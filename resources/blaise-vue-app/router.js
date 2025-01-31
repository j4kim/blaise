import { createWebHashHistory, createRouter } from "vue-router";

import Home from "./views/Home.vue";
import User from "./views/User.vue";
import Client from "./views/Client.vue";
import Login from "./views/Login.vue";

const routes = [
    { path: "/", component: Home, meta: { hideHeader: true } },
    { path: "/user", component: User },
    {
        path: "/login",
        component: Login,
        meta: { hideHeader: true, hideFooter: true },
    },
    { path: "/clients/:id", component: Client },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
