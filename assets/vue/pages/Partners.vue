<template>
  <div class="partners" style="background-color: #f6f6f6;">
    <section class="news-intro" style="background-color: #FFB300;padding-top:8%;margin-bottom:10%">
      <div class="container">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto text-center">
            <h2 class="title" style="color: black; font-size:50px; ">{{ header }}</h2>
          </div>
        </div>
      </div>
    </section>

    <div class="container">
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

          <div v-else-if="!hasPartners" class="row" style="margin-left:5%;">No partners!</div>

          <div
            v-for="partner in partners"
            v-else
            :key="partner.id"
            class="col-lg-4 col-md-4 col-sm-12 col-xs-12"
          >

           <partner
            :name="partner.name"
            :website="partner.website"
            :img="partner.img"
          />
            
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ErrorMessage from "../pages/components/ErrorMessage";
import Partner from "../pages/components/Partner/Partner";

export default {
  name: "Partners",
  components: {
    ErrorMessage,
    Partner,
  },

  data: function() {
    return {
      header: "PARTNERS",
      name: "",
      website: "",
      img: ""
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["partner/isLoading"];
    },
    hasError() {
      return this.$store.getters["partner/hasError"];
    },
    error() {
      return this.$store.getters["partner/error"];
    },
    hasPartners() {
      return this.$store.getters["partner/hasPartners"];
    },
    partners() {
      return this.$store.getters["partner/partners"];
    }
  },
  created() {
    this.$store.dispatch("partner/findAll");
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
</style>