import { createWebHistory, createRouter } from 'vue-router';
import { useAuthStore } from '@/stores/auth';

import login from '../views/login.vue';
const TheContainer = () => import("../layouts/TheContainer.vue");
const Dashboard = () => import("../views/Dashboard.vue");

const routes = [
    {
        path: '/login',
        name : 'login',
        component : login,
        meta: {
            title:'Login'
        },
    },
    {
        path: "/",
        redirect: "/dashboard",
        name: "dashboard",
        component: TheContainer,
        children: [
            {
                path: "/dashboard",
                name: "Dashboard",
                component: Dashboard,
                meta: {
                    requiresAuth: true,
                    title:'Dashboard'
                },
            },
            {
                path: "/store",
                name: "Store",
                component: () => import("../views/Store.vue"),
                meta: {
                    requiresAuth: true,
                    title:'Store'
                },
            },
            {
                path: "/entry",
                name: "Entry",
                component: () => import("../views/Entry.vue"),
                meta: {
                    requiresAuth: true,
                    title:'Stock Entry'
                },
            },
            {
                path: "/bulk-entry",
                name: "BulkEntry",
                component: () => import("../views/Bulk-Entry/Bulk-Entry.vue"),
                meta: {
                    requiresAuth: true,
                    title:'Bulk Stock Entry'
                },
            },


        ]
    }
];

const router = createRouter({
   history: createWebHistory(),
   routes
});

const appName = window.appName;

router.beforeEach((to, from, next) => {
    const title = to.meta && to.meta.title ? to.meta.title : 'Dashboard';
    window.document.title = title + ' - ' + appName;
    const authStore = useAuthStore();
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        // Redirect to login if not authenticated
        next('/login');
    } else {
        next();
    }
});


export default router;
