<template>
  <div v-if="isAuthenticated">
    <section class="news-intro" style="background-color: #FFB300;padding-top:8%;margin-bottom:3%">
      <div class="container">
        <div class="row">
          <div class="col-md-8 ml-auto mr-auto text-center">
            <h2 class="title" style="color: black; font-size:50px; ">{{ header }}</h2>
          </div>
        </div>
      </div>
    </section>

    <section class="createPost">
      <div class="container">
        <div class="row" style="padding-left: 1rem;text-align:center">
        <button 
        type="button"
        
        :class="{'lined thin': !posts, 'dotted thin': posts}"
        @click='posts = !posts; contacts = false; partners = false; documents = false;'> 
        Nieuws</button>
        <button 
        type="button"
        
        :class="{'lined thin': !partners, 'dotted thin': partners}"
        @click='partners = !partners; posts = false; contacts = false; documents = false;'> 
        Partners </button>
        <button 
        type="button"
   
        :class="{'lined thin': !documents, 'dotted thin': documents}"
        @click='documents = !documents; posts = false; contacts = false; partners = false;'> 
        Info </button>
        <button 
        type="button"
        
        :class="{'lined thin': !contacts, 'dotted thin': contacts}"
        @click='contacts = !contacts; posts = false; partners = false; documents = false;'> 
        E-mails </button>
        
      </div>
      </div>
      <div class="container">
        <div class="row">
          <nav-link
              class="nav-link"
              to="/admin/dashboard/post/create"
              v-if='posts'
              style="display:inline; width:auto;"
            >
              <button
                type="button"
                class="lined thin"
              >Maak nieuws artikel</button>
            </nav-link>
            <nav-link
              class="nav-link"
              to="/admin/dashboard/partner/create"
              v-if='partners'
              style="display:inline;width:auto;"
            >
              <button
                type="button"
                class="lined thin"
              >Maak partner</button>
            </nav-link>
            <nav-link
              class="nav-link"
              to="/admin/dashboard/document/create"
              v-if='documents'
              style="display:inline;width:auto;"
            >
              <button
                type="button"
                class="lined thin"
              >Maak bestand</button>
            </nav-link>
        </div>
      </div>
    </section>

    <DashboardPosts
    v-if='posts'
    ></DashboardPosts>

    <DashboardContacts
    v-if='contacts'
    ></DashboardContacts>

    <DashboardPartners
    v-if='partners'
    ></DashboardPartners>

    <DashboardDocuments
    v-if='documents'
    ></DashboardDocuments>

  </div>
</template>

<script>
import DashboardPosts from "../pages/components/Post/DashboardPosts";
import DashboardContacts from "../pages/components/Contact/DashboardContacts";
import DashboardPartners from "../pages/components/Partner/DashboardPartners";
import DashboardDocuments from "../pages/components/Document/DashboardDocuments";

import { NavLink } from "../components";

export default {
  name: "Dashboard",
  components: {
    DashboardPosts,
    DashboardContacts,
    DashboardPartners,
    DashboardDocuments,
    NavLink
  },
  data() {
    return {
      header: "Admin Dashboard",
      posts: false,
      contacts: false,
      partners: false,
      documents: false,
    };
  },
  computed: {
    isAuthenticated() {
      return this.$store.getters["security/isAuthenticated"]
    },
  }
};
</script>

<style lang="scss" scoped>
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
      &.dotted.thin{
         border:dotted 2px #41403E;
      }
}

</style>