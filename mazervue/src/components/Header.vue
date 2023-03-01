<template>
   <header id="header" >
            <img src="public/assets/images/logo/logo.png" alt="" class="logo-md img-fluid">
            <div class="container-fluid p-0 top-nav">
                <nav class="navbar sticky-top navbar-expand-lg ">
                    <div class="container">
                        <a class="navbar-brand" href="#">
                            <img src="public/assets/images/logo/logo.png" class="img-fluid logo" alt="">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mx-lg-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <router-link class="nav-link " aria-current="page" to="/admin">Profile</router-link>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Buddies</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Discover</a>
                                </li>
                                <li class="nav-item">
                                    <router-link class="nav-link" to="/settings">Settings & Privacy</router-link>
                                </li>
                          
                            </ul>
                            <ul class="navbar-nav ms-lg-auto mb-2 mb-lg-0">
                                <li class="nav-item ">
                                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                       <img src="public/assets/images/faces/1.jpg" class="img-fluid face" alt="">
                                    </a>
                               
                                </li>
                          
                            </ul>
                        
                        </div>
                    </div>
                </nav>
            </div>
            <div class="container-fluid p-0 bottom-nav">
                <nav class=" sticky-bottom navbar-expand-lg ">
                    <div class="container">
                        <div class="row bottom-links">
                            <router-link class="col-3 nav-pill  d-flex flex-column text-center" to="/admin">
                           
                                <a class="nav-link " aria-current="page" ><i class="bi bi-person-fill"></i></a>
                            </router-link>
                            <div class="col-3 nav-pill d-flex flex-column text-center" to="">
                           
                                <a class="nav-link" aria-current="page" > <i class="bi bi-people-fill"></i></a>
                            </div>
                            <div class="col-3 nav-pill d-flex flex-column text-center"  to="">
                            
                                <a class="nav-link" aria-current="page" ><i class="bi bi-globe"></i></a>
                            </div>
                            <router-link class="col-3 nav-pill d-flex flex-column text-center"  to="/settings">
                            
                                <a class="nav-link" aria-current="page" ><i class="bi bi-gear-fill"></i> </a>
                            </router-link>
                        </div>
                   
                    </div>
                </nav>
            </div>
       
    </header>
    
</template>

<script>
export default {
    name: 'Header',
    data () {
       return{
        
       }
       
    }
}
</script>

<style>

</style>