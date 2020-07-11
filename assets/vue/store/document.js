import DocumentAPI from "../api/document";

const CREATING_DOCUMENT = "CREATING_DOCUMENT",
    CREATING_DOCUMENT_SUCCESS = "CREATING_DOCUMENT_SUCCESS",
    CREATING_DOCUMENT_ERROR = "CREATING_DOCUMENT_ERROR",
    FETCHING_DOCUMENTS = "FETCHING_DOCUMENTS",
    FETCHING_DOCUMENTS_SUCCESS = "FETCHING_DOCUMENTS_SUCCESS",
    FETCHING_DOCUMENTS_ERROR = "FETCHING_DOCUMENTS_ERROR",
    REMOVE_DOCUMENT = "REMOVE_DOCUMENT",
    UPDATE_DOCUMENT = "UPDATE_DOCUMENT";


export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        documents: []
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
        hasDocuments(state) {
            return state.documents.length > 0;
        },
        documents(state) {
            return state.documents;
        },
    },
    mutations: {
        [CREATING_DOCUMENT](state) {
            state.isLoading = true;
            state.error = null;
        },
        [CREATING_DOCUMENT_SUCCESS](state, document) {
            state.isLoading = false;
            state.error = null;
            state.documents.unshift(document);
        },
        [CREATING_DOCUMENT_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.documents = [];
        },
        [FETCHING_DOCUMENTS](state) {
            state.isLoading = true;
            state.error = null;
            state.documents = [];
        },
        [FETCHING_DOCUMENTS_SUCCESS](state, documents) {
            state.isLoading = false;
            state.error = null;
            state.documents = documents;
        },
        [FETCHING_DOCUMENTS_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.documents = [];
        },
        [REMOVE_DOCUMENT](state, { documentId, }) {
            state.isLoading = true;
            let documents = state.documents.find(document => document.id === documentId).documents;

            let rs = documents.filter(currentDocument => {
                return currentDocument.id !== documentId;
            })

            state.documents.find(document => document.id === documentId).documents = [...rs];
        },
        [UPDATE_DOCUMENT](state, { documentId, name, description, file }) {
            if (documentId && name && description && file) {
                state.documents.find(document => document.id === documentId).name = name;
                state.documents.find(document => document.id === documentId).description = description;
                state.documents.find(document => document.id === documentId).file = file;
            }
        }

    },
    actions: {
        async create({ commit }, payload) {
          commit(CREATING_DOCUMENT);
          try {
            let response = await DocumentAPI.create(payload.name, payload.description, payload.file);
            commit(CREATING_DOCUMENT_SUCCESS, response.data);
            return response.data;
          } catch (error) {
            commit(CREATING_DOCUMENT_ERROR, error);
            return null;
          }
        },
        async findAll({ commit }) {
          commit(FETCHING_DOCUMENTS);
          try {
            let response = await DocumentAPI.findAll();
            commit(FETCHING_DOCUMENTS_SUCCESS, response.data);
            return response.data;
          } catch (error) {
            commit(FETCHING_DOCUMENTS_ERROR, error);
            return null;
          }
        },
    
        async DELETE_DOCUMENT({ commit }, { documentId }) {
          return new Promise((resolve, reject) => {
            DocumentAPI.delete(documentId)
              .then(({ status }) => {
                if (status === 204) {
                  commit(REMOVE_DOCUMENT, {
                    documentId
                  })
                  resolve(status);
                }
              })
              .catch(error => {
                reject(error);
              })
          })
        },
    
        edit({ commit }, { documentId, name, description, file }) {
          return new Promise(async (resolve, reject) => {
            let { data, status } = await DocumentAPI.edit(documentId, name, description, file)
            if (status === 204 || status === 200) {
              commit(UPDATE_DOCUMENT, {
                documentId,
                name,
                description,
                file
              });
              resolve({ data, status });
            } else {
              reject({ data, status });
            }
          })
        },
    
      }
    };