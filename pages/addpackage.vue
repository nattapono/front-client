<template>
    <div>
        <div class="row mb-5 d-flex align-items-center justify-content-center">
            <div class="col-12">
                <div class="card">
                    <h6 class="header-pretitle">Overview</h6>
                    <div class="card-header">
                        <h1 class="card-header-title">เพิ่มข้อมูลแพ็คเกจ</h1>
                        <nuxt-link to="package" class="btn btn-sm btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                            </svg>
                            กลับ</nuxt-link>
                    </div>

                </div>
                <div class="row d-flex align-items-center justify-content-center">
                    <div class="col-12 col-md-6 card">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ชื่อแพ็คเกจ</label>
                                    <input type="text" name="" id="" v-model="pkName" class="form-control"
                                        placeholder="กรอกชื่อแพ็คเกจ">
                                </div>
                            </div>
                        </div>
                        <div class="row" v-for="(row, i) in pkItem" :key="i">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ชั่วโมง</label>
                                    <input type="text" name="" id="" oninput="this.value = this.value.replace(/[^0-9_ ]/g, '');" v-model="row.hour" class="form-control"
                                        placeholder="จำนวนชัวโมง">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="form-group">
                                    <label for="">ราคา</label>
                                    <input type="text" name="" id="" oninput="this.value = this.value.replace(/[^0-9_]/g, '');" v-model="row.amount" class="form-control"
                                        placeholder="จำนวนราคา">
                                </div>
                                <button class="btn btn-danger btn-sm py-2 px-3 ms-2" @click="delItemPk(i)" v-if="i>0">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-outline-danger btn-sm py-2 px-3 ms-2" @click="addItemPk">เพิ่มชั่วโมง</button>
                        <div class="row mt-4">
                            <div class="col-12">
                                <button class="btn btn-danger w-100" @click="saveItemPk">บันทึกข้อมูล</button>
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
                        <button type="button" class="btn btn-primary" v-if="isRegister" @click="handleRegister()">{{
                            textTitle
                        }}</button>
                        <button type="button" class="btn btn-primary" v-else @click="handleLogin()">{{ textTitle }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import axios from 'axios';
import swal from 'sweetalert';

export default {
    data() {
        return {
            isLogin: true,
            dateNow: new Date().toISOString().substr(0, 10),
            pkItem: [
                { "hour":1, "amount": 0 },
            ],
            pkName:'',
            selectedDate: new Date(),
            formattedDate: '',
            openLocation: false,
            apiBase : import.meta.env.VITE_AGENT_BASE_URL
        }
    },

    watch: {

    },
    mounted() {

        const currentDate = new Date();

        // ดึงค่าเดือนปัจจุบัน
        const currentMonth = currentDate.getMonth();

        // เก็บค่าเดือนปัจจุบันลงในข้อมูลของ Vue
        this.currentMonth = currentMonth;
    },
    methods: {
        pinLocation() {
            this.openLocation = true;
        },
        addItemPk() {
            this.pkItem.push({ "hour": 1, "amount": 0 });
        },
        delItemPk(index) {
            if (this.pkItem.length>1) {
                this.pkItem.splice(index, 1);
            }

        }
        ,
        saveItemPk:async function (){
            try {
          let config = {
            method: "post",
            url: this.apiBase + "/packages",
            headers: {
              "Content-Type": "application/json",
            },
            data:{
                'name': this.pkName,
                'dataItem': this.pkItem,
            },
          };

          await axios
            .request(config)
            .then((response) => {
              if (response.data.success) {
                swal({
                  position: "top-center",
                  icon: "success",
                  title: response.data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                setTimeout(() => {
                  window.location.reload();
                }, 1500);
              }
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
</style>