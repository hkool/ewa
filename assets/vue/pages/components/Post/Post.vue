<template>
  <div class="card" style="margin-right:6%; margin-bottom:5%;height: 75vh;">
    <img
      class="card-img-top"
      style="width:100%;height:25vh;cursor:pointer;"
      :src="require(`../../../../../public/images/news/${img}`)"
      alt="Niews foto"
    />
    <div class="card-body" style="">
      <div style="">
      <h5 class="card-title" style="text-size:20px;font-weight:bold; height:8vh">{{ title }}</h5>
      </div>
      <div style="display:flex;margin-auto">
      <p
        class="card-text"
        style="color: #b4b4b4;margin-bottom:1vh"
      >{{ created.replace(/^(\d+)-(\d+)-(\d+)(.*):\d+$/, '$3/$2/$1$4').slice(0,10) }}</p>
      </div>
      <p
        class="card-text"
        style="text-size:12px;white-space: pre-line"
      >{{ content.slice(0,200) + '...' }}</p>
      <div class="card-footer mx-auto">
        <button class="lined thin">Lees meer</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Post",
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
    },
    created: {
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
      background:transparent;
      padding:0.5rem 1rem;
      transition:all .5s ease;
      color:#41403E;
      letter-spacing:1px;
      outline:none;
      box-shadow: 20px 38px 34px -26px hsla(0,0%,0%,.2);
      border-radius: 255px 15px 225px 15px/15px 225px 15px 255px;
      cursor: pointer;
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
}
</style>
