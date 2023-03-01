<template>
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
                              <li class="list-group-item">Username : User123</li>
                              <li class="list-group-item">Email : excel@user.com</li>
                              <li class="list-group-item">Phone : +234 906 789 6523</li>
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
                              <li class="list-group-item">Football</li>
                          </ul>
                      </div>
                  </div>
              </div>
       
          </div>
     </div>
</template>

<script>
import Header from '../components/Header.vue';
export default {
    name:'MasterView',
    components:{
        Header
    }
}
</script>

<style>

</style>