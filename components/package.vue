<template>
  <div class=" m-4" id="package">
    <div class="row d-flex justify-content-center">
      <div class="col-12 text-center">
        <h4 class="font-weight-bold">บริการของเรา</h4>
      </div>
    </div>
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-4 col-lg-3 my-2 d-block " v-for="(item, index) in dataPackages" :key="index">
          <div class="package card px-0 pb-4">
            <div class="px-0 h-200">
              <div class="text-center pb-2 numbers text-primary px-0">
                <b>{{ item.name }}</b>
              </div>
              <div class="row text-muted bg-gray-200 border-top border-bottom mx-0">
                <div class="col-6 text-center font-weight-bold">ชม.</div>
                <div class="col-6 text-center font-weight-bold">ราคา</div>
              </div>
              <div class="row p-2" v-for="(data, idx) in item.items" :key="idx">
                <div class="col-6 text-center">{{ data.hour }} ชม.</div>
                <div class="col-6 text-center">{{ data.amount }} บาท</div>
              </div>
              <div class="row p-2" v-if="item.items.length<3">
                <div class="col-6 text-center"> </div>
                <div class="col-6 text-center"> </div>
              </div>
              <div class="row p-2" v-if="item.items.length<4">
                <div class="col-6 text-center"> </div>
                <div class="col-6 text-center"> </div>
                <div class="col-6 text-center"> </div>
              </div>
              <div class="row p-2" v-if="item.items.length<5">
                <div class="col-6 text-center"> </div>
                <div class="col-6 text-center"> </div>
                <div class="col-6 text-center"> </div>
                <div class="col-6 text-center"> </div>
              </div>
              <div class="row p-2" v-if="item.items.length<6">
                <div class="col-6 text-center"></div>
                <div class="col-6 text-center"></div>
                <div class="col-6 text-center"></div>
                <div class="col-6 text-center"></div>
                <div class="col-6 text-center"></div>
              </div>
              <div class="iconBx text-center mt-4">
                <ion-icon name="eye-outline"></ion-icon>
                <button class="btn btn-primary rounded-2" @click="packageSelect(item)">เลือกบริการ</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from 'axios';
import { format } from 'date-fns';
import { th } from 'date-fns/locale';

export default {
  data() {
    return {
      dataPackages:'',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  mounted(){
    this.getPackage();
  },
  methods: {
    packageSelect: async function (item) {
      localStorage.setItem("bookingId", JSON.stringify(item.id));
      localStorage.setItem("hours-package", JSON.stringify(item));
      // window.location=window.location.origin+'/booking?_t='+Date.now();
    },
    getPackage: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/package",
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataPackages = response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>
  
<style>
.package {
  position: relative;
  left: 0;
  right: 0;
  bottom: 0;
  top: 0;
}
.bg-gray-200{
  background-color: #efefef
}
</style>
