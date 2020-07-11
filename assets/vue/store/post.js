import PostAPI from "../api/post";

const CREATING_POST = "CREATING_POST",
  CREATING_POST_SUCCESS = "CREATING_POST_SUCCESS",
  CREATING_POST_ERROR = "CREATING_POST_ERROR",
  FETCHING_POSTS = "FETCHING_POSTS",
  FETCHING_POSTS_SUCCESS = "FETCHING_POSTS_SUCCESS",
  FETCHING_POSTS_ERROR = "FETCHING_POSTS_ERROR",
  REMOVE_POST = "REMOVE_POST",
  UPDATE_POST = "UPDATE_POST";


export default {
  namespaced: true,
  state: {
    isLoading: false,
    error: null,
    posts: []
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
    hasPosts(state) {
      return state.posts.length > 0;
    },
    posts(state) {
      return state.posts;
    },
  },
  mutations: {
    [CREATING_POST](state) {
      state.isLoading = true;
      state.error = null;
    },
    [CREATING_POST_SUCCESS](state, post) {
      state.isLoading = false;
      state.error = null;
      state.posts.unshift(post);
    },
    [CREATING_POST_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.posts = [];
    },
    [FETCHING_POSTS](state) {
      state.isLoading = true;
      state.error = null;
      state.posts = [];
    },
    [FETCHING_POSTS_SUCCESS](state, posts) {
      state.isLoading = false;
      state.error = null;
      state.posts = posts;
    },
    [FETCHING_POSTS_ERROR](state, error) {
      state.isLoading = false;
      state.error = error;
      state.posts = [];
    },
    [REMOVE_POST](state, { postId, }) {
      state.isLoading = true;
      let posts = state.posts.find(post => post.id === postId).posts;

      let rs = posts.filter(currentPost => {
        return currentPost.id !== postId;
      })

      state.posts.find(post => post.id === postId).posts = [...rs];
    },
    [UPDATE_POST](state, {postId, title, content, img}) {
      if (postId && title && content && img) {
        state.posts.find(post => post.id === postId).title = title;
        state.posts.find(post => post.id === postId).content = content;
        state.posts.find(post => post.id === postId).img = img;
      }
    }

  },
  actions: {
    async create({ commit }, payload) {
      commit(CREATING_POST);
      try {
        let response = await PostAPI.create(payload.title, payload.content, payload.img);
        commit(CREATING_POST_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(CREATING_POST_ERROR, error);
        return null;
      }
    },
    edit({ commit }, { postId, title, content, img }) {
      return new Promise(async (resolve, reject) => {
        let {data, status} = await PostAPI.edit(postId, title, content, img)
        if (status === 204 || status === 200) {
          commit(UPDATE_POST, {
            postId,
            title,
            content,
            img
          });
          resolve({data, status});
        } else {
          reject({data, status});
        }
      })
    },
    async findAll({ commit }) {
      commit(FETCHING_POSTS);
      try {
        let response = await PostAPI.findAll();
        commit(FETCHING_POSTS_SUCCESS, response.data);
        return response.data;
      } catch (error) {
        commit(FETCHING_POSTS_ERROR, error);
        return null;
      }
    },
    async DELETE_POST({ commit }, { postId }) {
      return new Promise((resolve, reject) => {
        PostAPI.delete(postId)
          .then(({ status }) => {
            if (status === 204) {
              commit(REMOVE_POST, {
                postId
              })
              resolve(status);
            }
          })
          .catch(error => {
            reject(error);
          })
      })
    },

    // async delete ({ commit }, id) {
    //   let response = await PostAPI.delete(id);
    //   commit(DELETING_POST, response.data);
    //   return response.data;
    // }
  }
};