<template>
    <div id="auth">

        <div class="row h-100">
             <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Sign Up</h1>
                    <p class="auth-subtitle mb-5">Input your data to register to our website.</p>

                    <form @submit.prevent="registerUser()" method="post">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Email" v-model="email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="number" class="form-control form-control-xl" v-model="phone_no" placeholder="Phone Number">
                            <div class="form-control-icon">
                                <i class="bi bi-phone"></i>
                            </div>
                        </div>
                        <div class=" ">
                            <div class="form-group position-relative has-icon-left mb-4">
                                <select class="choices form-select multiple-remove form-control form-control-xl" v-model="intrests" multiple="multiple">
                                    <option value="">Your Intrests</option>
                                    <optgroup label="Intrests">
                                        <option value="football" selected>Football</option>
                                        <option value="basketball" >Basketball</option>
                                        <option value="motorsports" >Motorsports</option>
                                        <option value="bandy">Bandy</option>
                                        <option value="rugby">Rugby</option>
                                    </optgroup>
                                
                                </select>
                        
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password" v-model="password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button @submit.prevent class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Sign Up</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href="/login" class="font-bold">Log
                                in</a>.</p>
                    </div>
                </div>
            </div>
            <TheAuth></TheAuth>
        </div>
    </div>
</template>

<script>
import TheAuth from '../../components/TheAuth.vue';
import '../../../public/assets/vendors/choices.js/choices.min.js'
import '../../../public/assets/js/pages/form-element-select.js'
export default {
    name: 'RegisterView',
    components: {
        TheAuth
    },
    data (){
        return{
            email:'',
            phone_no:'',
            password:'',
            intrests:[],
        }
      
    },
    methods: {
        registerUser() {

        }
    }
}
</script>
 


<style scoped>
@import '../../../public/assets/css/app.css';
</style>