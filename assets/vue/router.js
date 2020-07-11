import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../vue/store";
import Index from './pages/Index.vue';
import Documents from './pages/Documents.vue';
import Partners from './pages/Partners.vue';
import Posts from './pages/Posts.vue';
import PostDetails from './pages/PostDetails.vue';
import Dashboard from './pages/Dashboard.vue';
import DashboardCreationPost from './pages/DashboardCreationPost.vue';
import DashboardCreationDocument from './pages/DashboardCreationDocument.vue';
import DashboardCreationPartner from './pages/DashboardCreationPartner.vue';
import DashboardEditPosts from './pages/DashboardEditPosts.vue';
import DashboardEditDocuments from './pages/DashboardEditDocuments.vue';
import DashboardEditPartners from './pages/DashboardEditPartners.vue';
import Login from './pages/Login.vue';
import MainNavbar from './layout/MainNavbar.vue';
import MainFooter from './layout/MainFooter.vue';

Vue.use(VueRouter);

let router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: '/home',
      name: 'index',
      components: { default: Index, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '*',
      redirect: { name: 'index' }
    },
    {
      path: '/informatie',
      name: 'Documents',
      components: { default: Documents, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/partners',
      name: 'Partners',
      components: { default: Partners, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/posts',
      name: 'Posts',
      components: { default: Posts, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/posts/details/:Pid',
      name: 'PostDetails',
      components: { default: PostDetails, header: MainNavbar, footer: MainFooter },
      props: {
        default: true,
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard',
      name: 'Dashboard',
      components: { default: Dashboard, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard/post/create',
      name: 'DashboardCreationPost',
      components: { default: DashboardCreationPost, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard/document/create',
      name: 'DashboardCreationDocument',
      components: { default: DashboardCreationDocument, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard/partner/create',
      name: 'DashboardCreationPartner',
      components: { default: DashboardCreationPartner, header: MainNavbar, footer: MainFooter },
      props: {
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard/post/edit/:Pid',
      name: 'DashboardEditPosts',
      components: { default: DashboardEditPosts, header: MainNavbar, footer: MainFooter },
      props: {
        default: true,
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard/document/edit/:Pid',
      name: 'DashboardEditDocuments',
      components: { default: DashboardEditDocuments, header: MainNavbar, footer: MainFooter },
      props: {
        default: true,
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/admin/dashboard/partner/edit/:Pid',
      name: 'DashboardEditPartners',
      components: { default: DashboardEditPartners, header: MainNavbar, footer: MainFooter },
      props: {
        default: true,
        header: { colorOnScroll: 0 },
        footer: { backgroundColor: 'black' }
      }
    },
    {
      path: '/login',
      name: 'Login',
      components: { default: Login, header: MainNavbar },
      props: {
        header: { colorOnScroll: 400 }
      }
    }
  ],
  scrollBehavior: to => {
    if (to.hash) {
      return { selector: to.hash };
    } else {
      return { x: 0, y: 0 };
    }
  },
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    // this route requires auth, check if logged in
    // if not, redirect to login page.
    if (store.getters["security/isAuthenticated"]) {
      next();
    } else {
      next({
        path: "/login",
        query: { redirect: to.fullPath }
      });
    }
  } else {
    next(); // make sure to always call next()!
  }
});

export default router;

