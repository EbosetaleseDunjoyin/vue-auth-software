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
                            <input type="text" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control form-control-xl" v-model="phone_no" placeholder="Phone Number">
                            <div class="form-control-icon">
                                <i class="bi bi-phone"></i>
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
            errors:[],
            message:'',
           
        }
      
    },
    methods: {
        //pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
        registerUser() {
            if (this.email == '' || this.phone_no == '' || this.password == '' ) {
                this.errors.push('Please check data');
            } else {
                let email = this.email;
                let phone_no = this.phone_no.replace( /[^\d.]/g, '' );
                let password = this.password;
                let data = {
                    email: email,
                    phone_no: phone_no,
                    password: password
                };
                const headers = {
                    'Authorization': `Bearer ${this.authtoken}`,

                };
                this.axios.post('/auth/register', data)
                    .then((res) => {
                        // JSON responses are automatically parsed.
                        if(res.data.status == true){
                            this.message = res.message

                            this.$router.push({ path: '/otp', query: { email: this.email, phone_no: this.phone_no } })
                        }else{
                            this.errors.push(res.data.errors)
                        }

                    })
                    .catch((e) => {
                        this.errors.push(e);
                    });
            }
        }
    }
}
</script>
 


<style scoped>
@import '../../../public/assets/css/app.css';
</style>