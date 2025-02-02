import { createWebHashHistory, createRouter } from "vue-router";

import Home from "./views/Home.vue";
import Admin from "./views/Admin.vue";
import Client from "./views/Client.vue";
import Login from "./views/Login.vue";
import Saleables from "./views/Saleables.vue";
import AddService from "./views/AddService.vue";
import AddArticle from "./views/AddArticle.vue";

const routes = [
    { path: "/", component: Home, meta: { hideHeader: true } },
    {
        path: "/login",
        component: Login,
        meta: { hideHeader: true, hideFooter: true },
    },
    { path: "/admin", component: Admin, meta: { hideFooter: true } },
    {
        path: "/clients/:id",
        component: Client,
        children: [
            {
                path: "",
                component: Saleables,
            },
            {
                path: "services/:catId",
                component: AddService,
            },
            {
                path: "articles/",
                component: AddArticle,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
