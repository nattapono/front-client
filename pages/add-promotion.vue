<template>
    <div>
        <div class="row mb-5 d-flex align-items-center justify-content-center">
            <div class="col-12">
                <div class="card">
                    <h6 class="header-pretitle">Overview</h6>
                    <div class="card-header">
                        <h1 class="card-header-title">เพิ่มข้อมูลโปรโมชัน</h1>
                        <nuxt-link to="promotion" class="btn btn-sm btn btn-primary">
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
                                    <label for="">ชื่อโปรโมชั่น</label>
                                    <input type="text" name="" id="" v-model="pkName" class="form-control"
                                        placeholder="กรอกชื่อโปรโมชัน">
                                </div>
                            </div>
                        </div>
                        <div class="row" v-for="(row, i) in pkItem" :key="i">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ส่วนลด</label>
                                    <input type="text" name="" id=""
                                        oninput="this.value = this.value.replace(/[^0-9_ ]/g, '');" v-model="amount"
                                        class="form-control" placeholder="จำนวนชัวโมง">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
                                <div class="form-group w-100">
                                    <label for="">หน่วยนับ</label>
                                    <select name="" id="" v-model="unit" class="form-control w-100">
                                        <option value="บาท">บาท</option>
                                        <option value="percent">%</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <input type="file" @change="handleFileUpload">
                                <div v-if="imageUrl">
                                    <img :src="imageUrl" alt="Uploaded Image" width="200">
                                </div>
                            </div>
                            <div class="col-12 d-flex align-items-center justify-content-center">
                                <div class="form-group w-100">
                                    <label for="">รายละเอียด</label>
                                    <textarea name="" id="" cols="30" rows="4" class="form-control"
                                        placeholder="รายละเอียด" v-model="description"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button class="btn btn-danger w-100" @click="savePromotion">บันทึกข้อมูล</button>
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
                        <button type="button" class="btn btn-primary" v-else @click="handleLogin()">{{ textTitle
                            }}</button>
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
                { "hour": 1, "amount": 0 },
            ],
            pkName: '',
            description: '',
            amount: '',
            unit: '',
            selectedDate: new Date(),
            formattedDate: '',
            openLocation: false,
            imageUrl: '',
            imageData: '',
            apiBase: import.meta.env.VITE_AGENT_BASE_URL
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
        handleFileUpload(event) {


            const file = event.target.files[0];
            this.imageUrl = URL.createObjectURL(file);

            const reader = new FileReader();
            let base64Image = ''; // เริ่มต้นด้วยค่าว่าง
            reader.onload = (e) => {
                base64Image = e.target.result;
                this.imageData = base64Image; // กำหนดค่า this.imageData ภายใน onload
            };
            reader.readAsDataURL(file);
        },
        pinLocation() {
            this.openLocation = true;
        },
        addItemPk() {
            this.pkItem.push({ "hour": 1, "amount": 0 });
        },
        delItemPk(index) {
            if (this.pkItem.length > 1) {
                this.pkItem.splice(index, 1);
            }

        },
        savePromotion: async function () {
            if(this.pkName==''){
                swal({
                    position: "top-center",
                    icon: "error",
                    title: 'กรอกชื่อโปรโมชั่น',
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }
            if(this.amount==''){
                swal({
                    position: "top-center",
                    icon: "error",
                    title: 'กรุณาตั้งจำนวนส่วนลด',
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }
            if(this.unit==''){
                swal({
                    position: "top-center",
                    icon: "error",
                    title: 'กรุณาเลือกหน่วยนับ',
                    showConfirmButton: false,
                    timer: 1500
                });
                return false;
            }
            try {
                let config = {
                    method: "post",
                    url: this.apiBase + "/promotion",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data: {
                        'name': this.pkName,
                        'amount': parseFloat(this.amount),
                        'unit': this.unit,
                        'description': this.description,
                        'imageUrl': this.imageData
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
                                // window.location.reload();
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