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
import Finance from "./views/admin/Finance.vue";
import ClientData from "./views/admin/ClientData.vue";
import ClientVisits from "./views/admin/ClientVisits.vue";
import ClientVisitDetails from "./views/admin/ClientVisitDetails.vue";
import ArticleArticles from "./views/admin/ArticleArticles.vue";
import ArticleBrands from "./views/admin/ArticleBrands.vue";
import ArticleLines from "./views/admin/ArticleLines.vue";
import AdminClient from "./views/admin/Client.vue";

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
        meta: {
            adminRoute(route) {
                return `/admin/clients/${route.params.id}`;
            },
        },
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
                        component: AdminClient,
                        children: [
                            {
                                path: "",
                                meta: { tabRoute: "clientData" },
                                component: ClientData,
                            },
                            {
                                path: "visits",
                                meta: { tabRoute: "clientVisits" },
                                children: [
                                    {
                                        path: "",
                                        component: ClientVisits,
                                    },
                                    {
                                        path: ":visitId",
                                        component: ClientVisitDetails,
                                    },
                                ],
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
                children: [
                    {
                        path: "",
                        component: ArticleArticles,
                    },
                    {
                        path: "brands",
                        component: ArticleBrands,
                    },
                    {
                        path: "lines",
                        component: ArticleLines,
                    },
                ],
            },
            {
                path: "finance",
                component: Finance,
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
