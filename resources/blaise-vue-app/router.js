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
import ClientData from "./views/admin/ClientData.vue";
import ClientVisits from "./views/admin/ClientVisits.vue";
import ClientVisitDetails from "./views/admin/ClientVisitDetails.vue";

function adminHook(to) {
    localStorage["last-admin-path"] = to.path;
}

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
        redirect: () => localStorage["last-admin-path"] ?? "/admin/profile",
        children: [
            {
                path: "profile",
                component: Profile,
                beforeEnter: adminHook,
            },
            {
                path: "clients",
                beforeEnter() {
                    localStorage["last-admin-path"] = "/admin/clients";
                },
                children: [
                    {
                        path: "",
                        component: Clients,
                    },
                    {
                        path: ":clientId",
                        component: ClientData,
                        children: [
                            {
                                path: "",
                                component: ClientVisits,
                            },
                            {
                                path: "visit/:visitId",
                                component: ClientVisitDetails,
                            },
                        ],
                    },
                ],
            },
            {
                path: "services",
                component: Services,
                beforeEnter: adminHook,
            },
            {
                path: "articles",
                component: Articles,
                beforeEnter: adminHook,
            },
            {
                path: "compta",
                component: Compta,
                beforeEnter: adminHook,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;
