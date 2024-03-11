<template>
  <footer class="text-center text-lg-start text-white" style="background-color: #929fba">
    <!-- Grid container -->
    <div class="container p-4 pb-0">
      <!-- Section: Links -->
      <section class="">
        <!--Grid row-->
        <div class="row">
          <!-- Grid column -->
          <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold border-bottom">
              เกียวกับเรา
            </h6>
            <p>
              บริษัท...
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold border-bottom">บริการ</h6>
            
            <p>
              <a class="text-white">พนักงานแม่บ้าน</a>
            </p>
          </div>
          <!-- Grid column -->

          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <hr class="w-100 clearfix d-md-none" />

          <!-- Grid column -->
          <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
            <h6 class="text-uppercase mb-4 font-weight-bold border-bottom">ติดต่อเรา</h6>
            <p><i class="fa fa-home mr-3"></i> New York, NY 10012, US
            <i class="fa fa-envelope mr-3"></i> info@gmail.com
            <i class="fa fa-phone mr-3"></i> + 01 234 567 88
            <i class="fa fa-print mr-3"></i> + 01 234 567 89</p>
          </div>
          <!-- Grid column -->

          <!-- Grid column -->
          <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3 d-block">
            <h6 class="text-uppercase mb-4 font-weight-bold border-bottom">Follow us</h6>

            <!-- Facebook -->
            <a class="btn btn-primary btn-floating m-1" style="background-color: #3b5998" href="#!" role="button"><i
                class="fab fa-facebook-f"></i></a>

            <!-- Twitter -->
            <a class="btn btn-primary btn-floating m-1" style="background-color: #55acee" href="#!" role="button"><i
                class="fab fa-twitter"></i></a>

            <!-- Google -->
            <a class="btn btn-primary btn-floating m-1" style="background-color: #dd4b39" href="#!" role="button"><i
                class="fab fa-google"></i></a>

            <!-- Instagram -->
            <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac" href="#!" role="button"><i
                class="fab fa-instagram"></i></a>

            <!-- Linkedin -->
            <a class="btn btn-primary btn-floating m-1" style="background-color: #0082ca" href="#!" role="button"><i
                class="fab fa-linkedin-in"></i></a>
            <!-- Github -->
            <a class="btn btn-primary btn-floating m-1" style="background-color: #333333" href="#!" role="button"><i
                class="fab fa-github"></i></a>
          </div>
        </div>
        <!--Grid row-->
      </section>
      <!-- Section: Links -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3 bg-danger">
      © 2024 Reserviced by 
      <a class="text-white" href="/">Madamclean.com</a>
      
    </div>
    <!-- Copyright -->
  </footer>
</template>
<script>
export default {
  data() {
    return {
      isSelect: false
    }
  },
  methods: {
    getToggle() {
      if (this.isSelect == false) {
        this.isSelect = true;
      } else {
        this.isSelect = false;
      }

    }
  }
}
</script>
<style>
.text-small {
  font-size: 12px;
}

.bg-footer {
  background: #F8F8F8 0% 0% no-repeat padding-box;
}

.text-policy {
  border-top: 2px #ccc dashed;
  border-bottom: 2px #ccc dashed;
  width: 92%;
}

.arrow.fa.fa-down {
  background-image: url(/images/chevron-down.svg);
  width: 16px;
  background-position: center;
  background-size: 100%;
  height: 23px;
  float: right;
}

.arrow.fa.fa-up {
  background-image: url(/images/chevron-up.svg);
  width: 16px;
  background-position: center;
  background-size: 100%;
  height: 23px;
  float: right;
}
</style>