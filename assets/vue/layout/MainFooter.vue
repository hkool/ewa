<template>
  <footer class="footer" :data-background-color="backgroundColor">
    <div class="footer-copyright text-center py-3" style>
      <div class="container" style="text-align: center;">
        &copy; {{ year }}. Ontworpen en gemaakt door student van
        <a
          href="https://www.rocmondriaan.nl"
          target="_blank"
          rel="noopener"
        >ROC Mondriaan Michael Schaap</a>.
      </div>
    </div>
  </footer>
</template>
<script>
export default {
  props: {
    backgroundColor: String,
    type: String
  },
  data() {
    return {
      year: new Date().getFullYear()
    };
  }
};
</script>

<style lang="scss" scoped>
p {
  line-height: 1.4;
  text-transform: lowercase;
}
p::first-letter {
  text-transform: capitalize;
}

li {
  list-style-type: none;
}
a {
  padding: 0px;
}
</style>

