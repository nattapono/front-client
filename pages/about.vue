<template>
  <div>
    <div class="row mb-5 mx-4 d-flex align-items-center justify-content-center">
        <div class="col-12 my-4 pb-2"></div>
        <div class="col-12 col-lg-8 col-sm-10 ">
          <h4>เกี่ยวกับเรา</h4>      
          <div class="row  mt-2">
            <div class="card my-2" v-for="(rows,i) in dataAbuts"  :key="i">
                <div>{{ rows.about_name }}</div>
                <div class="row" v-if="rows.about_img">
                  <div class="col-12 col-md-6 ">
                    <img :src="rows.about_img" :alt="'ภาพ'+rows.about_name" class="w-100 my-2 p-3  border rounded">
                  </div>
                </div>
                
              <div class="mt-2" v-html="rows.dataDescription"></div>
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
      isLogin:true,
      formattedDate: '',
      dataAbuts: '',
      openLocation:false,
      apiBase: import.meta.env.VITE_AGENT_BASE_URL,
    }
  },

  watch: {
    
  },
  mounted() {
    this.getAbout();
  },
  methods: {
    getAbout:async function(){
      try {
          let config = {
            method: "get",
            url: this.apiBase + "/about",
            headers: {
              "Content-Type": "application/json",
            },
          };

          await axios
            .request(config)
            .then((response) => {
                this.dataAbuts  = response.data;               
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