<template>
  <section class="allContacts">
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
              placeholder="Vind een e-mail..."
              style="height: 2.4rem"
              v-model="contactEmailSearchString"
            />
          </div>
        </div>

        <table
          style="display:block; margin-left:2%; margin-top:2%"
          class="table table-striped table-hover table-responsive"
        >
          <thead class="thead-dark">
            <tr>
              <th style="width:30%">Naam</th>
              <th style="width:30%">E-mail</th>
              <th style="width:10%">Datum</th>
              <th style="width:20%">Acties</th>
            </tr>
          </thead>
          <tbody>
            <div v-if="isLoading" class="container" style="margin-top:4%; margin-left:140%">
              <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </div>
            <div v-else-if="hasError" class="row">
              <div class="alert alert-danger" role="alert">
                <error-message :error="error" />
              </div>
            </div>

            <div v-else-if="!hasContacts" class="row" style="margin-left:5%;">Geen e-mails!</div>
            <tr v-for="contact in paginatedData" v-else :key="contact.id">
              <td style="width:15%">{{contact.name}}</td>
              <td style="width:40%">{{contact.email}}</td>
              <td style="width:5%">{{contact.created.replace(/^(\d+)-(\d+)-(\d+)(.*):\d+$/, '$3/$2/$1$4').slice(0,10)}}</td>
              <td style="width:20%;vertical-align: middle;">
                <button type="button" class="lined thin" @click="deleteContact(contact.id)">
                  <i class="fa fa-trash"></i>
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
        >
        &nbsp;&nbsp;&lt; Vorige&nbsp;&nbsp;
        </button>
        <button 
        @click="nextPage"
        type="button"
        class="lined thin"
        :disabled="pageNumber >= pageCount -1"
        >
        Volgende >
        </button>
        </div>


      </div>
    </div>
  </section>
</template>

<script>
import ErrorMessage from "../../../pages/components/ErrorMessage";

export default {
  name: "DashboardContacts",
  components: {
    ErrorMessage
  },
  props:{
    size:{
      type:Number,
      required:false,
      default: 10
    }
  },
  data() {
    return {
      name: "",
      email: "",
      message: "",
      pageNumber: 0,  // default to page 0
      contactEmailSearchString: ""
    };
  },
  methods: {
    deleteContact(contactId) {
      let i = this.contacts.map(contact => contact.id).indexOf(contactId);
      this.contacts.splice(i, 1);
      this.$store.dispatch("contact/DELETE_CONTACT", {
        contactId
      });
      this.flash('E-mail verwijderd', 'error', {
        timeout: 1000
      });
    },
    nextPage(){
        this.pageNumber++;
    },
    prevPage(){
        this.pageNumber--;
    }

  },
  computed: {
    isLoading() {
      return this.$store.getters["contact/isLoading"];
    },
    hasError() {
      return this.$store.getters["contact/hasError"];
    },
    error() {
      return this.$store.getters["contact/error"];
    },
    hasContacts() {
      return this.$store.getters["contact/hasContacts"];
    },
    contacts() {
      return this.$store.getters["contact/contacts"];
    },
    pageCount(){
      let l = this.contacts.length,
          s = this.size;
      return Math.ceil(l/s);
    },
    paginatedData() {
      var contactEmailSearchString = this.contactEmailSearchString;
      contactEmailSearchString = contactEmailSearchString.trim().toLowerCase();

      const start = this.pageNumber * this.size,
        end = start + this.size;
      return this.contacts
        .filter(function(contacts) {
          if (
            contacts.email.toLowerCase().indexOf(contactEmailSearchString) !== -1
          ) {
            return contacts;
          }
        })
        .sort(function(a, b) {
          return a.created < b.created ? 1 : -1;
        })
        .slice(start, end);
    }
  },
  created() {
    this.$store.dispatch("contact/findAll");
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
