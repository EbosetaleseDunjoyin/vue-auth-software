<template>
  <div id="auth">
        
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                    <form @submit.prevent="LoginUser()" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" v-model="name" placeholder="Email or Phone Number">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" v-model="password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" v-model="keepmelogin" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button  @submit.prevent class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="/register" class="font-bold">Sign
                                up</a>.</p>
                        <p><a class="font-bold" href="/forgot-password">Forgot password?</a>.</p>
                    </div>
                </div>
            </div>
            <TheAuth></TheAuth>
        </div>
    </div>
</template>

<script>
import TheAuth from '../../components/TheAuth.vue';
export default {
    name: 'LoginView',
    components :{
        TheAuth
    },
    data () {
        return{
            name:'',
            password:'',
            keepmelogin:'',
        }
    },
    methods:{
        LoginUser(){

        }
    }
}
</script>


<style scoped>
@import '../../../public/assets/css/app.css';

</style>