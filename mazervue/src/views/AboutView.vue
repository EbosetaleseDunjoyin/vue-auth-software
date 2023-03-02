<template>
  <div class="div">
     <Header></Header>
    <div class="about">
       <ul v-if="posts && posts.length">
                <li v-for="(post, counter ) in posts" :key="counter">
                    <p><strong>{{ post.title }}</strong></p>
                    <p>{{ post.body }}</p>
                </li>
            </ul>

            <ul v-if="errors && errors.length">
                <li v-for="(error, counter) in errors" :key="counter">
                    {{ error.message }}
                </li>
            </ul>
    </div>
  </div>
 
</template>

<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>

<script>
import axios  from '@/plugins/axios'
import Header from '../components/Header.vue';



export default {
  name:'AboutView',
  data() {
    return {
      posts: [],
      errors: [],
    };
  },
  components:{
    Header
  },
  // Pulls posts when the component is created.
  created() {
    this.getdata();
  },
  methods : {
    getdata(){
      axios
        .get(`/posts`)
        .then((response) => {
          // JSON responses are automatically parsed.
          this.posts = response.data;
          console.log(response.data)
        })
        .catch((e) => {
          this.errors.push(e);
        });
    }
  }
};
</script>
