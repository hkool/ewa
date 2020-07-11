<template>
  <div>
    <div class="page-header clear-filter">
      <div>
        <img
          class="img-responsive"
          style="width:90%; position: absolute; left: 5%; bottom:25%"
          src="images/EWAHaaglanden_logo.jpg"
          alt="Ewa Haaglanden logo"
        />
      </div>
    </div>

    <div class="container text-center" style="margin-bottom:5%">
      <div class="row justify-content-md-center">
        <div class="col-md-12 col-lg-8">
          <h5
            class="description"
            style="color:black;text-align:left;"
          >Ewa Haaglanden is een samenwerkingsverband tussen bedrijven, gemeenten, ROC Mondriaan en maatschappelijke partijen in de regio Haaglanden. Wij leiden jonge mensen op naar een diploma en een fijne werkplek. Wij leiden werknemers verder op. En we brengen kandidaten met relevante scholing dichter bij een baan en participatie. </h5>
        </div>
      </div>
    </div>

    <VideoSection></VideoSection>
    <NewsSection></NewsSection>
    <ContactUsSection></ContactUsSection>
    <PartnerSection></PartnerSection>
  </div>
</template>
<script>
import VideoSection from "../pages/components/Index/VideoSection";
import PartnerSection from "../pages/components/Index/PartnerSection";
import NewsSection from "../pages/components/Index/NewsSection";
import ContactUsSection from "../pages/components/Index/ContactUsSection";

export default {
  name: "index",
  bodyClass: "index-page",
  components: {
    VideoSection,
    NewsSection,
    PartnerSection,
    ContactUsSection,
  }
};
</script>
<style>

</style>
