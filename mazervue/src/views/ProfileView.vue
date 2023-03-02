<template>
    <div class="div">
        <Header></Header>
        <div id="main">
                <div class="" id="cover-image">
                
                        <div class="container">
                            <div class="row cover-text ">
                                <h3 class="text-light">Profile</h3>
                            </div>
                    
                        </div>
                
                
                </div>
                <div class="container box ">
                    <div class="row">
                        <div class="avater-image">
                            <img src="public/assets/images/faces/1.jpg"  class="img-fluid " alt="">
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="section-header">
                            <h2>Profile Details</h2>
                        </div>

                        <div class="section-card my-3">
                            <div class="card" style="width: 18rem;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" >Username : {{ username ? username : 'not set' }}</li>
                                    <li class="list-group-item">Email : {{ user.email ?  user.email : '---' }}</li>
                                    <li class="list-group-item">Phone : +234 {{ user.phone_no ? user.phone_no : '---' }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="section-header">
                            <h2>Intrests</h2>
                        </div>

                        <div class="section-card my-3">
                            <div class="card" style="width: 18rem;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" v-for="(intrest, index) in intrests" :key ="index">{{ intrest }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
        
                </div>
        </div>
    </div>
  
</template>

<script>
import Header from '../components/Header.vue';
export default {
    name:'ProfileView',
    components:{
        Header
    },
    
    data(){
        return{
            user : {},
            username:'',
            authtoken: '',
            intrests:[],
            errors:[],
            message:'',

        }
    },
    mounted() {
        this.getUserData();
        // {{ user.user_profile.username ? user.user_profile.username : 'Not Set' }}
    },
    methods: {
        getUserData(){
            // if (localStorage.getItem("authtoken") == null) { this.$router.push({ path: '/login' }); }
            console.log('profile')
            this.authtoken =  localStorage.getItem("authtoken");
             const headers = {
                'Authorization': `Bearer ${this.authtoken}`,
                
            };
             this.axios.get('/user/profile',  {headers} )
                .then((res) => {
                    // JSON responses are automatically parsed.
                  if (res.data.status == true) {
                    // console.log(res.data)
                        this.user = res.data.data
                        this.username = this.user.user_profile.username
                        this.intrests = JSON.parse(this.user.user_profile.intrests)

                        
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