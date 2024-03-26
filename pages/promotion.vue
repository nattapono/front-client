<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">
      <div class="col-12 my-4 pb-2"></div>
      <div class="col-12 col-lg-10 col-sm-10 ">
        <h4 class="mx-4 mx-md-0">โปรโมชั่น</h4>
        <div class="row  mt-2">
          <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-4 col-lg-3 my-2" v-for="(item, index) in dataPromotion" :key="index">
              <div class="card shadow py-4 px-2">
                <div class="text-center h-200">
                  <img :src="item.imageUrl" alt="No Image" :title="'Promotion '+item.name" class="text-muted"  style="height:120px">
                  <!-- <img :src="item.img" width="120" alt="maid"> -->
                  <div class="text-center border-bottom py-2 font-weight-bold numbers">{{ item.name }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- modal -->
      <div v-if="openLocation" class="modal fade show d-block bg-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content rounded-2">
            <div class="modal-header text-white bg-danger py-2 ">
              <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h6>
              <button type="button" class="close text-white btn text-xl" @click="openLocation = false"
                style="font-size: 33px;line-height: 0;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="openLocation = false">ปิด</button>
              <button type="button" class="btn btn-primary" v-if="isRegister" @click="handleRegister()">{{ textTitle
                }}</button>
              <button type="button" class="btn btn-primary" v-else @click="handleLogin()">{{ textTitle }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      isLogin: true,
      dateNow: new Date().toISOString().substr(0, 10),
      dataMount: [
        { "name": "ม.ค." },
        { "name": "ก.พ." },
        { "name": "มี.ค." },
        { "name": "เม.ย." },
        { "name": "พ.ค." },
        { "name": "มิ.ย." },
        { "name": "ก.ค." },
        { "name": "ส.ค." },
        { "name": "ก.ย." },
        { "name": "ต.ค." },
        { "name": "พ.ย." },
        { "name": "ธ.ค." },
      ],
      selectedDate: new Date(),
      formattedDate: '',
      openLocation: false,
      dataPromotion: '',
      dataPromotionForSearch: '',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    }
  },

  watch: {

  },
  mounted() {

    const currentDate = new Date();
    this.getPromotion();
    // ดึงค่าเดือนปัจจุบัน
    const currentMonth = currentDate.getMonth();

    // เก็บค่าเดือนปัจจุบันลงในข้อมูลของ Vue
    this.currentMonth = currentMonth;
  },
  methods: {
    pinLocation() {
      this.openLocation = true;
    },
    getPromotion: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/promotion",
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataPromotion = response.data;
            this.dataPromotionForSearch = response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
  }
}
</script>

<style>
.vuejs-datepicker {
  font-family: 'Tahoma', sans-serif;
}

.text-right {
  text-align: right;
}
</style>