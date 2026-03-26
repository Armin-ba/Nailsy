import { createRouter, createWebHistory } from "vue-router"

// layouts
import PublicLayout from "../layout/PublicLayout.vue"
import AuthLayout from "../layout/AuthLayout.vue"
import AppLayout from "../layout/AppLayout.vue"

// public
import HomeView from "../views/public/HomeView.vue"
import NailArtistPublicListView from "../views/public/NailArtistPublicListView.vue"
import NailArtistPublicDetailsView from "../views/public/NailArtistPublicDetailsView.vue"

// auth
import LoginView from "../views/auth/LoginView.vue"
import RegisterView from "../views/auth/RegisterView.vue"

// user
import NailArtistListView from "../views/app/user/NailArtistListView.vue"
import NailArtistDetailsView from "../views/app/user/NailArtistDetailsView.vue"
import BookingView from "../views/app/user/BookingView.vue"
import MyBookingsView from "../views/app/user/MyBookingsView.vue"

// artist
import ArtistDashboardView from "../views/app/artist/ArtistDashboardView.vue"
import ServicesView from "../views/app/artist/ServicesView.vue"
import ScheduleView from "../views/app/artist/ScheduleView.vue"

// admin
import AdminUserView from "../views/app/admin/AdminUserView.vue"
import AdminArtistView from "../views/app/admin/AdminArtistView.vue"
import AdminReviewModerationView from "../views/app/admin/AdminReviewModerationView.vue"

// errors
import NotAuthorizedView from "../views/errors/NotAuthorizedView.vue"
import NotFoundView from "../views/errors/NotFoundView.vue"

const routes = [

  // PUBLIC
  {
    path: "/",
    component: PublicLayout,
    children: [
      {
        path: "",
        name: "home",
        component: HomeView
      },
      {
        path: "artists",
        name: "artists-public",
        component: NailArtistPublicListView
      },
      {
        path: "artists/:id",
        name: "artist-public-details",
        component: NailArtistPublicDetailsView
      }
    ]
  },

  // AUTH
  {
    path: "/auth",
    component: AuthLayout,
    children: [
      {
        path: "login",
        name: "login",
        component: LoginView
      },
      {
        path: "register",
        name: "register",
        component: RegisterView
      }
    ]
  },

  // APP
  {
    path: "/app",
    component: AppLayout,
    children: [

      // USER
      {
        path: "artists",
        name: "artists",
        component: NailArtistListView
      },
      {
        path: "artists/:id",
        name: "artist-details",
        component: NailArtistDetailsView
      },
      {
        path: "booking/:artistId",
        name: "booking",
        component: BookingView
      },
      {
        path: "my-bookings",
        name: "my-bookings",
        component: MyBookingsView
      },

      // NAIL ARTIST
      {
        path: "artist/dashboard",
        name: "artist-dashboard",
        component: ArtistDashboardView
      },
      {
        path: "artist/services",
        name: "artist-services",
        component: ServicesView
      },
      {
        path: "artist/schedule",
        name: "artist-schedule",
        component: ScheduleView
      },

      // ADMIN
      {
        path: "admin/users",
        name: "admin-users",
        component: AdminUserView
      },
      {
        path: "admin/artists",
        name: "admin-artists",
        component: AdminArtistView
      },
      {
        path: "admin/reviews",
        name: "admin-reviews",
        component: AdminReviewModerationView
      }
    ]
  },

  {
    path: "/not-authorized",
    component: NotAuthorizedView
  },

  {
    path: "/:pathMatch(.*)*",
    component: NotFoundView
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
