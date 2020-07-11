<template>
  <section class="allDocuments">
    <div class="container">
      <div class="row">
        <div style="display:block;margin-top: 5%">
          <div class="container" style="display:block; margin-left:2%">
          
            <button
              @click="prevPage"
              type="button"
              class="lined thin"
              :disabled="pageNumber==0"
            >&nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;</button>
            <button
              @click="nextPage"
              type="button"
              class="lined thin"
              :disabled="pageNumber >= pageCount -1"
            >Volgende ></button>

            <input
              type="text"
              placeholder="Vind een bestand..."
              style="height: 2.4rem"
              v-model="documentNaamSearchString"
            />

             <flash-message class="error" style="width:65%;text-align:center;margin-top:2%"></flash-message>
        
          </div>
        </div>

        <table
          style="display:block; margin-left:2%; margin-top:2%"
          class="table table-striped table-hover table-responsive"
        >
          <thead class="thead-dark">
            <tr>
              <th style="width:30%">Naam</th>
              <th style="width:30%">Omschrijving</th>
              <th style="width:10%">Datum</th>
              <th style="width:20%">Acties</th>
            </tr>
          </thead>
          <tbody>
            <div v-if="isLoading" class="container" style="margin-top:4%; margin-left:150%">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            <div v-else-if="hasError" class="row">
              <div class="alert alert-danger" role="alert">
                <error-message :error="error" />
              </div>
            </div>

            <div v-else-if="!hasDocuments" class="row" style="margin-left:5%;">Geen bestanden!</div>
            <tr v-for="document in paginatedData" v-else :key="document.id">
              <td style="width:15%">{{document.name}}</td>
              <td style="width:15%;">{{document.description.slice(0,200)}}</td>
              <td
                style="width:10%"
              >{{document.created.replace(/^(\d+)-(\d+)-(\d+)(.*):\d+$/, '$3/$2/$1$4').slice(0,10)}}</td>
              <td style="width:20%;vertical-align: middle;">
                <button type="button" class="lined thin" @click="deleteDocument(document.id)">
                  <i class="fa fa-trash"></i>
                </button>
                <button type="button" @click="goToDocument(document.id)" class="lined thin">
                  <i class="fa fa-edit"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <div style="display:block;margin-bottom:10%; margin-left:2%;">
          <button
            @click="prevPage"
            type="button"
            class="lined thin"
            :disabled="pageNumber==0"
          >&nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;</button>
          <button
            @click="nextPage"
            type="button"
            class="lined thin"
            :disabled="pageNumber >= pageCount -1"
          >Volgende ></button>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import ErrorMessage from "../../../pages/components/ErrorMessage";
require('vue-flash-message/dist/vue-flash-message.min.css');

export default {
  name: "DashboardDocuments",
  components: {
    ErrorMessage
  },
  props: {
    size: {
      type: Number,
      required: false,
      default: 10
    }
  },
  data() {
    return {
      id: "",
      name: "",
      description: "",
      file: "",
      pageNumber: 0, // default to page 0
      documentNaamSearchString: ""
    };
  },
  methods: {
    deleteDocument(documentId) {
      let i = this.documents.map(document => document.id).indexOf(documentId);
      this.documents.splice(i, 1);
      this.$store.dispatch("document/DELETE_DOCUMENT", {
        documentId
      });
      this.flash('Bestand verwijderd', 'error', {
        timeout: 1000
      });
    },
    goToDocument(documentId) {
      this.$router.push({
        name: "DashboardEditDocuments",
        params: { Pid: documentId }
      });
    },
    nextPage() {
      this.pageNumber++;
    },
    prevPage() {
      this.pageNumber--;
    }
  },
  created() {
    this.$store.dispatch("document/findAll");
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
      var documentNaamSearchString = this.documentNaamSearchString;
      documentNaamSearchString = documentNaamSearchString.trim().toLowerCase();

      const start = this.pageNumber * this.size,
        end = start + this.size;
      return this.documents
        .filter(function(documents) {
          if (
            documents.name.toLowerCase().indexOf(documentNaamSearchString) !==
            -1
          ) {
            return documents;
          }
        })
        .sort(function(a, b) {
          return a.created < b.created ? 1 : -1;
        })
        .slice(start, end);
    }
  }
};
</script>

<style lang="scss" scoped>

body {
  margin: 0 !important;
}

button{
      align-self:center;
      background:transparent;
      padding:0.5rem 1rem;
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
      &.dotted.thick{
         border:dotted 5px #41403E;
      }
      &.dashed.thin{
        border:dashed 2px #41403E;
        padding:1rem 1rem;
      }
}
</style>
