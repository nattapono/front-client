<template>
    <div>
        <div class="row mb-5 d-flex align-items-center justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-header-title text-center">สมัครแม่บ้าน</h1>
                    </div>
                </div>
                <div class="row f-flex align-items-center justify-content-center">
                    <div class="col-12 col-md-6 card px-4">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ชื่อ</label>
                                    <input type="text" name="" id="" oninput="this.value = this.value.replace(/[0-9_ ]/g, '');" v-model="fname" class="form-control"
                                        placeholder="กรอกชื่อ">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">นามสกุล</label>
                                    <input type="text" name="" id="" oninput="this.value = this.value.replace(/[0-9_ ]/g, '');" v-model="lname" class="form-control"
                                        placeholder="กรอกนามสกุล">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">อีเมล์</label>
                                    <input type="text" name="" id="" v-model="email" class="form-control"
                                        placeholder="กรอกอีเมล์">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">เบอร์โทร</label>
                                    <input type="text" name="" id="" v-model="phone" class="form-control"
                                        placeholder="กรอกเบอร์โทร">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ตั้งรหัสผ่าน <small>(ใช้เข้าสู่ระบบ)</small></label>
                                    <input type="password" name="" id="" v-model="password" class="form-control"
                                        placeholder="กรอกรหัสผ่าน">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ที่อยู่</label>
                                    <input type="text" name="" id="" v-model="address" class="form-control"
                                        placeholder="กรอกที่อยู่">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">เลขบัตรประชาชน(13หลัก) *</label>
                                    <input type="text" name="" id="" maxlength="13" oninput="this.value = this.value.replace(/[^0-9_]/g, '');" v-model="ppCard" class="form-control"
                                        placeholder="กรอกเลขบัตรประชาชน">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">วัน/เดือน/ปี เกิด *</label>
                                    <input type="date" name="" id="" v-model="birthDay" class="form-control"
                                        placeholder="วันเกิด">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">สัญชาติไทย *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="thaiNationality" id="thaiNationalityYes"
                                            v-model="thaiNationality" class="form-check-input" value="1">
                                        <label class="form-check-label" for="thaiNationalityYes">ใช่</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="thaiNationality" id="thaiNationalityNo"
                                            v-model="thaiNationality" class="form-check-input" value="0">
                                        <label class="form-check-label" for="thaiNationalityNo">ไม่ใช่</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ประสบการณ์การทำงานแม่บ้าน *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience1Year" id="experience2Year"
                                            v-model="experience" class="form-check-input" value="2">
                                        <label class="form-check-label" for="experience1Year">2 ปี</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" id="experience3Years"
                                            v-model="experience" class="form-check-input" value="3">
                                        <label class="form-check-label" for="experience2Years">3 ปี</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" id="experience4Years"
                                            v-model="experience" class="form-check-input" value="4">
                                        <label class="form-check-label" for="experience2Years">4 ปี</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" id="experience5Years"
                                            v-model="experience" class="form-check-input" value="5">
                                        <label class="form-check-label" for="experience2Years">5 ปี</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" id="experience5Over"
                                            v-model="experience" class="form-check-input" value="6">
                                        <label class="form-check-label" for="experience2Years">มากกว่า 5 ปี</label>
                                    </div>
                                </div>


                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">เดินทางได้ในรัศมี 10 - 15 กม. (กทม. นนทบุรี สมุทรปราการ หรือปทุมธานี)
                                        *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience1Year" id="experience2Year" v-model="workIn"
                                            class="form-check-input" value="1">
                                        <label class="form-check-label" for="experience1Year">ได้</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience2Years" id="experience3Years"
                                            v-model="workIn" class="form-check-input" value="0">
                                        <label class="form-check-label" for="experience2Years">ไม่ได้</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ปัจจุบันทำงานกี่วัน/สัปดาห์ (กรณีมีงานทำ) *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience1Year" id="experience1Year"
                                            class="form-check-input" v-model="workOn" value="1">
                                        <label class="form-check-label" for="experience1Year">1 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience2Years" id="experience2Years"
                                            class="form-check-input" v-model="workOn"  value="2">
                                        <label class="form-check-label" for="experience2Years">2 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience3Years" id="experience3Years"
                                            class="form-check-input"  v-model="workOn"  value="3">
                                        <label class="form-check-label" for="experience3Years">3 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience4Years" id="experience4Years"
                                            class="form-check-input"  v-model="workOn" value="4">
                                        <label class="form-check-label" for="experience4Years">4 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience5Years" id="experience5Years"
                                            class="form-check-input" v-model="workOn"  value="5">
                                        <label class="form-check-label" for="experience5Years">5 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience6Years" id="experience6Years"
                                            class="form-check-input" v-model="workOn"  value="6">
                                        <label class="form-check-label" for="experience6Years">6 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="experience7Years" id="experience7Years"
                                            class="form-check-input" v-model="workOn"  value="7">
                                        <label class="form-check-label" for="experience7Years">7 วัน</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">สามารถทำงานกับเราได้กี่วัน/สัปดาห์ *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience2Year"
                                            class="form-check-input" v-model="workDays" value="1">
                                        <label class="form-check-label" for="experience1Year">1 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience2Years"
                                            class="form-check-input" v-model="workDays" value="2">
                                        <label class="form-check-label" for="experience2Years">2 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience3Years"
                                            class="form-check-input" v-model="workDays" value="3">
                                        <label class="form-check-label" for="experience3Years">3 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience4Years"
                                            class="form-check-input" v-model="workDays" value="4">
                                        <label class="form-check-label" for="experience4Years">4 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience5Years"
                                            class="form-check-input" v-model="workDays" value="5">
                                        <label class="form-check-label" for="experience5Years">5 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience6Years"
                                            class="form-check-input" v-model="workDays" value="6">
                                        <label class="form-check-label" for="experience6Years">6 วัน</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="" id="experience7Years"
                                            class="form-check-input" v-model="workDays" value="7">
                                        <label class="form-check-label" for="experience7Years">7 วัน</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">ยืนยันว่าไม่เคยมีประวัติอาชญากรรม *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="concentYes" id="concentYes" class="form-check-input"
                                           v-model="noCriminalHistory" value="1">
                                        <label class="form-check-label" for="concentYes">มี</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="concentNo" id="concentNo" class="form-check-input"
                                           v-model="noCriminalHistory" value="0">
                                        <label class="form-check-label" for="concentNo">ไม่มี</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">คุณยินยอมให้เปิดเผยข้อมูลส่วนบุคคลแก่บริษัทเพื่อใช้ประเมินการรับสมัครงาน
                                        *</label>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="lname" id="thaiNationalityYes" class="form-check-input"
                                            v-model="personalDataConsent" value="1">
                                        <label class="form-check-label" for="thaiNationalityYes">ยินยิม</label>
                                    </div>
                                    <div class="form-check mx-4">
                                        <input type="radio" name="lname" id="thaiNationalityNo" class="form-check-input"
                                            v-model="personalDataConsent" value="0">
                                        <label class="form-check-label" for="thaiNationalityNo">ไม่ยินยอม</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group  d-none">
                                    <label for="">ตำเหน่งของคุณ</label>
                                    <div class="d-flex justify-content-start">

                                        <p>Latitude: <span v-if="!latitude" class="text-muted mx-2">
                                                <small><i>กำลังค้นหา..</i></small></span> <span class="text-primary"
                                                v-else>{{ latitude }}</span></p>
                                        <p class=" mx-2"> Longitude: <span class="text-muted mx-2"
                                                v-if="!longitude"><small><i>กำลังค้นหา..</i></small></span> <span
                                                class="text-primary" v-else>{{ longitude }}</span></p>

                                        <!-- <input type="text" name="" id="" v-model="positionName" readonly class="form-control me-2 w-50"
                                            placeholder="ตำแหน่งจะปรากฏ">
                                        <button class="btn btn-sm border" @click="openLo()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </button> -->
                                    </div>
                                </div>
                            </div>
                            <div class="coll-12">
                                <button class="btn btn-danger w-100" disabled v-if="!latitude">รอสักครู่..</button>
                                <button class="btn btn-danger w-100" v-else @click="addMaid">บันทึกข้อมูล</button>
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
                        <h4 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h4>
                        <button type="button" class="close text-white btn text-xl" @click="openLocation = false"
                            style="font-size: 33px;line-height: 0;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7960469.022998579!2d101.490104!3d13.038996899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sth!2sth!4v1708937055208!5m2!1sth!2sth"
                                height="450" style="border:0;width:100%" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <div>
                            <p>Latitude: {{ latitude }}</p>
                            <p>Longitude: {{ longitude }}</p>
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

