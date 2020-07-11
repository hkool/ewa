<template>
  <div style="background-color: #f6f6f6;">
    <div class="container" style=" margin-top:3%;background-color:white;">
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

      <div v-for="post in posts" v-else :key="post.id">
        <div v-if="postId == post.id">
          <NewsPagePost
            :title="post.title"
            :content="post.content"
            :img="post.img"
            :created="post.created"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NewsPagePost from "../pages/components/Post/NewsPagePost";
import ErrorMessage from "../pages/components/ErrorMessage";

export default {
  name: "PostDetails",
  components: {
    NewsPagePost,
    ErrorMessage
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
.spinner-border {
  display: block;
  position: fixed;
  z-index: 1031;
  top: 50%;
  right: 50%; /* or: left: 50%; */
}
</style>