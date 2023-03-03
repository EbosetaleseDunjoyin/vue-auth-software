<template>
  <div class="container home">
    <div class="row bg-light py-5 ">
      <h1 class="text-center my-5">Welcome to Mazer App</h1>
      <div class="row" v-if="authtoken == null">
        <div class="col-6 d-flex justify-content-start justify-content-lg-center">
          <a class="text" href="/login">Login</a>
        </div>
        <div class="col-6 d-flex justify-content-start justify-content-lg-center">
          <a class="text" href="/register">Register</a>
        </div>
      </div>
      <div class="div" v-else>
        <div class="col-12 d-flex justify-content-center">
          <a class="text" href="/profile">Profile</a>
        </div>
       
      </div>
      
        
    </div>
  </div>

   
</template>
<style scoped >

  h1{
    color:#3d0af3;
  }
  a.text{
    text-decoration: none;
    font-size: 20px;
    font-weight: 600;
    color: #000000;
  }
  a.text:hover{
    color: #3d0af3;
  }
</style>

<script>
import Header from '../components/Header.vue'

export default{
  name: 'HomeView',
  data(){return{authtoken : null}},
  mounted(){
     if (localStorage.getItem("authtoken") != null) { this.authtoken = localStorage.getItem("authtoken"); }
    
  }
}
</script>
