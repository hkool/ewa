<template>
  <div id="app">
    <router-view name="header" />
    <div class="wrapper">
      <router-view />
      <cookie-law theme="dark-lime"></cookie-law>
    </div>
    <router-view name="footer" />
  </div>
</template>

<script>
import axios from "axios";
import CookieLaw from 'vue-cookie-law'

export default {
  name: "App",
  computed: {
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"]
    },
  },
  components: {
    CookieLaw
  },
  created() {
    let isAuthenticated = JSON.parse(this.$parent.$el.attributes["data-is-authenticated"].value),
      user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

    let payload = { isAuthenticated: isAuthenticated, user: user };
    this.$store.dispatch("security/onRefresh", payload);

    axios.interceptors.response.use(undefined, (err) => {
      return new Promise(() => {
        if (err.response.status === 401) {
          this.$router.push({path: "/login"})
        } else if (err.response.status === 500) {
          document.open();
          document.write(err.response.data);
          document.close();
        }
        throw err;
      });
    });
  },
}
</script>

<style scoped>

.wrapper{
  display: flex;
  flex-direction: column;
  min-height: 94vh;
}

#app {
  flex: 1;
}
</style>
