<template>
  <div class="container">
    <div class="py-5 m-4 vh-100" v-if="dataMaids.length == 0 || !dataMaids">
      <div class="col-12 text-center my-5">
        ข้อมูลแม่บ้าน
      </div>
    </div>
    <div class="py-5 m-4"  v-else>
      <div class="row d-flex justify-content-center">
        <div class="col-12 text-center">
          <h4 class="font-weight-bold mb-4">แม่บ้าน</h4>
        </div>
      </div>
      <div class="container">
        <div class="row d-flex justify-content-start">
          <div class="col-12 col-md-4 col-lg-3 my-2" v-for="(item, index) in dataMaids" :key="index">
            <div class="card shadow py-4 px-0 pt-0 rounded-2">
              <div class="cut-text" style="background-size:cover;background-image:url(../assets/images/header-maid.png);height:89px;">
                <!-- <div class="tex-white text-small px-2 pt-3" style="color: #fff;background: rgba(0, 0, 0, 0.2);" v-if="item.myDesc">{{ item.myDesc }}{{ item.myDesc }}</div> -->
              </div>
              <div class="text-center h-200 p-2" style="cursor:pointer;" @click="openMaid(item)">
                <div class="d-flex justify-content-center">
                  <div v-if="item.img" :style="`border-radius:50%; width:120px;height:120px;background-image:url(${item.img});background-position: center;background-size: cover;`">
                  </div>
                  <img v-else src="@/public/assets/images/maid.png" width="120" alt="maid">
                </div>
                
                <!-- <img :src="item.img" width="120" alt="maid"> -->
                <div class="text-center border-bottom py-2 font-weight-bold numbers">{{ item.maidTitle+item.fname + ' ' + item.lname }}
                </div>
                <div class="d-flex align-items-center justify-content-between mt-2">
                  <button class="btn btn-outline-info px-1 py-0 text-small rounded-3 font-weight-200 d-flex align-items-center" style="font-weight: 100; font-size: 9px;height: 15px;">
                    <b style="font-weight: 900;">covid-19</b>
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="28" fill="currentColor" class="bi bi-shield-fill-check text-info" viewBox="0 0 16 16"><path d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793z" fill-rule="evenodd" style="
                      position: absolute;
                  "></path></svg> Vaccine </button>
                
                  <div class=" text-center d-flex align-items-center justify-content-end">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg> 
                    <span class="ms-2" v-if="item.totalStar">{{ item.totalStar }}</span>
                    <span class="ms-2" v-else>0</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 text-center my-5">
            <button class="btn btn-outline-info border px-5 rounded-2" :disabled="disableAddButton" @click="addLink()">ดูเพิ่ม</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div v-if="isModal" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h6>
            <button type="button" class="close text-white btn text-xl" @click="isModal = false"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>
              <div class="d-flex justify-content-between">
                <h2>{{ dataMaidShow.fname + ' ' + dataMaidShow.lname }}
                </h2>
                <div class="d-flex justify-content-center text-center w-50">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                    <path
                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                    <path
                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                    <path
                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                    <path
                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                    <path
                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                </div>
              </div>


              <div class="row">
                <div class="col-6">
                  <p><b>ที่อยู่:</b> {{ dataMaidShow.address }}</p>
                  <p><b>รูปแบบงาน:</b></p>
                  <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-check-circle-fill text-success mx-1" viewBox="0 0 16 16">
                      <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg> ทำความสะอาด</p>

                  <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-check-circle-fill text-success mx-1" viewBox="0 0 16 16">
                      <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    รีดผ้า
                  </p>
                  <p>

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-check-circle-fill text-success mx-1" viewBox="0 0 16 16">
                      <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                    นำอุปกรณ์ได้
                  </p>
                  <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-translate text-success mx-1" viewBox="0 0 16 16">
                      <path
                        d="M4.545 6.714 4.11 8H3l1.862-5h1.284L8 8H6.833l-.435-1.286zm1.634-.736L5.5 3.956h-.049l-.679 2.022z" />
                      <path
                        d="M0 2a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v3h3a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-3H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zm7.138 9.995q.289.451.63.846c-.748.575-1.673 1.001-2.768 1.292.178.217.451.635.555.867 1.125-.359 2.08-.844 2.886-1.494.777.665 1.739 1.165 2.93 1.472.133-.254.414-.673.629-.89-1.125-.253-2.057-.694-2.82-1.284.681-.747 1.222-1.651 1.621-2.757H14V8h-3v1.047h.765c-.318.844-.74 1.546-1.272 2.13a6 6 0 0 1-.415-.492 2 2 0 0 1-.94.31" />
                    </svg>
                    ภาษา: <span class="text-primary">TH</span>
                  </p>
                  <button class="btn btn-outline-info px-1 py-0 text-small rounded-3 font-weight-200 d-flex align-items-center" style="font-weight: 100; font-size: 9px;height: 15px;">
                    <b style="font-weight: 900;">covid-19</b>
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="28" fill="currentColor" class="bi bi-shield-fill-check text-info" viewBox="0 0 16 16"><path d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793z" fill-rule="evenodd" style="
                      position: absolute;
                  "></path></svg> Vaccine </button>
                </div>
                <div class="col-6">
                  <img v-if="dataMaidShow.img" :src="dataMaidShow.img" class="w-100" alt="maid">
                  <img v-else src="@/public/assets/images/maid.png" class="w-100" alt="maid">
                </div>
                <div class="col-12 mt-2">
                  <div class="tex-white text-small" v-if="dataMaidShow.myDesc">{{ dataMaidShow.myDesc }}</div>
                </div>
              </div>
            </div>
          </div>
          <div class="px-4 py-2 border-top">
            <!-- <button type="button" class="btn btn-secondary" @click="isModal = false">ปิด</button> -->
            <p class="d-flex justify-content-between text-left"><b>รีวิว</b></p>
            
            <div class="row">
              <div class="col-12 bg-light my-2  px-0">
                <div class="justify-content-between my-2 px-2" v-for="(item,i) in dataMaidShow.dataComment" :key="i" :class="{ 'bg-light': i % 2 !== 0, 'bg-white': i % 2 === 0 ,'d-flex': i<4}">
                  <div class="d-flex justify-content-start align-items-center">
                    <div v-if="item.member_fname">
                      <div class="user ms-2 border text-center text-white bg-danger text-uppercase me-2 d-flex align-items-center justify-content-center" 
                      style="width: 40px;height: 40px;">
                      {{ shotName(item.member_fname) }}
                      </div>
                    </div>
                    <div v-else>
                      <img src="@/public/assets/images/customer01.jpg" class="avatar avatar-sm me-2" alt="customer">
                    </div>
                    <div style="min-width:240px">
                      {{item.message}}
                    </div>
                  </div>
                  <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" v-for="index in item.stars" :key="index"
                      class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                  </p>
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
      isModal: false,
      isReview: true,
      dataMaids: '',
      limitLength:12,
      dataMaidShow: '',
      dataMaidsForSearch: '',
      disableAddButton: false,
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  mounted() {
    this.getMaid();
  },
  methods: {
    pacKage: async function (id) {
      console.log('id', id);
    },
    addLink() {
      this.limitLength += 10;
      this.getMaid();
      this.disableAddButton = true; // ปิดใช้งานปุ่ม add
      setTimeout(() => {
        this.disableAddButton = false; // เปิดใช้งานปุ่ม add อีกครั้งหลังจากผ่านไปเวลาที่กำหนด
      }, 3400);
    },
    getMaid: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/maids-maid/"+this.limitLength,
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataMaids = response.data;
            this.dataMaidsForSearch = response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    shotName(name){
      let nn = name.charAt(0);

        if (nn == 'เ' || nn == 'โ' || nn == 'ไ' || nn == 'ใ') {
          return name.charAt(1);
        } else {
          return name.charAt(0);
        }
    },
    openMaid(item) {
      this.isModal = true;
      this.dataMaidShow = item;
    },
  }
}
</script>
  
<style>
.avatar-sm{
  width: 40px;
  height: 40px;
  border-radius:50%
}
.cut-text{
    width: 100%; /* กำหนดความกว้างของ div */
    overflow: hidden; /* ซ่อนข้อความที่เกินขอบเขตของ div */
    text-overflow: ellipsis; /* แสดง ... เมื่อข้อความเกินขอบเขต */
}
</style>