<template>
  <section class="EditDocument">
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

        <div v-else-if="!hasDocuments" class="row">Geen bestanden!</div>

        <div v-for="document in documents" v-else :key="document.id">
          <div v-if="documentId == document.id">
            <DashboardFormEditDocument 
            :name="document.name" 
            :description="document.description" 
            :file="document.file" />
          </div>
        </div>

        <br />
      </div>
    </div>
  </section>
</template>

<script>
import DashboardFormEditDocument from "../Document/DashboardFormEditDocument";

export default {
  name: "DashboardEditDocument",
  components: {
    DashboardFormEditDocument
  },
  data() {
    return {
      name: "",
      description: "",
      file: "",
      documentId: this.$route.params.Pid
    };
  },
  computed: {
    isLoading() {
      return this.$store.getters["document/isLoading"];
    },
    hasError() {
      return this.$store.getters["document/hasError"];
    },
    error() {
      return this.$store.getters["document/error"];
    },
    hasDocuments() {
      return this.$store.getters["document/hasDocuments"];
    },
    documents() {
      return this.$store.getters["document/documents"];
    }
  },
  created() {
    this.$store.dispatch("document/findAll");
  },
};
</script>

<style lang="scss" scoped>
body {
  margin: 0 !important;
}
</style>
