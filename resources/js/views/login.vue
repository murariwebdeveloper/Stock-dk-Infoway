<template>
    <div>

        <main class="main-content  mt-0">
            <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
                <span class="mask bg-gradient-dark opacity-6"></span>
                <div class="container my-auto">
                    <div class="row">
                        <div class="col-lg-4 col-md-8 col-12 mx-auto">
                            <div class="card z-index-0 fadeIn3 fadeInBottom">
                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                    <div class="bg-gradient-light shadow-light border-radius-lg py-3 pe-1">
                                        <h4 class="text-black font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
<!--                                        <div class="row mt-3">
                                            <div class="col-2 text-center ms-auto">
                                                <a class="btn btn-link px-3" href="javascript:;">
                                                    <i class="fa fa-facebook text-white text-lg"></i>
                                                </a>
                                            </div>
                                            <div class="col-2 text-center px-1">
                                                <a class="btn btn-link px-3" href="javascript:;">
                                                    <i class="fa fa-github text-white text-lg"></i>
                                                </a>
                                            </div>
                                            <div class="col-2 text-center me-auto">
                                                <a class="btn btn-link px-3" href="javascript:;">
                                                    <i class="fa fa-google text-white text-lg"></i>
                                                </a>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <!-- Form validation error start-->
                                            <div class="p-2 rounded-2 border border-danger text-danger" v-if="errors.length !== 0">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="text-danger">
                                                        <span class="fa fa-times-circle me-1"></span> Errors
                                                    </h5>
                                                    <button @click="errors = []" class="btn" type="button">
                                                        <span class="fa fa-times"></span>
                                                    </button>
                                                </div>
                                                <p class="mb-0 flex-1" v-for="(errorList, key) in errors">
                                                    <span class="fw-semi-bold" >{{ formatKey(key) }} :-</span>
                                                    <span v-for="error in errorList">{{ error }}</span>
                                                </p>
                                            </div>
                                            <!-- Form validation error start-->
                                        </div>
                                    </div>


                                    <form @submit.prevent="handleLogin" role="form" class="text-start">

                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" v-model="email" class="form-control">
                                        </div>
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Password</label>
                                            <input type="password" v-model="password" class="form-control">
                                        </div>
<!--                                        <div class="form-check form-switch d-flex align-items-center mb-3">
                                            <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                                            <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                                        </div>-->
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">
                                                <template v-if="isLoading === true">
                                                    <b-spinner small label="Spinning"></b-spinner> Login...
                                                </template>
                                                <template v-else>
                                                    Login
                                                </template>
                                            </button>
                                        </div>
<!--                                        <p class="mt-4 text-sm text-center">
                                            Don't have an account?
                                            <a href="../pages/sign-up.html" class="text-primary text-gradient font-weight-bold">Sign up</a>
                                        </p>-->
                                    </form>

                                    <button class="d-none" @click="notify">Notify !</button>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
const errors = ref('');
const email = ref('');
const password = ref('');

const handleLogin = async () => {
    isLoading.value = true;
    try {
        const response = await authStore.login({ email: email.value, password: password.value });
        let data = response;
        if (data?.status === 1) {
            toast.success(data.message);
            setTimeout(async () => {
                await router.push('/dashboard');
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
};


onMounted(() => {
    if (authStore.isAuthenticated) {
        toast.info('You are already login.');
        setTimeout( () => {
             router.push('/dashboard');
        }, 1000);
    }
});


const notify = async () => {

    await authStore.logout();

    toast("Wow so easy !", {
        autoClose: 1000,
    }); // ToastOptions

    toast("Wow so easy !");

    toast.info('Wow so easy! info ');
    toast.success('Wow so easy! success ');
    toast.warning('Wow so easy! warning ');
    toast.error('Wow so easy! error ');

    Swal.fire({
        title: 'Hello!',
        text: 'This is a local import of SweetAlert2.',
        icon: 'info',
        confirmButtonText: 'Got it!'
    });


}
</script>
