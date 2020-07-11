import PartnerAPI from "../api/partner";

const CREATING_PARTNER = "CREATING_PARTNER",
  CREATING_PARTNER_SUCCESS = "CREATING_PARTNER_SUCCESS",
  CREATING_PARTNER_ERROR = "CREATING_PARTNER_ERROR",
  FETCHING_PARTNERS = "FETCHING_PARTNERS",
  FETCHING_PARTNERS_SUCCESS = "FETCHING_PARTNERS_SUCCESS",
  FETCHING_PARTNERS_ERROR = "FETCHING_PARTNERS_ERROR",
  REMOVE_PARTNER = "REMOVE_PARTNER",
  UPDATE_PARTNER = "UPDATE_PARTNER";


export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    partners: []
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
    hasPartners(state) {
      return state.partners.length > 0;
    },
    partners(state) {
      return state.partners;
    },
  },
  mutations: {
    [CREATING_PARTNER](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_PARTNER_SUCCESS](state, partner) {
      state.isLoading = false;
      state.error = null;
      state.partners.unshift(partner);
    },
    [CREATING_PARTNER_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.partners = [];
    },
    [FETCHING_PARTNERS](state) {
      state.isLoading = true;
      state.error = null;
      state.partners = [];
    },
    [FETCHING_PARTNERS_SUCCESS](state, partners) {
      state.isLoading = false;
      state.error = null;
      state.partners = partners;
    },
    [FETCHING_PARTNERS_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.partners = [];
    },
    [REMOVE_PARTNER](state, { partnerId, }) {
      state.isLoading = true;
      let partners = state.partners.find(partner => partner.id === partnerId).partners;

      let rs = partners.filter(currentPartner => {
        return currentPartner.id !== partnerId;
      })

      state.partners.find(partner => partner.id === partnerId).partners = [...rs];
    },
    [UPDATE_PARTNER](state, { partnerId, name, website, img }) {
      if (partnerId && name && website && img) {
        state.partners.find(partner => partner.id === partnerId).name = name;
        state.partners.find(partner => partner.id === partnerId).website = website;
        state.partners.find(partner => partner.id === partnerId).img = img;
      }
    }


  },
  actions: {
    async create({ commit }, payload) {
      commit(CREATING_PARTNER);
      try {
        let response = await PartnerAPI.create(payload.name, payload.website, payload.img);
        commit(CREATING_PARTNER_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(CREATING_PARTNER_ERROR, error);
        return null;
      }
    },
    async findAll({ commit }) {
      commit(FETCHING_PARTNERS);
      try {
        let response = await PartnerAPI.findAll();
        commit(FETCHING_PARTNERS_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(FETCHING_PARTNERS_ERROR, error);
        return null;
      }
    },

    async DELETE_PARTNER({ commit }, { partnerId }) {
      return new Promise((resolve, reject) => {
        PartnerAPI.delete(partnerId)
          .then(({ status }) => {
            if (status === 204) {
              commit(REMOVE_PARTNER, {
                partnerId
              })
              resolve(status);
            }
          })
          .catch(error => {
            reject(error);
          })
      })
    },

    edit({ commit }, { partnerId, name, website, img }) {
      return new Promise(async (resolve, reject) => {
        let { data, status } = await PartnerAPI.edit(partnerId, name, website, img)
        if (status === 204 || status === 200) {
          commit(UPDATE_PARTNER, {
            partnerId,
            name,
            website,
            img
          });
          resolve({ data, status });
        } else {
          reject({ data, status });
        }
      })
    },

  }
};