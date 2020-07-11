<template>
  <div
    class="card"
    style="
    margin-right:6%; 
    margin-bottom:5%
    border:0px;; 
    "
  >
    <img
      style="
    width:  auto;
    height: 50px;
    background-size: cover;
    display: block;
    margin-left: auto;
    margin-right: auto;
    margin-top:10%;
    "
      :src="require(`../../../../../public/images/logo/${img}`)"
      alt="Partner logo"
    />
    <div class="card-body" style="text-align:center;">
      <h5
        class="card-title"
        style="text-size:20px;font-weight:bold;text-align:center; margin-bottom:6%"
      >{{ name }}</h5>
      <div class="container">
      <a
      class='lined thin'
        :href="website"
        target="_blank"
      >Website</a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Partner",
  props: {
    name: {
      type: String,
      required: true
    },
    website: {
      type: String,
      required: true
    },
    img: {
      type: String,
      required: true
    },
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
