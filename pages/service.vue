<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">
        <div class="col-12 col-lg-10 col-sm-10 my-4 pb-2">  
          <div class="row d-flex justify-content-center">
            <div class="col-12">
              <h4 class="font-weight-bold">บริการของเรา</h4>
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-12">
              <div class="container">
                <div class="row d-flex justify-content-center">
                  <div class="col-12 my-2 d-block" v-for="(item, index) in dataPackages" :key="index">
                    <div class="package card px-0 pb-4">
                      <div class="px-0 h-200 ">
                        <div class="text-left pb-2 px-2 px-md-5 numbers text-primary px-0 border-bottom">
                          <b>{{ item.name }}</b> <button class="btn btn-primary btn-sm ms-3 rounded-2" @click="packageSelect(item)">เลือกบริการ</button>
                        </div>
                        <div class="row d-flex justify-content-start px-2 px-md-5 bg-gray-100 mx-0">
                          <div class="col-4 col-md-2 text-center m-0 m-md-2 border px-0 rounded-2"  v-for="(data, idx) in item.items" :key="idx">
                           <p class="bg-danger text-white"> {{ data.hour }} ชม.</p>
                            <p>{{ data.amount }} บาท</p>
                          </div>

                          <div class="col-12 bg-gray-200 m-0 pt-2">
                            <div class="text-muted px-3 pb-3" v-if="item.description" v-html="item.description"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
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
      window.location=window.location.origin+'/booking?_t='+Date.now();
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
  .vuejs-datepicker {
    font-family: 'Tahoma', sans-serif;
  }
  .text-right {
    text-align: right;
  }
  .bg-gray-100 {
    background-color: #f8f9fa !important;
}

.bg-gray-200 {
    background-color: #e9ecef !important;
}
</style>