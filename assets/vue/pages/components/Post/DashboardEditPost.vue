<template>
  <section v-if="canCreatePost" class="EditPost">
    <div class="container h-100" style>
      
      <div class="row h-100 justify-content-center align-items-center">
        <div v-if="isLoading" class="container" style="text-align: center">
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

        <div v-for="post in posts" v-else :key="post.id">
          <div v-if="postId == post.id">
            <DashboardFormEditPost 
            :title="post.title" 
            :content="post.content" 
            :img="post.img" />
          </div>
        </div>

        <br />
      </div>
    </div>
  </section>
</template>

<script>
import DashboardFormEditPost from "../Post/DashboardFormEditPost";

export default {
  name: "DashboardEditPost",
  components: {
    DashboardFormEditPost
  },
  data() {
    return {
      title: "",
      content: "",
      img: "",
      postId: this.$route.params.Pid
    };
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
    }
  },
  created() {
    this.$store.dispatch("post/findAll");
  }
};
</script>

<style lang="scss" scoped>
body {
  margin: 0 !important;
}
</style>
