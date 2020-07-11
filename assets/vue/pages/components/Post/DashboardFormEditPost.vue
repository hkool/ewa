<template>
  <form method="post" enctype="multiplart/form-data">
    <div class="content" style>
      <div class="container" style="width:85%">
        <flash-message class="success" style="width:25%;text-align:center;margin-left: 25%;margin-bottom:5%; position:absolute;top: 40%;left: 12.5%;"></flash-message>
        <div class="row">
          <div class="col-12">
            <input
              class="form-control"
              id="title"
              v-model="title"
              type="text"
              placeholder="Titel"
              style="margin-bottom:2%;"
            />
          </div>

          <div class="col-6">
            <span style="white-space: pre;">
              <textarea
                class="form-control"
                id="content"
                rows="4"
                cols="80"
                v-model="content"
                type="text"
                placeholder="Vul in de inhoud van de artikel"
                style="margin-bottom:2%;"
              ></textarea>
            </span>
          </div>

          <div class="col-6">
            <input
              class="form-control"
              type="file"
              ref="files"
              name="files"
              style="width:100%;border:none;margin-bottom:2%;padding-left:0px;"
              @change="onFileSelected"
              placeholder="Image"
              accept="image/jpeg, image/png"
            />
            <img :src="img" alt="Afbeelding voorbeeld" style="width:150px; height:auto;" />
          </div>
          <div class="col-6">
            <button
              type="button"
              class="lined thin"
              @click="goBack()"
            >Terug</button>
          </div>
          <div class="col-6">
            <button
              type="button"
              class="lined thin"
              @click="editPost()"
            >Veranderen</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
require('vue-flash-message/dist/vue-flash-message.min.css');

export default {
  name: "DashboardFormEditPost",
  methods: {
    async editPost() {
      this.$store
        .dispatch("post/edit", {
          postId: this.$route.params.Pid,
          title: this.title,
          content: this.content,
          img: this.img
        })
        .catch(error => {
          console.log(error);
        });
        this.flash('Nieuws artikel veranderd!', 'success', {
        timeout: 2000
      });
        
    },

    goBack() {
      this.$router.push({ path: "/admin/dashboard" });
    },

    onFileSelected(event) {
      let image = event.target.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.img = e.target.result;
      };
    }
  },
  props: {
    title: {
      type: String,
      required: true
    },
    content: {
      type: String,
      required: true
    },
    img: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
body {
  margin: 0 !important;
}

button{
      align-self:center;
      width: 100%;
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
