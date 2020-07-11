import ContactAPI from "../api/contact";

const CREATING_CONTACT = "CREATING_CONTACT",
  CREATING_CONTACT_SUCCESS = "CREATING_CONTACT_SUCCESS",
  CREATING_CONTACT_ERROR = "CREATING_CONTACT_ERROR",
  FETCHING_CONTACTS = "FETCHING_CONTACTS",
  FETCHING_CONTACTS_SUCCESS = "FETCHING_CONTACTS_SUCCESS",
  FETCHING_CONTACTS_ERROR = "FETCHING_CONTACTS_ERROR",
  REMOVE_CONTACT = "REMOVE_CONTACT";


export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    contacts: []
  },
  getters: {
    isLoading(state) {
      return state.isLoading;
    },
    hasError(state) {
      return state.error !== null;
    },
    error(state) {
      return state.error;
    },
    hasContacts(state) {
      return state.contacts.length > 0;
    },
    contacts(state) {
      return state.contacts;
    },
  },
  mutations: {
    [CREATING_CONTACT](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_CONTACT_SUCCESS](state, contact) {
      state.isLoading = false;
      state.error = null;
      state.contacts.unshift(contact);
    },
    [CREATING_CONTACT_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.contacts = [];
    },
    [FETCHING_CONTACTS](state) {
      state.isLoading = true;
      state.error = null;
      state.contacts = [];
    },
    [FETCHING_CONTACTS_SUCCESS](state, contacts) {
      state.isLoading = false;
      state.error = null;
      state.contacts = contacts;
    },
    [FETCHING_CONTACTS_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.contacts = [];
    },
    [REMOVE_CONTACT](state, { contactId, }) {
      state.isLoading = true;
      let contacts = state.contacts.find(contact => contact.id === contactId).contacts;

      let rs = contacts.filter(currentContact => {
        return currentContact.id !== contactId;
      })

      state.contacts.find(contact => contact.id === contactId).contacts = [...rs];
    },
    
    // [DELETING_POST](state, id){
    //   let idx = state.posts.indexOf(id)
    //   state.posts.splice(idx,1)
    //  }
  },
  actions: {
    async create({ commit }, payload) {
      commit(CREATING_CONTACT);
      try {
        let response = await ContactAPI.create(payload.name, payload.email, payload.message, payload.subscribed);
        commit(CREATING_CONTACT_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(CREATING_CONTACT_ERROR, error);
        return null;
      }
    },
    async findAll({ commit }) {
      commit(FETCHING_CONTACTS);
      try {
        let response = await ContactAPI.findAll();
        commit(FETCHING_CONTACTS_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(FETCHING_CONTACTS_ERROR, error);
        return null;
      }
    },
    async DELETE_CONTACT({ commit }, { contactId }) {
      return new Promise((resolve, reject) => {
        ContactAPI.delete(contactId)
          .then(({ status }) => {
            if (status === 204) {
              commit(REMOVE_CONTACT, {
                contactId
              })
              resolve(status);
            }
          })
          .catch(error => {
            reject(error);
          })
      })
    },
    
  }
};