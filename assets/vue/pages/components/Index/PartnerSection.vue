<template>
  <div id="PartnerSection" style="background-color:#f6f6f6;">
    <div class="container" style="text-align: center; margin-bottom: 30px;">
      <h2 class="title" style="color: black; font-size:50px;">ONZE PARTNERS</h2>
    </div>
    <div class="container" style="text-align: center">
      <infinite-slide-bar :barStyle="{  }">
        <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

        <div v-else-if="hasError">
          <div class="alert alert-danger" role="alert">
            <error-message :error="error" />
          </div>
        </div>

        <div v-else-if="!hasPartners" style="margin-left:5%;">No partners!</div>

          <img 
          v-for="partner in partners" v-else :key="partner.id"
          class="img-padding" 
          :src="require(`../../../../../public/images/logo/${partner.img}`)" 
          />
    
      </infinite-slide-bar>
    </div>
  </div>
</template>

<script>
import infiniteSlideBar from "../../../components/partnerSlider";

export default {
  name: "PartnerSection",
  components: { infiniteSlideBar },
  data: function() {
    return {
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

<style>
body {
  margin: 0 !important;
}
.img-padding {
  padding-left: 20px;
  flex: 1
}
</style>
