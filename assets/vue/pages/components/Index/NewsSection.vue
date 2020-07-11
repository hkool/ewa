<template>
  <section style="background-color: #CC0029;">
    <div id="NewsSection" style=";padding-bottom:5%">
      <div class="container" style="text-align: center">
        <h2 class="title" style="color: white; font-size:50px;">{{ header }}</h2>
        <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <div
          class="card"
          v-for="post in sortFunc()"
          :key="post.id"
          v-else
          @click="goToNews(post.id)"
          style="width: 21rem; margin-right:2%; margin-bottom:2%; cursor:pointer;"
        >
          <img
            class="card-img"
            :src="require(`../../../../../public/images/news/${post.img}`)"
            height="251px"
            width="190px"
            style="cursor:pointer"
            alt="Artikel foto"
          />
          <div class="card-img-overlay d-flex container">
            <h5
              class="card-title text-white"
              style="color: #b4b4b4;text-size:20px;font-weight:bold;"
            >{{ post.title}}</h5>
            <p
              class="card-text text-white"
              style="color: #b4b4b4;font-size: .895em;"
            >{{ post.created.replace(/^(\d+)-(\d+)-(\d+)(.*):\d+$/, '$3/$2/$1$4').slice(0,10) }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "NewsSection",
  data() {
    return {
      title: "",
      img: "",
      header: "Laatste berichten"
    };
  },
  methods: {
    goToNews(postId) {
      this.$router.push({ name: "PostDetails", params: { Pid: postId } });
    },
    sortFunc: function() {
      return this.posts.slice(0, 6).sort(function(a, b) {
        return a.created < b.created ? 1 : -1;
      });
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
.card-title {
  position: absolute;
  top: 45%;
  left: 0;
  width: 100%;
  color: black;
}
.card-img-overlay {
  height: 100%;
  width: 100%;
  background-color: #000;
  opacity: 0.6;
}

@import "../../../assets/scss/now-ui-kit/mixins.scss";
</style>
