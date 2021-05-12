<template>
  <section class="col-12 col-md-6 col-lg-4">
    <div class="border-0 shadow card h-100">
      <img :src="blog.image" class="card-img-top" alt="..." />

      <div class="card-body d-flex flex-column">
        <h6 class="card-title fw-bold lh-base">{{ blog.subject }}</h6>
        <p class="small">{{ blog.subtitle }}</p>
        <div class="mt-auto">
          <div class="star-rating">
            <i class="far fa-star"></i><i class="far fa-star"></i
            ><i class="far fa-star"></i><i class="far fa-star"></i
            ><i class="far fa-star"></i>
            <!-- (จำนวนคะแนน / 5ดาว) * 100 = % -->
            <div class="star-current" style="width: 90%">
              <i class="fas fa-star"></i><i class="fas fa-star"></i
              ><i class="fas fa-star"></i><i class="fas fa-star"></i
              ><i class="fas fa-star"></i>
            </div>
          </div>
          <small class="text-muted"> 4.5 (50) </small>
          <small class="float-end"> <i class="fas fa-eye"></i> 1,000</small>
          <a href="#" class="mt-2 w-100 btn btn-info font-weight-bold"
            >Read More <i class="fas fa-arrow-circle-right"></i
          ></a>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
module.exports = {
  props: ["blog"],
};
</script>
<style scoped>
p {
  background-color: #ffe;
}
</style>
