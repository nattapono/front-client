<template>
  <div class=" m-4" id="package">
    <div class="row d-flex justify-content-center">
      <div class="col-12 text-center">
        <h4 class="font-weight-bold">บริการของเรา</h4>
      </div>
    </div>
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-md-4 col-lg-4 my-2 d-block " v-for="(item, index) in dataPackages" :key="index">
          <div class="package card p-2">
            <div class=" h-200">
              <div class="text-center border-bottom pb-2 font-weight-bold numbers">{{ item.name }}</div>
              <div class="row">
                <div class="col-6 text-center font-weight-bold">ชม.</div>
                <div class="col-6 text-center font-weight-bold">ราคา</div>
              </div>
              <div class="row p-2" v-for="(data, idx) in item.items" :key="idx">
                <div class="col-6 text-center">{{ data.hour }} ชม.</div>
                <div class="col-6 text-center">{{ data.amount }} บาท</div>
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
      listPackages: [
        {
          'id': 1, 'name': 'Package-1', 'type': [
            { 'hour': 2, 'amount': 500 },
            { 'hour': 3, 'amount': 700 },
            { 'hour': 4, 'amount': 900 },
            { 'hour': 5, 'amount': 1100 },
            { 'hour': 6, 'amount': 1200 },
            { 'hour': 7, 'amount': 1400 },
            { 'hour': 8, 'amount': 1600 },
          ]
        },
        {
          'id': 2, 'name': 'Package-2', 'type': [
            { 'hour': 3, 'amount': 0 },
            { 'hour': 4, 'amount': 0 },
            { 'hour': 6, 'amount': 0 },
          ]
        },
        {
          'id': 3, 'name': 'Big Cleaning', 'type': [
            { 'hour': 3, 'amount': 0 },
            { 'hour': 4, 'amount': 0 },
            { 'hour': 6, 'amount': 0 },
          ]
        }
      ],
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
      window.location = 'booking';
    },
    getPackage: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/packages",
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
}</style>