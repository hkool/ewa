<template>
  <section style="background-color: #FFB300">
    <div id="VideoSection" style>
      <div class="container" style="text-align: center; padding-bottom:5%;">
        <h2 class="title" style="color: black; font-size:50px;">Ewa Haaglanden in 3 minuten</h2>
        <div class="embed-responsive embed-responsive-16by9">
          <iframe
            class="embed-responsive-item"
            src="https://www.youtube.com/embed/bsPkTBn0s7I"
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "VideoSection"
};
</script>

<style lang="scss" scoped>
body {
  margin: 0 !important;
}

@import "../../../assets/scss/now-ui-kit/mixins.scss";
</style>

