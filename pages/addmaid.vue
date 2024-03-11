<template>
    <div>
        <div class="row mb-5 d-flex align-items-center justify-content-center">
            <div class="col-12">
                <div class="card">
                    <h6 class="header-pretitle">Overview</h6>
                    <div class="card-header">
                        <h1 class="card-header-title">เพิ่มข้อมูลแม่บ้าน</h1>
                        <nuxt-link to="maid" class="btn btn-sm btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                            </svg>
                            กลับ</nuxt-link>


                    </div>
                    <div class="justify-content-end">

                        <label for="">ลิ้งค์สมัคร</label>
                        <div class="form-group w-50 d-flex align-content-center justify-content-end">
                            <input type="text" class="form-control" value="http://localhost:3001/maid-register">
                            <button class="btn btn-md">
                                คัดลอก
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row f-flex align-items-center justify-content-center">
                    <div class="col-12 col-md-6 card">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ชื่อ</label>
                                    <input type="text" name="" id="" v-model="fname" class="form-control"
                                        placeholder="กรอกชื่อ">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">นามสกุล</label>
                                    <input type="text" name="" id="" v-model="lname" class="form-control"
                                        placeholder="กรอกนามสกุล">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">อีเมล์</label>
                                    <input type="text" name="" id="" v-model="lname" class="form-control"
                                        placeholder="กรอกอีเมล์">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ตั้งรหัสผ่าน</label>
                                    <input type="text" name="" id="" v-model="lname" class="form-control"
                                        placeholder="กรอกรหัสผ่าน">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ที่อยู่</label>
                                    <input type="text" name="" id="" v-model="lname" class="form-control"
                                        placeholder="กรอกที่อยู่">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ระบุตำเหน่ง</label>
                                    <div class="d-flex justify-content-between">
                                        <input type="text" name="" id="" v-model="lname" class="form-control me-2"
                                            placeholder="กรอกที่อยู่">
                                        <button class="btn btn-sm border" @click="openLo()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="coll-12">
                                <button class="btn btn-danger w-100">บันทึกข้อมูล</button>
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
export default {
    data() {
        return {
            isLogin: true,
            dateNow: new Date().toISOString().substr(0, 10),
            dataMount: [
                { "name": "ม.ค." },
                { "name": "ก.พ." },
                { "name": "มี.ค." },
                { "name": "เม.ย." },
                { "name": "พ.ค." },
                { "name": "มิ.ย." },
                { "name": "ก.ค." },
                { "name": "ส.ค." },
                { "name": "ก.ย." },
                { "name": "ต.ค." },
                { "name": "พ.ย." },
                { "name": "ธ.ค." },
            ],
            selectedDate: new Date(),
            formattedDate: '',
            openLocation: false
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
        openLo: async function () {
            this.openLocation = true;
            try {
                let config = {
                    method: "post",
                    url: " https://maps.googleapis.com/$rpc/google.internal.maps.mapsjs.v1.MapsJsInternalService/GetViewportInfo",
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.dataCustomers = response.data;
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