<template>
    <div class="container">
        <h1 class="text-center text-primary my-5">Verifying Email......</h1>
    </div>
  
</template>

<script>

export default {
    name:'VerifyEmail',
    props:['otp'],
    components:{

    },
    
    data(){
        return{
            user : {},
            authtoken: '',
            intrests:[],
            errors:[],

        }
    },
    mounted() {
        this.verifyEmailOtp();
        // {{ user.user_profile.username ? user.user_profile.username : 'Not Set' }}
    },
    methods: {
        verifyEmailOtp(){
             const headers = {
                'Authorization': `Bearer ${this.authtoken}`,
                
            };
             this.axios.get(`/verify-otp/${this.otp}`)
                .then((res) => {
                    // JSON responses are automatically parsed.
                  if (res.data.status == true) {
                            let token = res.data.token
                            let user_id = res.data.user_id
                            this.$router.push({ path: '/onboarding', query: { user_id: user_id, token: token } })
                            
                        } else {
                            this.errors.push(res.data.errors);
                        }
                })
                .catch((e) => {
                    this.errors.push(e.response.data.message);
                });
        }
    }
}
</script>

<style>

</style>