<template>
  <div>
    <IntroductionSection></IntroductionSection>

    <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

    <div v-else class="container" style="display:block;">
        <button
          @click="prevPage"
          style=""
          type="button"
          class="lined thin"
          :disabled="pageNumber==0"
        >&nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;</button>
        <button
          @click="nextPage"
          style=""
          type="button"
          class="lined thin"
          :disabled="pageNumber >= pageCount -1"
        >Volgende > </button>
      </div>
  
    <div class="container" style=" margin-top:3%;">
      

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

        <div v-else-if="!hasDocuments" class="row">Geen bestanden!</div>

        <div
          v-for="document in paginatedData"
          v-else
          :key="document.id"
          class="col-lg-4 col-md-4 col-sm-12 col-xs-12"
        >
          <document
            :name="document.name"
            :description="document.description"
            :file="document.file"
            :created="document.created"
          />

          
        </div>
      </div>

      <div v-if="isLoading" class="container">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

      <div v-else style="display:block;margin-bottom:10%;">
        <button 
        @click="prevPage"
        style="width: auto"
        type="button"
        class="lined thin"
        :disabled="pageNumber==0"
        >
        &nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;
        </button>
        <button 
        @click="nextPage"
        style="width: auto"
        type="button"
        class="lined thin"
        :disabled="pageNumber >= pageCount -1"
        >
        Volgende >
        </button>
      </div>

    </div>
  </div>
</template>
<script>
import IntroductionSection from "../pages/components/IntroductionSection";
import Document from "../pages/components/Document/Document";
import ErrorMessage from "../pages/components/ErrorMessage";

export default {
  name: "Documents",
  components: {
    IntroductionSection,
    Document,
    ErrorMessage
  },
  props: {
    size: {
      type: Number,
      required: false,
      default: 9
    }
  },
  data() {
    return {
      name: "",
      description: "",
      file: "",
      pageNumber: 0 // default to page 0
    };
  },
  methods: {
    nextPage() {
      this.pageNumber++;
    },
    prevPage() {
      this.pageNumber--;
    }
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
    },
    pageCount() {
      let l = this.documents.length,
        s = this.size;
      return Math.ceil(l / s);
    },
    paginatedData() {
      const start = this.pageNumber * this.size,
        end = start + this.size;
      return this.documents.slice(start, end).sort(function(a, b) {
        return a.created < b.created ? 1 : -1;
      });
    }
  },
  created() {
    this.$store.dispatch("document/findAll");
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
button{
      align-self:center;
      background:transparent;
      padding:0.5rem 1rem;
      transition:all .5s ease;
      color:#41403E;
      letter-spacing:1px;
      outline:none;
      box-shadow: 20px 38px 34px -26px hsla(0,0%,0%,.2);
      border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
      cursor: pointer;
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

