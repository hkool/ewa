<template>
  <div style="">
    <section class="news-intro" style="background-color: #FFB300;padding-top:8%;margin-bottom:5%">
      <div class="container">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto text-center">
            <h2 class="title" style="color: black; font-size:50px; ">{{ header }}</h2>
          </div>
        </div>
      </div>
    </section>

    <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

    <div v-else class="container" style="display:block;">
        <button
          @click="prevPage"
          style=""
          type="button"
          class="lined thin"
          :disabled="pageNumber==0"
        >&nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;</button>
        <button
          @click="nextPage"
          style=""
          type="button"
          class="lined thin"
          :disabled="pageNumber >= pageCount -1"
        >Volgende > </button>
      </div>

    <div class="container" style=" margin-top:3%;">

    
      <div class="row">

        <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

        <div v-else-if="hasError" class="row">
          <div class="alert alert-danger" role="alert">
            <error-message :error="error" />
          </div>
        </div>

        <div v-else-if="!hasPosts" class="row">No posts!</div>

        <div
          v-for="post in paginatedData"
          v-else
          :key="post.id"
          class="col-lg-4 col-md-4 col-sm-12 col-xs-12"
          style="heigth:50%"
        >
          <post
            :title="post.title"
            :content="post.content"
            :img="post.img"
            :created="post.created"
            @click.native="goToNews(post.id)"
          />
        </div>

      </div>

      <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

      <div v-else style="display:block;margin-bottom:10%;">
        <button 
        @click="prevPage"
        style="width: auto"
        type="button"
        class="lined thin"
        :disabled="pageNumber==0"
        >
        &nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;
        </button>
        <button 
        @click="nextPage"
        style="width: auto"
        type="button"
        class="lined thin"
        :disabled="pageNumber >= pageCount -1"
        >
        Volgende >
        </button>
      </div>

    </div>
  </div>
</template>

<script>
import Post from "../pages/components/Post/Post";
import ErrorMessage from "../pages/components/ErrorMessage";

export default {
  name: "Posts",
  components: {
    Post,
    ErrorMessage
  },
  props:{
    size:{
      type:Number,
      required:false,
      default: 9
    }
  },
  data() {
    return {
      title: "",
      content: "",
      img: "",
      header: "NIEUWS",
      pageNumber: 0,  // default to page 0
    };
  },
  methods: {
    goToNews(postId) {
      this.$router.push({ name: "PostDetails", params: { Pid: postId } });
    },
    
    nextPage(){
        this.pageNumber++;
    },
    prevPage(){
        this.pageNumber--;
    }
  },
  computed: {
    isLoading() {
      return this.$store.getters["post/isLoading"];
    },
    hasError() {
      return this.$store.getters["post/hasError"];
    },
    error() {
      return this.$store.getters["post/error"];
    },
    hasPosts() {
      return this.$store.getters["post/hasPosts"];
    },
    posts() {
      return this.$store.getters["post/posts"];
    },
    canCreatePost() {
      return this.$store.getters["security/hasRole"]("ROLE_ADMIN");
    },
    pageCount(){
      let l = this.posts.length,
          s = this.size;
      return Math.ceil(l/s);
    },
    paginatedData(){
    const start = this.pageNumber * this.size,
          end   = start + this.size;     
    return this.posts.slice(start, end).sort(function(a, b) {
        return a.created < b.created ? 1 : -1;
      });
    }
  },
  created() {
    this.$store.dispatch("post/findAll");
  }
};
</script>

<style lang="scss" scoped>
.spinner-border {
  display: block;
  position: fixed;
  z-index: 1031;
  top: 60%;
  right: 50%; /* or: left: 50%; */
}

@import "../assets/scss/now-ui-kit/mixins.scss";

.news-intro {
  @include angled-edge("outside bottom", "lower left", #ffb300);
}

button{
      align-self:center;
      background:transparent;
      padding:0.5rem 1rem;
      transition:all .5s ease;
      color:#41403E;
      letter-spacing:1px;
      outline:none;
      box-shadow: 20px 38px 34px -26px hsla(0,0%,0%,.2);
      border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
      cursor: pointer;
      /*
      Above is shorthand for:
      border-top-left-radius: 255px 15px;
      border-top-right-radius: 15px 225px;
      border-bottom-right-radius: 225px 15px;
      border-bottom-left-radius:15px 255px;
      */
       &:hover{
         box-shadow:2px 8px 4px -6px hsla(0,0%,0%,.3);
      } 
      &.lined.thick{
         border:solid 7px #41403E;
      }
      &.lined.thin{
         border:solid 2px #41403E;
      }
}
</style>