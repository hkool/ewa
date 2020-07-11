import axios from "axios";

export default {
  create(title, content, img) {
    return axios.post("/api/admin/dashboard/post/create", {
      title: title,
      content: content,
      img: img,
    }
    );
  },
  edit(postId, title, content, img) {
    return axios.patch("/api/admin/dashboard/post/edit/" + postId, {
      id: postId,
      title: title,
      content: content,
      img: img,
    }
    );
  },
  findAll() {
    return axios.get("/api/posts");
  },
  delete(postId) {
    return axios.delete('/api/admin/dashboard/post/delete/' + postId);
  }
};