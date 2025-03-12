<template>
    <div>
        <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
            <div class="sidenav-header text-center">
                <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
                <router-link class="navbar-brand px-4 py-3 m-0" :to="{ name: 'Dashboard'}">
                    <span class="ms-1 text-dark">DK Infoway</span>
                </router-link>
            </div>

            <hr class="horizontal dark mt-0 mb-2">
            <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            :class="{ 'active bg-gradient-dark text-white': $route.name === 'Dashboard', 'text-dark': $route.name !== 'Dashboard' }"
                            :to="{ name: 'Dashboard'}">
                            <i class="material-symbols-rounded opacity-5">dashboard</i>
                            <span class="nav-link-text ms-1">Dashboard</span>
                        </router-link>
                    </li>


                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            :class="{ 'active bg-gradient-dark text-white': $route.name === 'Store', 'text-dark': $route.name !== 'Store' }"
                                     :to="{ name: 'Store'}">
                            <i class="material-symbols-rounded opacity-5">table_view</i>
                            <span class="nav-link-text ms-1">Store</span>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            :class="{ 'active bg-gradient-dark text-white': $route.name === 'Entry', 'text-dark': $route.name !== 'Entry' }"
                                     :to="{ name: 'Entry'}">
                            <i class="material-symbols-rounded opacity-5">table_view</i>
                            <span class="nav-link-text ms-1">Stock Entry</span>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link
                            class="nav-link"
                            :class="{ 'active bg-gradient-dark text-white': $route.name === 'BulkEntry', 'text-dark': $route.name !== 'BulkEntry' }"
                                     :to="{ name: 'BulkEntry'}">
                            <i class="material-symbols-rounded opacity-5">table_view</i>
                            <span class="nav-link-text ms-1">Bulk Stock Entry</span>
                        </router-link>
                    </li>

<!--                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/billing.html">
                            <i class="material-symbols-rounded opacity-5">receipt_long</i>
                            <span class="nav-link-text ms-1">Billing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/virtual-reality.html">
                            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
                            <span class="nav-link-text ms-1">Virtual Reality</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/rtl.html">
                            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
                            <span class="nav-link-text ms-1">RTL</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/notifications.html">
                            <i class="material-symbols-rounded opacity-5">notifications</i>
                            <span class="nav-link-text ms-1">Notifications</span>
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/profile.html">
                            <i class="material-symbols-rounded opacity-5">person</i>
                            <span class="nav-link-text ms-1">Profile</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/sign-in.html">
                            <i class="material-symbols-rounded opacity-5">login</i>
                            <span class="nav-link-text ms-1">Sign In</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="../pages/sign-up.html">
                            <i class="material-symbols-rounded opacity-5">assignment</i>
                            <span class="nav-link-text ms-1">Sign Up</span>
                        </a>
                    </li>-->


                </ul>
            </div>
            <div class="sidenav-footer position-absolute w-100 bottom-0 ">
                <hr class="horizontal dark mt-0 mb-2">
                <div class=" text-center mx-3">
                    <p class="m-0">{{ authStore?.user?.email }}</p>
                    <small>{{ authStore?.user?.name }}</small>
                </div>
                <div class="mx-3">
                    <a @click="logout" class="btn bg-gradient-danger w-100" type="button">
                        <template v-if="isLoading === true">
                            <b-spinner small label="Spinning"></b-spinner> Logout...
                        </template>
                        <template v-else>
                            <i class="material-symbols-rounded opacity-5">logout</i>
                            <span class="nav-link-text ms-1">Logout</span>
                        </template>
                    </a>

                </div>
                <hr class="horizontal dark mt-0 mb-2">
            </div>
        </aside>

        <router-view></router-view>

    </div>
</template>

<script setup>
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2';

import { ref, onMounted } from 'vue';

import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();
const isLoading = ref(false);

const logout = async () => {

    isLoading.value = true;
    try {
        const response = await authStore.logout();

        console.log("response => ", response);

        let data = response;
        if (data?.status === 1) {
            toast.success(data.message);
            setTimeout(async () => {
                await router.push('/login');
                window.location.replace('login');
            }, 2000);
        }else{
            if (data?.errors) {
                errors.value = data.errors
            }
            if(data?.message){
                toast.error(data?.message);
            }
        }
        isLoading.value = false;
    } catch (error) {
        console.error(error);
        toast.error(error);
        isLoading.value = false;
    }

}

onMounted(() => {
    if (!authStore.isAuthenticated) {
        toast.info('You have been logged out!');
        setTimeout( () => {
            router.push('/login');
        }, 1000);
    }
});

</script>
