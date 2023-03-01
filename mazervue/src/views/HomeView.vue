<template>
  <div class="container home">
    <div class="row bg-light py-5 ">
      <h1 class="text-center my-5">Welcome to Mazer App</h1>
      <div class="col-6 d-flex justify-content-center">
        <a class="text" href="/login">Login</a>
      </div>
      <div class="col-6 d-flex justify-content-center">
        <a class="text" href="/register">Register</a>
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

<script setup>
import Header from '../components/Header.vue'
</script>
