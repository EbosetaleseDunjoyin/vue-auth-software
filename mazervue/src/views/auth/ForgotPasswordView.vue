<template>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left" v-if="!tokenAvailable">
                    <div class="auth-logo">
                        <a href="/"><img src="public/assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Forgot Password</h1>
                    <p class="auth-subtitle mb-5">Input your email and we will send you reset password link.</p>
                    


                    <form @submit.prevent="checkemail()">
                        <div class="form-group position-relative has-icon-left mb-4" v-if="!mailsent">
                            <input type="email" class="form-control form-control-xl" v-model="email" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4" v-else>
                            <input type="text" class="form-control form-control-xl" v-model="token" placeholder="Token">
                            <div class="form-control-icon">
                                <i class="bi bi-code"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Already have an account? <a href="/login" class="font-bold">Log
                                in</a>.</p>
                    </div>
                </div>
                <div id="auth-left" v-if="tokenAvailable">
                    <div class="auth-logo">
                        <a href="/"><img src="public/assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Change Password</h1>
                    <p class="auth-subtitle mb-5">Input your new password</p>
                    


                    <form @submit.prevent="changePassword()">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" v-model="newPassword" placeholder="New Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Save</button>
                        
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
    name: 'ForgotPasswordView',
    components: {
        TheAuth
    },
    mounted(){

    },
    data(){
        return{
            email:'',
            token:'',
            newPassword:'',
            errors:[],
            mailsent:false,
            authtoken:'',
            tokenAvailable:false,
        }
    },
    methods:{
        checkemail(){
            if(this.mailsent == true){
                if (this.token == '') {
                    this.errors.push('Token is Required');
                } else {
                    let email = this.email;
                    let token = this.token;
                    let data = {
                        email: email,
                        token: token,
                    };
                    const headers = {
                        'Authorization': `Bearer ${this.authtoken}`,

                    };
                    this.axios.post('/auth/verify-password-token', data)
                        .then((res) => {
                            // JSON responses are automatically parsed.
                            if (res.data.status == true) {
                                this.tokenAvailable = true
                            } else {
                                this.errors.push(res.data.errors)
                            }

                        })
                        .catch((e) => {
                            this.errors.push(e);
                        });
                }
            }else{
                if (this.email == '') {
                    this.errors.push('Email Required');
                } else {
                    let email = this.email;
                    let data = {
                        email: email,
                    };
                    const headers = {
                        'Authorization': `Bearer ${this.authtoken}`,

                    };
                    this.axios.post('/auth/forgot-password', data)
                        .then((res) => {
                            // JSON responses are automatically parsed.
                            if (res.data.status == true) {
                                this.mailsent = true
                            } else {
                                this.errors.push(res.data.errors)
                            }

                        })
                        .catch((e) => {
                            this.errors.push(e);
                        });
                }
            }
          
        },
        changePassword(){
            if (this.newPassword == '') {
                this.errors.push('Password Required');
            } else {
                let email = this.email;
                let password = this.newPassword;
                let data = {
                    email: email,
                    password: password,
                };
                const headers = {
                    'Authorization': `Bearer ${this.authtoken}`,

                };
                this.axios.put('/auth/reset-password', data)
                    .then((res) => {
                        // JSON responses are automatically parsed.
                        if (res.data.status == true) {
                            this.mailsent = false
                            this.tokenAvailable = false
                            this.$router.push({ path: '/login' });
                        } else {
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
 


<style scoped>@import '../../../public/assets/css/app.css';</style>