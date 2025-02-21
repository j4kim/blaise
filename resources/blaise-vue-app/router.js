import { createWebHashHistory, createRouter } from "vue-router";

import Home from "./views/Home.vue";
import Client from "./views/Client.vue";
import Login from "./views/Login.vue";
import Saleables from "./views/Saleables.vue";
import AddService from "./views/AddService.vue";
import AddArticle from "./views/AddArticle.vue";
import Profile from "./views/admin/Profile.vue";
import Clients from "./views/admin/Clients.vue";
import Services from "./views/admin/Services.vue";
import Articles from "./views/admin/Articles.vue";
import Compta from "./views/admin/Compta.vue";

const routes = [
    { path: "/", component: Home, meta: { hideHeader: true } },
    {
        path: "/login",
        component: Login,
        meta: { hideHeader: true, hideFooter: true },
    },
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
    {
        path: "/admin",
        meta: { hideFooter: true },
        redirect: "/admin/profile",
        children: [
            {
                path: "profile",
                component: Profile,
            },
            {
                path: "clients",
                component: Clients,
            },
            {
                path: "services",
                component: Services,
            },
            {
                path: "articles",
                component: Articles,
            },
            {
                path: "compta",
                component: Compta,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
