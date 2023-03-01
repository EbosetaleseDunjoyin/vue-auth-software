<template>
  <Header></Header>
    <div id="main">
        <div class="" id="cover-image">

            <div class="container">
                <div class="row cover-text ">
                    <h3 class="text-light">Settings & Privacy</h3>
                </div>

            </div>


        </div>
        <div class="container box ">
            <div class="row">
                <div class="avater-image">
                    <img src="public/assets/images/faces/1.jpg" class="img-fluid " alt="">
                </div>
            </div>
            <div class="row my-5">
                <div class="col-12 col-lg-8">
                    
                    <div class="row">
                         <div class="section-header">
                            <h2>Settings</h2>
                        </div>
                         <div class="section-card my-3">
                            <div class="card  col-12" style=" padding:0px 20px;">
                                <div class="row">
                                <div class="form-floating my-3">
                                    <input type="password" class="form-control" id="floatingPassword" v-model="password" placeholder="Password">
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="form-floating my-3">
                                    <input type="email" class="form-control" id="floatingInpuet" v-model="email" placeholder="model@example.com">
                                    <label for="floatingInpuet">Email address</label>
                                </div>
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" id="floatingInputu" v-model="username" placeholder="dashh">
                                    <label for="floatingInputu">User name</label>
                                </div>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="col-12 col-lg-4">
                <div class="row my-5">

                        <div class="section-card my-3">
                            <div class="card" style="width: 18rem;">
                                <ul class="list-group list-group-flush logout">
                                    <li class="list-group-item text-danger "> <i class="bi bi-power  me-2"></i>Logout</li>
                                </ul>
                            </div>
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
    name:'SettingsView',
    components:{
        Header
    },
    data (){
        return{
            email:'',
            password:'',
            username:'',
        }
    }
}
</script>

<style>

</style>