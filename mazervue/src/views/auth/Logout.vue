<template>
    <div class="container">
        <h1 class="text-center text-primary my-5">Loging Out......</h1>
    </div>
  
</template>

<script>

export default {
    name:'Logout',
    components:{

    },
    
    data(){
        return{
            user : {},
            authtoken: '',
            intrests:[],
            errors:[]

        }
    },
    mounted() {
        this.logout();
        // {{ user.user_profile.username ? user.user_profile.username : 'Not Set' }}
    },
    methods: {
        logout(){
            if (localStorage.getItem("authtoken") === null) { this.$router.push({ path: '/login' }); }
            this.authtoken =  localStorage.getItem("authtoken");
             const headers = {
                'Authorization': `Bearer ${this.authtoken}`,
                
            };
             this.axios.get('/auth/logout',  {headers} )
                .then((res) => {
                    // JSON responses are automatically parsed.
                  if (res.data.status == true) {
                            localStorage.removeItem("authtoken")
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
</script>

<style>

</style>