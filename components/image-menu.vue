<template>
  <div class=" m-4" id="package">
    <div class="row d-flex justify-content-center">
      <div class="col-12 text-center">
        <h4 class="font-weight-bold">บริการของเรา</h4>
      </div>
    </div>
      <div class="row d-flex justify-content-center">
        <a href="/service" class="col-6 col-md-3 col-lg-3 my-2 d-block p-0 m-0" v-for="(item, index) in dataImage" :key="index">
            <img :src="item.imagUrl" alt="" class="w-100">
        </a>
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
      dataImage:'',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  mounted(){
    this.getImage();
  },
  methods: {

    getImage: async function () {
      try {
        let config = {
          method: "get",
          url:this.apiBase+'/showcases/2',
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataImage = response.data;
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
