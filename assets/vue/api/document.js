import axios from "axios";

export default {
  create(name, description, file) {
    return axios.post("/api/admin/dashboard/document/create", {
      name: name,
      description: description,
      file: file
    }
    );
  },
  findAll() {
    return axios.get("/api/informatie");
  },

  delete(documentId) {
    return axios.delete('/api/admin/dashboard/document/delete/' + documentId);
  },

  edit(documentId, name, description, file) {
    return axios.patch("/api/admin/dashboard/document/edit/" + documentId, {
    name: name,
    description: description,
    file: file,
    }
    );
  },
};