<template>
  <div class="py-5 m-4">
    <div class="row d-flex justify-content-center">
      <div class="col-12 text-center">
        <h4 class="font-weight-bold mb-4">แม่บ้าน</h4>
      </div>
    </div>
    <div class="container">
      <div class="row d-flex justify-content-center">
          <div class="col-12 col-md-3 col-lg-3 my-2" v-for="(item, index) in dataMaids" :key="index">
            <div class="card shadow py-4 px-2">
              <div class="text-center h-200" style="cursor:pointer;" @click="openMaid(item)">
                <img v-if="item.img" :src="item.img" alt="maid" style="border-radius:50%; width:120px;height:120px">
                <img v-else src="@/public/assets/images/maid.png" width="120" alt="maid">
                
                <!-- <img :src="item.img" width="120" alt="maid"> -->
                <div class="text-center border-bottom py-2 font-weight-bold numbers">{{ item.fname + ' ' + item.lname }}
                </div>
                <div class="iconBx text-center mt-2 pe-4">
                  <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-star-fill text-warning" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg> {{ item.score }}
                  </p>
                  <p>

                  </p>
                  <p></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 text-center my-5">
            <nuxt-link to="madam" class="btn border px-5 rounded-2">ดูเพิ่ม</nuxt-link>
          </div>
        </div>
    </div>
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
                </div>
                <div class="col-6">
                  <img v-if="dataMaidShow.img" :src="dataMaidShow.img" class="w-100" alt="maid">
                  <img v-else src="@/public/assets/images/maid.png" class="w-100" alt="maid">
                </div>
              </div>

            </div>
          </div>
          <div class="px-4 py-2 border-top">
            <!-- <button type="button" class="btn btn-secondary" @click="isModal = false">ปิด</button> -->
            <p class="d-flex justify-content-between text-left"><b>รีวิว</b>   
            <button class="btn btn-sm btn-info" v-if="isReview" @click="isReview=false">
              เอาไว้ภายหลัง
            </button>
            </p>
            <div v-if="isReview" class="mt-2">
              <div class="row">
                <div class="col-6">
                  <div class="d-flex justify-content-start my-2">
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
                <div class="col-6 pt-2">ให้คะแนนดาว</div>
                <div class="col-12">
                  <label for="" class="text-muted">แสดงความคิดเห็น</label>
                  <textarea name="" id="" cols="30" rows="4"  class="form-control" placeholder=". . . ."></textarea>
                </div>
                <div class="col-12 text-right mt-2">
                  <button class="btn btn-danger">
                    ให้คะแนน
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 bg-light my-2">
                 
                <div class="d-flex justify-content-between my-2">
                  <div>
                    <img src="@/public/assets/images/customer01.jpg" class="avatar avatar-sm me-2" alt="customer">
                    ความคิเห็นของลูกค้า
                  </div>
                    <p>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-star-fill text-warning mx-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
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
      isModal:false,
      dataMaidShow:'',
      dataMaids:'',
      dataMaidsForSearch:'',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  mounted(){
    this.getMaid();
  },
  methods: {
    openMaid(item) {
      this.isModal = true;
      this.dataMaidShow = item;
    },
    pacKage: async function (id) {
      console.log('id', id);
    },
    getMaid: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/maids/8",
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
  }
}
</script>
  
<style></style>