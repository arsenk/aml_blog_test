import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import BlogDetail from "@/components/BlogDetail.vue";
import EditBlog from "@/components/EditBlog.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: HomeView,
  },
  {
    path: "/blog",
    name: "blog",
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/BlogListView.vue"),
  },
  {
    path: "/register",
    name: "register",
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/RegisterView.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/LoginView.vue"),
  },
  {
    path: "/createPost",
    name: "createPost",
    component: () =>
      import(/* webpackChunkName: "about" */ "../views/CreatePostView.vue"),
  },
  {
    path: "/blog/:id",
    name: "BlogDetail",
    component: BlogDetail,
  },
  {
    path: "/edit/:id",
    name: "editBlog",
    component: EditBlog,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
