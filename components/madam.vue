<template>
    <div class="py-5 m-4">
      <div class="row d-flex justify-content-center">
        <div class="col-12 text-center">
          <h4 class="font-weight-bold mb-4">แม่บ้าน</h4>
        </div>
      </div>
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-12 col-md-3 col-lg-3 my-2" v-for="(item,index) in listMadam" :key="index">
            <div class="card shadow py-4 px-2">
              <div class="text-center h-200">
                <img :src="item.img" width="120" alt="maid">
                  <div class="text-center border-bottom py-2 font-weight-bold numbers">{{ item.name }}</div>
                <div class="iconBx text-center mt-2">
                    <ion-icon name="eye-outline"></ion-icon>
                    <button class="btn btn-primary rounded-xl" @click="pacKage(item.id)">เลือกแม่บ้าน</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 text-center my-5">
            <nuxt-link to="madam" class="btn border px-5 rounded-2">ดูเพิ่ม</nuxt-link>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
        return {
            listMadam: [
              {'id':1,'img':'../assets/images/maid.png','name':'นริษา นามดี', },
              {'id':2,'img':'../assets/images/maid.png','name':'เรวดี สลากุล', },
              {'id':3,'img':'../assets/images/maid.png','name':'เนาวรัตน์ ยุโต', },
              {'id':4,'img':'../assets/images/maid.png','name':'สมจิต ใจดี', }
            ],
            apiBase : import.meta.env.VITE_AGENT_BASE_URL
        };
    },
    methods:{
      pacKage: async function (id) {
        console.log('id',id);
      }
    }
  }
  </script>
  
  <style>
  
  </style>