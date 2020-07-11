import Vue from "vue";
import Vuex from "vuex";
import SecurityModule from "./security";
import PostModule from "./post";
import ContactModule from "./contact";
import PartnerModule from "./partner";
import DocumentModule from "./document";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    security: SecurityModule,
    post: PostModule,
    contact: ContactModule,
    partner: PartnerModule,
    document: DocumentModule
  }
});