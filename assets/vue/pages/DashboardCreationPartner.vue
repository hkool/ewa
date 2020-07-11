<template>
  <div v-if="isAuthenticated">
    <section class="news-intro" style="background-color: #FFB300;padding-top:8%;margin-bottom:10%">
      <div class="container">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto text-center">
            <h2 class="title" style="color: black; font-size:50px; ">{{ header }}</h2>
          </div>
        </div>
      </div>
    </section>

    <DashboardCreatePartner></DashboardCreatePartner>
  </div>
</template>

<script>
import DashboardCreatePartner from "../pages/components/Partner/DashboardCreatePartner";

export default {
  name: "DashboardCreationPartner",
  components: {
    DashboardCreatePartner
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"]
    },
  },
  data() {
    return {
      header: "Maak partner aan"
    };
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

@import "../assets/scss/now-ui-kit/mixins.scss";

.news-intro {
  @include angled-edge("outside bottom", "lower left", #ffb300);
}
</style>
