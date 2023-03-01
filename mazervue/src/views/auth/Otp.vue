<template>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="/"><img src="public/assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Verification</h1>
                    <p class="auth-subtitle mb-5">You will be sent a code or link for verification</p>
                    <form @submit.prevent="sendOTP()" v-if="otpsent == false" method="post">
                            <div class="col-lg-6 col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" v-model="receiver" value="email" name="reciever" checked>
                                    <label class="form-check-label" >
                                        Email
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                 <div class="form-check">
                                        <input class="form-check-input" type="radio" value="phone" v-model="receiver"  name="reciever">
                                        <label class="form-check-label">
                                           Phone Number
                                        </label>
                                    </div>
                            </div>
                            <button @submit.prevent class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
                    </form>
                    <form @submit.prevent="checkOTP()" v-if="otpsent == true">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="number" class="form-control form-control-xl" placeholder="Code">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button @submit.prevent class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Send</button>
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
    name: 'Otp',
    components: {
        TheAuth
    },
    data(){
        return{
            otpsent:false,
            receiver:'email',
        }

    },
    methods:{
        checkOTP(){

        },
        sendOTP(){
            console.log('sent')
        }
    }


}
</script>
 


<style scoped>@import '../../../public/assets/css/app.css';</style>