useHead({
    title: "สสส. | สำนักงานกองทุนสนับสนุนการสร้างเสริมสุขภาพ",
    meta: [
        {
            name: "description",
            content: "คอร์สเรียนออนไลน์ ง่ายๆ สำหรับคุณ"
        }
    ],
})
export default {
    data() {
        return {
            isLogin: true,
            dateNow: new Date().toISOString().substr(0, 10),
            fname: '',
            lname: '',
            email: '',
            phone: '',
            password: '',
            address: '',
            ppCard: '',
            birthDay: '',
            thaiNationality: '',
            experience:'',
            workIn: '',
            workOn:'',
            workDays: '',
            availableDays: '',
            noCriminalHistory: '',
            personalDataConsent: '',
            latitude: null,
            longitude: null,
            selectedDate: new Date(),
            formattedDate: '',
            openLocation: false,
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

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(this.successHandler, this.errorHandler);
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    },
    methods: {
        successHandler(position) {
            this.latitude = position.coords.latitude;
            this.longitude = position.coords.longitude;
        },
        errorHandler(error) {
            console.error("Error getting geolocation:", error.message);
        },
        addMaid: async function () {
            
            const data={
                fname:this.fname,
                lname:this.lname,
                email:this.email,
                pass:this.password,
                phone:this.phone,
                address:this.address,
                ppCard:this.ppCard,
                birthDay:this.birthDay,
                thaiNationality:this.thaiNationality,
                experience:this.experience,
                workIn:this.workIn,
                workOn:this.workOn,
                workDays:this.workDays,
                noCriminalHistory:this.noCriminalHistory,
                personalDataConsent:this.personalDataConsent,
                latitude:this.latitude,
                longitude:this.longitude
            };
            try {
                let config = {
                    method: "post",
                    url: this.apiBase + "/maid-register",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data:data
                };

                await axios
                    .request(config)
                    .then((response) => {
                        swal({
                            position: "top-center",
                            icon: "success",
                            title: 'สำเร็จ',
                            showConfirmButton: false,

                        });
                    })
                    .catch((error) => {
                        swal({
                            position: "top-center",
                            icon: "error",
                            title: error,
                            showConfirmButton: false,

                        });
                    });

            } catch (error) {
                console.error(error);
            }
        },
        openLo: async function () {
            this.textTitle = 'ระบุตำแหนง';
            this.openLocation = true;


            const mapDistanceCalculater = require('google-map-js');

            const data = await mapDistanceCalculater.DirectionsService(latitudeA, longitudeA, latitudeB, longitudeB, 'Google map api key', 'Travel mode');

            console.log('map', data);
            // try {
            //     let config = {
            //         method: "post",
            //         url: " https://maps.googleapis.com/$rpc/google.internal.maps.mapsjs.v1.MapsJsInternalService/GetViewportInfo",
            //         headers: {
            //             "Content-Type": "application/json",
            //         },
            //     };

            //     await axios
            //         .request(config)
            //         .then((response) => {
            //             this.dataCustomers = response.data;
            //         })
            //         .catch((error) => {
            //             console.log(error);
            //         });

            // } catch (error) {
            //     console.error(error);
            // }
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