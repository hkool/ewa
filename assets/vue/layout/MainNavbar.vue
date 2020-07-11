<template>
  <navbar
    position="fixed"
    type="white"
    :transparent="transparent"
    :color-on-scroll="colorOnScroll"
    menu-classes="ml-auto"
  >
    <a class="navbar-brand" href="/home">
      <img src="images/EWAHaaglanden_logo.png" alt style="width: 200px" />
    </a>

    <template slot="navbar-menu">
      <li class="nav-item">
        <nav-link class="nav-link" to="/home">
          <p>Home</p>
        </nav-link>
      </li>
      <li class="nav-item">
        <nav-link class="nav-link" to="/posts">
          <p>Nieuws</p>
        </nav-link>
      </li>
      <li class="nav-item">
        <nav-link class="nav-link" to="/partners">
          <p>Partners</p>
        </nav-link>
      </li>
      <li class="nav-item">
        <nav-link class="nav-link" to="/informatie">
          <p>Informatie</p>
        </nav-link>
      </li>
      <li v-if="isAuthenticated" class="nav-item">
        <nav-link class="nav-link" to="/admin/dashboard">
          <p>Dashboard</p>
        </nav-link>
      </li>

      <li v-if="!isAuthenticated" class="nav-item">
        <nav-link class="nav-link" to="/login">
          <p>Inloggen</p>
        </nav-link>
      </li>

      <li v-if="isAuthenticated" class="nav-item" style="color:black;">
        <a class="nav-link" href="/api/security/logout">
          <p>Uitloggen</p>
        </a>
      </li>
    </template>
  </navbar>
</template>

<script>
import { Navbar, NavLink } from "../components";
import { Popover } from "element-ui";
export default {
  name: "main-navbar",
  props: {
    transparent: Boolean,
    colorOnScroll: Number
  },
  components: {
    Navbar,
    NavLink,
    [Popover.name]: Popover
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"];
    }
  }
};
</script>

<style scoped>
</style>
