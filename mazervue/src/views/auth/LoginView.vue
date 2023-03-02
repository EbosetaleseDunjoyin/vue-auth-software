<template>
  <div id="auth">
        
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                    </div>

                    <h5 class="text-danger text-capitalize" v-for="(error, index) in errors" :key="index">{{ error }}</h5>
                        <h5 class="text-success text-capitalize" v-if="message != ''">{{ message }}</h5>
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
                       
                        <button  class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
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
            errors:[],
            message:'',
        }
    },
    mounted(){
        this.ifTokenAvailable();
    },
    methods:{
        LoginUser(){
             if (this.name == '' || this.password == '') {
                this.errors.push('Please check data');
            } else {
                let name = this.name;
                let password = this.password;
                let data = {
                    email_phone: name,
                    password: password
                };
                this.axios.post('/auth/login', data)
                    .then((res) => {
                        // JSON responses are automatically parsed.
                        if (res.data.status == true) {
                            this.message = res.message
                            localStorage.setItem("authtoken", res.data.token)
                            if(res.data.user.status == 'inactive'){
                                this.$router.push({ path: '/otp', query: { email: res.data.user.email, phone_no: res.data.user.phone_no } })
                            } 
                            if(res.data.user.user_profile == null){
                                console.log(res.data.user);
                                this.$router.push({ path: '/onboarding', query: { user_id: res.data.user.id, token: res.data.token } })
                            }else{
                                this.$router.push({ path: '/profile'})
                            }
                           
                        } else {
                            this.errors.push(res.data.errors)
                        }

                    })
                    .catch((e) => {
                        this.errors.push(e);
                    });
            }
        },
        ifTokenAvailable(){
            if (localStorage.getItem("authtoken") !== null) { this.$router.push({ path: '/profile' }); }
        }
    }
}
</script>


<style scoped>
@import '../../../public/assets/css/app.css';

</style>