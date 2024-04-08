<template>
    <div class="bn-heard">
        <!-- <img src="../assets/images/branner.png" class="w-100" alt=""> -->
        <img :src="dataPromotion.imageUrl" class="w-100" alt="">
        
    </div>
</template>

<script>
import axios from 'axios';
export default {
    
    data() {
    return {
      isLogin: true,
      dataPromotion:'',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    }
  },
  mounted() {
    this.goPromotion();
  },
  methods: {
    goPromotion: async function () {
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
            this.dataPromotion = response.data[0];
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
<style scoped>
.bn-heard{
    width: 100%;
}
#description-promotion{
    background:rgba(0,0,0,0.4);position:absolute;bottom:0px;height:auto;
}
</style>