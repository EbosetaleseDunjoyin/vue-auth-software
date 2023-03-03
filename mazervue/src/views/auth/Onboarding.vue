<template>
    <div id="auth">

        <div class="row h-100">
             <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo"></a>
                    </div>
                     <ul v-if="errors && errors.length">
                        <li class="text-danger" v-for="(error, counter) in errors" :key="counter">
                            {{ error }}
                        </li>
                    </ul>
                    <h1 class="auth-title">Your Intrests</h1>
                    <p class="auth-subtitle mb-5">Select your intrests so we can best serve you.</p>

                    <form @submit.prevent="saveIntrests()" method="post">
                         <ul class="list-unstyled mb-0">
                            <li class="d-inline-block me-2 mb-1" v-for="(intrest,index) in intrestData" :key="index">
                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" :id="'checkbox'+index" :value="intrest" v-model="intrests" @change="checklist()" class="form-check-input" >
                                        <label >{{ intrest }}</label>
                                    </div>
                                </div>
                            </li>
                            
                        </ul>
                        <button  class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Save</button>
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
    name: 'Onboarding',
    components: {
        TheAuth
    },
    data (){
        return{
            user_id:'',
            errors:[],
            intrests:[],
            authtoken:'',
            intrestData:[
                'Football',
                'Basketball',
                'Ice Hockey',
                'MotorSports',
                'Bandy',
                'Rugby',
                'Skiing',
                'Shooting',
                'Others',
            ],
        }
      
    },
    mounted: async function () {
        // Get user_id and token
        if (this.$route.query.user_id == null && this.$route.query.token) {
            this.$router.push({ path: '/login' });
        }
        this.user_id = this.$route.query.user_id
        this.authtoken = this.$route.query.token

    },
    methods: {
        saveIntrests() {
            if(this.intrests.length == 0) {
                this.errors.push('Please choose your intrests');
            }else{
                let intrests = JSON.stringify(this.intrests);
                let user_id = this.user_id;
                let data = {
                    user_id : user_id,
                    intrests : intrests
                };
                const headers = {
                    'Authorization': `Bearer ${this.authtoken}`,
                    
                };
               this.axios.post('/user/create-intrests', data,  {headers} )
                .then((res) => {
                    // JSON responses are automatically parsed.
                  if (res.data.status == true) {
                            localStorage.setItem("authtoken", this.authtoken);
                            this.$router.push({ path: '/profile' });
                           

                            
                        } else {
                            this.errors.push(res.errors)
                        }
                })
                .catch((e) => {
                    this.errors.push(e);
                });
                
            }
        },
        addIntrests(intrest) {
            
            if(this.intrests.includes(intrest)){
                const index = this.intrests.indexOf(intrest);
                if (index > -1) { // only splice this.intrests when item is found
                    this.intrests.splice(index, 1); // 2nd parameter means remove one item only
                }
            }else{
                this.intrests.push(intrest);
            }
            
            console.log(this.intrests);
        },
        checklist(){
            console.log(this.intrests);
        }
    }
}
</script>
 


<style scoped>
@import '../../../public/assets/css/app.css';
</style>