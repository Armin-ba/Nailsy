import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "../stores/auth";

/*
LAYOUTS
*/

import PublicLayout from "../layout/PublicLayout.vue";
import AuthLayout from "../layout/AuthLayout.vue";
import AppLayout from "../layout/AppLayout.vue";

/*
PUBLIC VIEWS
*/

import HomeView from "../views/public/HomeView.vue";
import NailArtistPublicListView from "../views/public/NailArtistPublicListView.vue";
import NailArtistPublicDetailsView from "../views/public/NailArtistPublicDetailsView.vue";
import ContactView from "@/views/public/ContactView.vue";
import SearchView from "../views/public/SearchView.vue";

/*
AUTH VIEWS
*/

import LoginView from "../views/auth/LoginView.vue";
import RegisterView from "../views/auth/RegisterView.vue";

/*
USER VIEWS
*/

import NailArtistListView from "../views/app/user/NailArtistListView.vue";
import NailArtistDetailsView from "../views/app/user/NailArtistDetailsView.vue";
import BookingView from "../views/app/user/BookingView.vue";
import MyBookingsView from "../views/app/user/MyBookingsView.vue";

/*
ARTIST VIEWS
*/

import ArtistDashboardView from "../views/app/artist/ArtistDashboardView.vue";
import ServicesView from "../views/app/artist/ServicesView.vue";
import ScheduleView from "../views/app/artist/ScheduleView.vue";

/*
ADMIN VIEWS
*/

import AdminUserView from "../views/app/admin/AdminUserView.vue";
import AdminArtistView from "../views/app/admin/AdminArtistView.vue";
import AdminReviewModerationView from "../views/app/admin/AdminReviewModerationView.vue";

/*
ERROR VIEWS
*/

import NotAuthorizedView from "../views/errors/NotAuthorizedView.vue";
import NotFoundView from "../views/errors/NotFoundView.vue";

/*
ROUTES
*/

const routes = [
    /*
    PUBLIC
    */

    {
        path: "/",
        component: PublicLayout,
        children: [
            {
                path: "",
                name: "home",
                component: HomeView,
            },
            {
                path: "artists",
                name: "artists-public",
                component: NailArtistPublicListView,
            },
            {
                path: "artists/:id",
                name: "artist-public-details",
                component: NailArtistPublicDetailsView,
            },
            {
                path: "contact",
                name: "contact",
                component: ContactView,
            },
            {
                path: "search",
                name: "search",
                component: SearchView,
            },
        ],
    },

    /*
    AUTH
    */

    {
        path: "/auth",
        component: AuthLayout,
        children: [
            {
                path: "login",
                name: "login",
                component: LoginView,
            },
            {
                path: "register",
                name: "register",
                component: RegisterView,
            },
        ],
    },

    /*
    APP (PROTECTED)
    */

    {
        path: "/app",
        component: AppLayout,
        meta: { requiresAuth: true },
        children: [
            /*
            USER
            */

            {
                path: "artists",
                name: "artists",
                component: NailArtistListView,
                meta: { role: "user" },
            },

            {
                path: "artists/:id",
                name: "artist-details",
                component: NailArtistDetailsView,
                meta: { role: "user" },
            },

            {
                path: "booking/:artistId",
                name: "booking",
                component: BookingView,
                meta: { role: "user" },
            },

            {
                path: "my-bookings",
                name: "my-bookings",
                component: MyBookingsView,
                meta: { role: "user" },
            },

            /*
            ARTIST
            */

            {
                path: "artist/dashboard",
                name: "artist-dashboard",
                component: ArtistDashboardView,
                meta: { role: "artist" },
            },

            {
                path: "artist/services",
                name: "artist-services",
                component: ServicesView,
                meta: { role: "artist" },
            },

            {
                path: "artist/schedule",
                name: "artist-schedule",
                component: ScheduleView,
                meta: { role: "artist" },
            },

            /*
            ADMIN
            */

            {
                path: "admin/users",
                name: "admin-users",
                component: AdminUserView,
                meta: { role: "admin" },
            },

            {
                path: "admin/artists",
                name: "admin-artists",
                component: AdminArtistView,
                meta: { role: "admin" },
            },

            {
                path: "admin/reviews",
                name: "admin-reviews",
                component: AdminReviewModerationView,
                meta: { role: "admin" },
            },
        ],
    },

    /*
    ERRORS
    */

    {
        path: "/not-authorized",
        name: "not-authorized",
        component: NotAuthorizedView,
    },

    {
        path: "/:pathMatch(.*)*",
        name: "not-found",
        component: NotFoundView,
    },
];

/*
ROUTER
*/

const router = createRouter({
    history: createWebHistory(),
    routes,
});

/*
GLOBAL ROUTE GUARD
*/

router.beforeEach((to) => {
    const auth = useAuthStore();

    if (to.meta.requiresAuth && !auth.token) {
        return {
            path: "/auth/login",
            query: { redirect: to.fullPath },
        };
    }

    if (to.meta.role) {
        if (!auth.user || auth.user.role !== to.meta.role) {
            return "/not-authorized";
        }
    }

    return true;
});

export default router;