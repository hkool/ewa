import axios from "axios";

export default {
  create(name, website, img) {
    return axios.post("/api/admin/dashboard/partner/create", {
      name: name,
      website: website,
      img: img
    }
    );
  },
  findAll() {
    return axios.get("/api/partners");
  },

  delete(partnerId) {
    return axios.delete('/api/admin/dashboard/partner/delete/' + partnerId);
  },

  edit(partnerId, name, website, img) {
    return axios.patch("/api/admin/dashboard/partner/edit/" + partnerId, {
    name: name,
    website: website,
    img: img,
    }
    );
  },
};