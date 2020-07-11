<template>
  <form>
    <div class="content" style="margin-top:15%;">
      <div class="container">
        <div class="col-md-5 ml-auto mr-auto">
          <card type="login" plain>
            <div slot="header" class="logo-container">
              <img v-lazy="'images/EWAHaaglanden.jpg'" alt />
            </div>
            <div class="row">
              <div class="col-12">
                <input
                  class="big_form"
                  v-model="login"
                  type="text"
                  addon-left-icon="now-ui-icons users_circle-08"
                  placeholder="Gebruikersnaam..."
                  style="margin-bottom:5%;width:100%"
                />
              </div>
              <div class="col-12">
                <input
                  class="big_form"
                  v-model="password"
                  type="password"
                  addon-left-icon="now-ui-icons text_caps-small"
                  placeholder="Wachtwoord..."
                  style="width:100%"
                />
              </div>
            </div>

            <template slot="raw-content">
              <div class="card-footer text-center">
                <button
                  :disabled="login.length === 0 || password.length === 0 || isLoading"
                  type="button"
                  class="lined thin"
                  @click="performLogin()"
                >Inloggen</button>
              </div>
            </template>
          </card>

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
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import { Button } from "../components";
import Card from "../components/Cards/Card";
import ErrorMessage from "../pages/components//ErrorMessage";

export default {
  name: "Login",
  components: {
    Card,
    [Button.name]: Button,
    ErrorMessage
  },
  data() {
    return {
      login: "",
      password: "",
      header: "LOGIN"
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["security/isLoading"];
    },
    hasError() {
      return this.$store.getters["security/hasError"];
    },
    error() {
      return this.$store.getters["security/error"];
    }
  },
  created() {
    let redirect = this.$route.query.redirect;

    if (this.$store.getters["security/isAuthenticated"]) {
      if (typeof redirect !== "undefined") {
        this.$router.push({ path: redirect });
      } else {
        this.$router.push({ path: "/home" });
      }
    }
  },
  methods: {
    async performLogin() {
      let payload = { login: this.$data.login, password: this.$data.password },
        redirect = this.$route.query.redirect;

      await this.$store.dispatch("security/login", payload);
      if (!this.$store.getters["security/hasError"]) {
        if (typeof redirect !== "undefined") {
          this.$router.push({ path: redirect });
        } else {
          this.$router.push({ path: "/home" });
        }
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.spinner-border {
  display: block;
  position: fixed;
  z-index: 1031;
  top: 30%;
  right: 50%; /* or: left: 50%; */
}

.big_form {
  font-size: 20px;
  height: 56px;
  box-shadow: none;
  display: flex;
  -moz-box-align: center;
  align-items: center;
  width: 100%;
  max-width: 668px;
  position: relative;
  height: 48px;
  border-color: currentcolor currentcolor rgb(102, 102, 102);
  border-bottom-color: rgb(102, 102, 102);
  border-style: none none solid;
  border-width: medium medium 2px;
  border-image: none 100% / 1 / 0 stretch;
  border-radius: 0px;

  font-family: "Exo BNNVARA", Verdana, sans-serif;
  color: rgb(16, 16, 16);
  font-size: 16px;
  text-indent: 17px;
  padding: 3px;
}

.big_form:focus {
  border-bottom-color: rgb(16, 16, 16);
  outline: rgb(1, 186, 239) solid 2px;
  outline-offset: 2px;
}

.big_form:hover,
.big_form:active {
  outline: currentcolor none 0px;
  border-bottom-color: rgb(16, 16, 16);
}

@import "../assets/scss/now-ui-kit/mixins.scss";

.news-intro {
  @include angled-edge("outside bottom", "lower right", #cc0029);
}

button{
      align-self:center;
      background:transparent;
      padding:0.5rem 1rem;
      margin:0 1rem;
      transition:all .5s ease;
      color:#41403E;
      letter-spacing:1px;
      outline:none;
      cursor: pointer;
      box-shadow: 20px 38px 34px -26px hsla(0,0%,0%,.2);
      border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
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