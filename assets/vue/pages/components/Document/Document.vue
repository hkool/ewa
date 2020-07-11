<template>
  <div class="card" style="margin-right:6%; margin-bottom:5%;height: 50vh;">
    <div class="card-body">
      <h5 class="card-title" style="text-size:20px;font-weight:bold;height:8vh">{{ name }}</h5>
      <p
        class="card-text"
        style="color: #b4b4b4;"
      >{{ created.replace(/^(\d+)-(\d+)-(\d+)(.*):\d+$/, '$3/$2/$1$4').slice(0,10) }}</p>

      <p class="card-text" style="text-size:12px;white-space: pre-line">{{ description }}</p>
    </div>
    <div v-if="file.length > 6" class="container" style="text-align:center;padding-top:1vh">
      <a class="lined thin" :href="require(`../../../../../public/images/doc/${file}`)" download>Download</a>
    </div>
    <div v-else-if="file === null" class="container" style="text-align:center;"></div>
  </div>
</template>

<script>
export default {
  name: "Document",
  props: {
    name: {
      type: String,
      required: true
    },
    description: {
      type: String,
      required: true
    },
    file: {
      type: String,
      required: false
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

a{
      align-self:center;
      background:transparent;
      padding:0.5rem 1rem;
      margin:0 1rem;
      transition:all .5s ease;
      color:#41403E;
      letter-spacing:1px;
      outline:none;
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
}


</style>
