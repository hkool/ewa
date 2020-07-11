<template>
  <section class="EditPartner">
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

        <div v-else-if="!hasPartners" class="row">No partners!</div>

        <div v-for="partner in partners" v-else :key="partner.id">
          <div v-if="partnerId == partner.id">
            <DashboardFormEditPartner 
            :name="partner.name" 
            :website="partner.website" 
            :img="partner.img" />
          </div>
        </div>

        <br />
      </div>
    </div>
  </section>
</template>

<script>
import DashboardFormEditPartner from "../Partner/DashboardFormEditPartner";

export default {
  name: "DashboardEditPartner",
  components: {
    DashboardFormEditPartner
  },
  data() {
    return {
      title: "",
      content: "",
      img: "",
      partnerId: this.$route.params.Pid
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
  },
};
</script>

<style lang="scss" scoped>
body {
  margin: 0 !important;
}
</style>
