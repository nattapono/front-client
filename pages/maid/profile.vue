<template>
    <div class="row d-flex align-items-top justify-content-center vh-100">
        <div class="col-12 col-md-10 my-4">
            <div class="card mx-3">
                <div class="row d-flex align-items-top justify-content-start p-3">
                    <div class="col-12 col-md-4 p-2 text-center">
                        <div class="w-100 border rounded" v-if="maidProfile.img">
                            <img :src="maidProfile.img" width="100" alt="maid">
                        </div>
                        <div class="w-100 text-center  border rounded py-2" v-else>
                            <img src="@/public/assets/images/maid.png" width="100" alt="maid">
                        </div>
                        <input type="file" ref="upImg" class="d-none" @change="handleFileUpload">
                        <button class="btn btn-outline-danger btn-sm my-2 w-100" @click="uploadImage">อัพรูปโปรไฟล์</button>
                        <span class="text-success" v-if="uploadStatus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg>
                            อัพโหลดสำเร็จ
                        </span>
                    </div>
                    <div class="col-12 col-md-4">
                        <!-- ชื่อ : {{ maidProfile.fname }} {{ maidProfile.lname }} -->
                        <div v-if="edit">
                            <label for="">ธนาคาร</label>
                            <button class="btn border form-control" @click="listSt = true">
                                <div v-if="!maidProfile.bank_type" class="d-flex justify-content-start">
                                    เลือกธนาคาร</div>
                                <div v-for="(item, i) in bankData" :key="i" v-else>
                                    <div v-if="maidProfile.bank_type == item.id"
                                        class="d-flex align-items-center justify-content-start">
                                        <img :src="item.img" :alt="item.shortname"
                                            class="rounded me-2" width="35">
                                        <div class="text-dark pb-0"> ธนาคาร{{ item.name }}</div>
                                    </div>
                                </div>
                            </button>
                            <div class="border p-2" style="height:250px; overflow:scroll"
                                v-if="listSt == true">
                                <div v-for="(item, i) in bankData" :key="i">
                                    <div class="d-flex align-items-center justify-content-start my-2 list-show"
                                        @click="chooseBankEdit(item.id)">
                                        <img :src="item.img" :alt="item.shortname"
                                            class="rounded me-2" width="35">
                                        <div class="text-dark pb-0">ธนาคาร: {{ item.name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-content-center my-3">
                                <div class="w-50 me-2">
                                    <label for="">ชื่อบัญชี</label>
                                    <input type="text" class="form-control" placeholder="ชื่อ"
                                        v-model="maidProfile.fname">
                                </div>
                                <div class="w-50 me-2">
                                    <label for=""></label>
                                    <input type="text" class="form-control" placeholder="นามสกุล"
                                        v-model="maidProfile.lname">
                                </div>
                            </div>
                            <div class="d-flex align-content-center my-3">
                                <div class="w-100">
                                    <label for="">เลขที่บัญชี</label>
                                    <input type="text" class="form-control"
                                        v-model="maidProfile.bank_number">
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="!maidProfile.bank_type">
                                <p class="text-danger">กรุณาเพิ่มข้อมูลธนาคาร</p>
                            </div>
                            <div v-for="(item, i) in bankData" :key="i">
                                <div v-if="maidProfile.bank_type == item.id">
                                    <img :src="item.img" :alt="item.shortname" class="around"
                                        width="85">
                                    <p class="text-dark">ธนาคาร: {{ item.name }}</p>
                                </div>
                            </div>


                            ชื่อบัญชี: {{ maidProfile.fname }} {{ maidProfile.lname }}

                            <p>เลขที่บัญชี: {{ maidProfile.bank_number }}</p>
                        </div>
                        <div class="col-8"  v-if="!edit"> 
                            <button class="btn btn-primary" v-if="!maidProfile.bank_type" @click="editBank">เพิ่มข้อมูล</button>
                            <button class="btn btn-primary" v-else @click="editBank">แก้ไข</button>
                        </div>
                        <div class="col-8" v-else>
                            <button class="btn btn-danger me-2" @click="edit=false">ปิด</button>
                            <button class="btn btn-success" @click="saveEdit">แก้ไข</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 p-3">
                        <div class="border p-2 rounded-2">
                            <label for="">เปลี่ยนรหัสผ่าน</label>
                            <input readonly type="text" v-model="pass" class="form-control"   v-if="!edit">
                            <input type="text" v-model="pass" class="form-control"   v-else>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="card mx-3 my-3 ">
                <div class="row pb-5 d-flex align-items-center justify-content-center">
                    <div class="col-12 col-lg-10 col-md-10 px-4 px-md-0 d-none d-md-block">
                        <h4>ประวัติการจอง</h4>
                        <div class="table-responsive mt-2">
                        <table class="table rounded-4" style="min-height: 350px;">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ชื่อแม่บ้าน</th>
                                <th>บริการ</th>
                                <th>อาคาร</th>
                                <th>ที่อยู่</th>
                                <th>เวลาที่จอง</th>
                                <th>สลิป</th>
                                <th>สถานะ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="7" v-if="dataHistory.length == 0" class="text-center py-5 text-muted">
                                <div class="py-4 mb-5">
                                    - No Data -
                                </div>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-for="(booking, i) in dataHistory.listWork" :key="booking.bookId" >
                            <tr v-if="i>= start && i < (limit)">
                                <td>{{ i + 1 }}</td>
                                <td>{{ booking.fname }} {{ booking.lname }}</td>
                                <td>{{ booking.hasClean }}</td>
                                <td>{{ booking.workBuilding }}</td>
                                <td style="width:300px" class="small text-muted">{{ booking.showAddress }}</td>
                                <td class="text-primary">วันที่:{{ formatDateThai(booking.dateSelect) }} <small
                                    class="text-muted">เวลา:</small>{{ booking.startTime }}
                                </td>
                                <td>
                                <button class="btn btn-outline-info" @click="openSlip(booking)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />
                                    </svg>
                                </button>
                                </td>
                                <td>
                                <div v-if="booking.isActive == 2" class="text-warning text-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-hourglass-split" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                                    </svg> รอชำระเงิน
                                </div>
                                <div v-if="booking.isActive>2" class="text-success text-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-check2-circle" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                    <path
                                        d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                    </svg> ชำระแล้ว
                                </div>
                                <div v-if="booking.receipt" class="d-none"><img :src="booking.receipt" alt="" width="80"></div>
                                <p v-if="booking.isActive == 2">
                                    <button class="btn btn-sm btn-outline-info py-0" @click="toPay">ชำระเงิน</button>
                                </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </div>
                        <div class="text-right d-flex justify-content-between " id="slide-page">
                            <div class="text-left" id="str-lmt">
                            หน้า {{ dataStrLmt + 1 }}
                            </div>
                            <ul class="pagination pagination-rounded justify-content-end mb-2">
                            <li class="page-item" @click="fetchPageData((strlmt - 1))">
                                <a class="page-link" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" :class="{ active: strlmt == 0 }" @click="fetchPageData(0)">
                                <a class="page-link">1</a>
                            </li>
                            <li class="page-item" :class="{ active: strlmt == 1 }" v-if="total" @click="fetchPageData(1)">
                                <a class="page-link">2</a>
                            </li>
                            <li class="page-item" :class="{ active: item == strlmt }" v-if="pagetotal > 1"
                                v-for="item in pagination(strlmt, pagetotal)" @click="fetchPageData(item)">
                                <a class="page-link" v-if="item > 0">{{ item + 1 }}</a>
                                <a class="page-link" v-else>{{ item }}</a>
                            </li>
                            <li class="page-item" @click="fetchPageData((strlmt + 1))">
                                <a class="page-link" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-10 col-md-10 px-4 px-md-0 d-block d-md-none">
                        <h4>ประวัติการทำงาน</h4>
                        <div class="border rounded-3 bg-white box-shadow p-2 my-2 " style="height:85px;" v-for="(booking, i) in dataHistory.listWork" :key="i" @click="openSlip(booking)">
                        <div class="d-flex align-items-center justify-content-between" v-if="i>= start && i < (limit)">
                            <div class="text-primary w-50 px-2">
                            <h5> วันที่:{{ formatDateThai(booking.dateSelect) }} <span class="text-muted">เวลา:</span>{{ booking.startTime }}</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-50 px-2">
                            <div class="me-2">
                                <!-- <button class="btn btn-outline-info" @click="openSlip(booking)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                    <path
                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />
                                </svg>
                                </button> -->
                            </div>
                            
                            
                            <div v-if="booking.isActive==4" class="text-success text-nowrap">
                                <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check2-circle" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                <path
                                    d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                </svg>ทำงานสำเร็จ</h5>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="text-right d-flex justify-content-between " id="slide-page" v-if="dataHistory.length>10">
                            <div class="text-left" id="str-lmt">
                            หน้า {{ dataStrLmt + 1 }}
                            </div>
                            <ul class="pagination pagination-rounded justify-content-end mb-2">
                            <li class="page-item" @click="fetchPageData((strlmt - 1))">
                                <a class="page-link" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item" :class="{ active: strlmt == 0 }" @click="fetchPageData(0)">
                                <a class="page-link">1</a>
                            </li>
                            <li class="page-item" :class="{ active: strlmt == 1 }" v-if="total" @click="fetchPageData(1)">
                                <a class="page-link">2</a>
                            </li>
                            <li class="page-item" :class="{ active: item == strlmt }" v-if="pagetotal > 1"
                                v-for="item in pagination(strlmt, pagetotal)" @click="fetchPageData(item)">
                                <a class="page-link" v-if="item > 0">{{ item + 1 }}</a>
                                <a class="page-link" v-else>{{ item }}</a>
                            </li>
                            <li class="page-item" @click="fetchPageData((strlmt + 1))">
                                <a class="page-link" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { format } from 'date-fns';
import { th } from 'date-fns/locale';
// import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
export default {
    data() {
        return {
            profile: '',
            pass: '',
            maidProfile: '',
            imageData: '',
            dataHistory: '',
            selectBank:'',
            edit:false,
            listSt:false,
            uploadStatus:false,
            apiBase: import.meta.env.VITE_AGENT_BASE_URL,
            bankData: [
                { "img": "https://www.logolynx.com/images/logolynx/ac/acc6db2f0532b74dff3f2525adbc56a3.jpeg", "id": "1", "shortname": "kbank", "name": "กสิกรไทย" },
                { "img": "https://media-exp1.licdn.com/dms/image/C510BAQElNZUFumis3Q/company-logo_200_200/0/1519912092504?e=2159024400&v=beta&t=UXn2iHDhq4cwYLoRjYxo3FgGkjJR3ekhlnDo-dw5KB4", "id": "2", "shortname": "scb", "name": "ไทยพาณิชย์" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXMiwU15ngT63kAECxWfVQUvzjkOsbB_ujb3VAlr1VZYThd1EQ_JxFNCTVC7TwuREYBb8&usqp=CAU", "id": "3", "shortname": "bbl", "name": "กรุงเทพ" },
                { "img": "https://upload.wikimedia.org/wikipedia/en/thumb/f/f0/Krung_Thai_Bank_logo.svg/220px-Krung_Thai_Bank_logo.svg.png", "id": "4", "shortname": "ktb", "name": "กรุงไทย" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGqrt4IpIhN4sOmI3du7EJiFmB50Z5sTHzd7TxmSDjLn1KF0pL38fjOZPa7vn3NJJqIkU&usqp=CAU", "id": "5", "shortname": "bay", "name": "กรุงศรีอยุธยา" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ0qwsNsBRVA1r0DkIg3DoYNfpRGrua_FQkIVSkM09LBJJOwKMT7NSIQugWZtHGq_hd_s&usqp=CAU", "id": "6", "shortname": "gsb", "name": "ออมสิน" },
                { "img": "https://media.glassdoor.com/sqll/11462/united-overseas-bank-squarelogo-1464075746597.png", "id": "7", "shortname": "uob", "name": "ยูโอบี" },
                { "img": "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAz1BMVEX///9ucHHW3CdJv8f1g2gbhcP7xRKcn5P2kyCOQJlnaWpqbG2Sk5Sbm5yrrK1gYmPMzc27u7u0tLXd3d3v7+/Fxcb/yADe4mLe3gpDxsr7h2Tag3sAhcdcka3euU6XnZe9m3X6khX5vIez4OTLsNDa30hgxcyaWaPU2xLr7qr2kHlBksn7yjymqZ73nkSJM5T6x72oyOL946f7zamJiotSVVbh5XXg4TrdkIlwnbX/zS/hv2TEpYT6wpT3fV7v8bvtx8S5zdjv3rTg0cL838l6JC6TAAAB0UlEQVR4nO3aV1PbQBSAUZweyWCDE1JwCqmkN0jvyf//TXnzyFf7sOv1TBCc86x7Zz+9abQbGwAAAAAAAAAAQLHpdseVtW6bZQ7NVhnKdzhpFibT2m3j7rarmUPb3aGt2iP0z9SOFprqws3utuzCpjOksJzCMgqTFFZSWEZhksJKCssoTFJYSWEZhUkKKyksozBJYSWFZRQmKayksIzCJIWVFJZRmDTYwlEzydOMhlq4CoUrUFhGoUKFq1BYRuEJK2wytUMtbKazPFvtQAsnubdVB/ttoXBBYSWFZRQmKayksIzCJIWVFJZRmKSwksIyCpMUVlJYRmGSwkqnq7Dd3MmWfhnHvXDU5v5qaCabyW3HvjBfq1Bhh8JKChUuU5iksNLJLzzMvMgbjZPbxp0njnILd446U+svBAAAAAAAhuL9w+jDo57HPU+jj8+iT5+fB19eRF9fRt/WXnjt4Exw/Wx043LPzXPB3vz8svmt3QvLdm/fuRjc3b+0bP/e+gtjoEKFChUqVKhQoUKFChUqVKhQoUKFChUqVKhQ4f8qPIgSha96vkd78yivMFp/4Y8nPfd7HvS8jn6+iX69jX5Poz/vor9rLwQAAAAAAAAAgFPgH6e2FfsAGvSxAAAAAElFTkSuQmCC", "id": "8", "shortname": "lhb", "name": "แลนด์&เฮ้าส์" },
                { "img": "https://marketsavvy.co/wp-content/uploads/2020/04/GHlogo-300x300.jpg", "id": "9", "shortname": "ghb", "name": "อาคารสงเคราะห์" },
                { "img": "https://i.pinimg.com/originals/06/70/69/067069fcbe69567ec81b0240996c0632.png", "id": "11", "shortname": "ibank", "name": "อิสลามแห่งประเทศไทย" },
                { "img": "https://upload.wikimedia.org/wikipedia/en/f/f8/Tisco_logo.png", "id": "12", "shortname": "tisco", "name": "ทิสโก้" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJZHdAC3gRb5lGbO8Op2Qqui2LRh1mMRtgOk9SGkMigvTHDYyNZjl70oGDxN_IddXSpXM&usqp=CAU", "id": "13", "shortname": "kk", "name": "เกียรตินาคิน" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrs-WPHU6UjzNTDQILwK1x0WvRP0Un5eATlEaUb-llTIbrFUXEXGeO-HxooJoyhyKdE2A&usqp=CAU", "id": "14", "shortname": "baac", "name": "ธกส." },
                { "img": "http://www.logotaglines.com/wp-content/uploads/2016/11/JPMorgan-Chase-Co-Logo-487x365.jpg", "id": "15", "shortname": "jpm", "name": "เจพีมอร์แกนเชส " },
                { "img": "https://www.jobtopgun.com/content/filejobtopgun/logo_com_job/j3651.gif?_=13", "id": "16", "shortname": "ttb", "name": "ทหารไทยธนชาต" },
                { "img": "https://i.pinimg.com/originals/f0/52/4a/f0524a1937ff5b1e03c6c92ad014d821.png", "id": "17", "shortname": "tcrb", "name": "ไทยเครดิต" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPIvcD_NGgZzOu6QDrP_yFwaa1-GOuNtfwLLTLL9D3b40CveggydAII0ZudwhZqxwbdSc&usqp=CAU", "id": "18", "shortname": "citi", "name": "ซิตี้แบ้งค์" },
                { "img": "data:image/jpeg;base64,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", "id": "19", "shortname": "smbc", "name": "ซูมิโตโมมิตซุย แบงกิ้ง" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRveApa65w_dnKgmRo2HrkL0lwLAxzQC5b9vYsNf3K8zmb8Pjq6rebYMOtCdqL8FKqP--U&usqp=CAU", "id": "20", "shortname": "cimb", "name": "ซีไอเอ็มบีไทย" },
                { "img": "https://1.bp.blogspot.com/-22UW_ctLnWo/XBzuZkP0RXI/AAAAAAAAAd0/rzpg3S5XQtswJoJ3cTWDYdHnqpQlOzYbgCK4BGAYYCw/s1600/Bank%2BMEGA%2B%255Bsiklogo.blogspot.com%255D.png", "id": "21", "shortname": "mega", "name": "เมกะสากลพาณิชย์" },
            ],
            dataStrLmt: 0,
            pagetotal: 0,
            total: 0,
            strlmt: 0,
            start:0,
            limit:5,
        }
    },
    mounted() {
        this.profile = JSON.parse(localStorage.getItem("Maid"));
        if (this.profile) {
            this.getProfile();
            this.getHistory();
        } else {
            this.$route.push('/maid-sign-in');
        }
    },
    methods: {
        formatDateThai(date) {
            return format(new Date(date), 'd MMM yy', { locale: th });
        },
        chooseBankEdit(data) {
            this.maidProfile.bank_type = data;
            this.listSt = false;
        },
        chooseBank(data) {
            this.selectBank = data;
            this.listSt = false;
        },
        uploadImage() {
            this.$refs.upImg.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            this.imageData = URL.createObjectURL(file);

            const reader = new FileReader();
            let base64Image = ''; // เริ่มต้นด้วยค่าว่าง
            reader.onload = (e) => {
            const img = new Image();
            img.src = e.target.result;

            img.onload = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            const MAX_WIDTH = 300; // กำหนดความกว้างสูงสุด
            const MAX_HEIGHT = MAX_WIDTH * (img.height / img.width);

            canvas.width = MAX_WIDTH;
            canvas.height = MAX_HEIGHT;

            // ปรับขนาดรูปภาพ
            ctx.drawImage(img, 0, 0, MAX_WIDTH, MAX_HEIGHT);

            // สร้าง base64 URL จาก Canvas
            const base64Image = canvas.toDataURL('image/jpeg');

            // กำหนดค่าให้กับ imageData และ imageUrl
            this.maidProfile.img = base64Image; 
                if(base64Image){
                        this.upImgProfile();
                    }
            };
        };
            
            reader.readAsDataURL(file);

        },
        upImgProfile: async function () {
            try {
                let config = {
                    method: "put",
                    url: this.apiBase + "/maid-img/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data:{img:this.maidProfile.img}
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.uploadStatus=true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        openSlip(data) {
            this.getProfile();
            // this.fetchPayWait();
            
            this.opSm = true;
            this.dataSlip = data;
            if(this.dataSlip.hasTool==='1'){
                this.toolPirce = this.dataSetting.hasTool;
            }else{
                this.toolPirce = 0;
            }
        },
        getHistory: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/maids-history/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.dataHistory = response.data;
                        if (this.dataHistory.length > 5 && this.dataHistory.length < 10) {
                            this.total = true;
                            this.pagetotal = 1;
                        } else {
                            this.total = false;
                            this.pagetotal = parseInt(this.dataHistory.length / 5);
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        getProfile: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/maid-profile/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.maidProfile = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        editBank(){
            this.getProfile();
            this.edit=true;
        },
        saveEdit:async function(){
            try {
                let config = {
                    method: "put",
                    url: this.apiBase + "/maid-profile/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data: {
                        bank_number:this.maidProfile.bank_number,
                        fname:this.maidProfile.fname,
                        lname:this.maidProfile.lname,
                        bank_type:this.maidProfile.bank_type,
                        pass:this.pass,
                    }
                };
                await axios
                    .request(config)
                    .then((response) => {
                        this.getProfile();
                        this.edit=false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        fetchPageData: async function (str) {
      if (str == '...' || this.strlmt == str) {
        return false;
      }
      if (str > this.pagetotal) {
        str = this.pagetotal;
        return false;
      } else if (str < 0 || str == -1) {
        return false;
      }
      // this.dataMaids = '';
      this.strlmt = str;
      if (str < 0 || str == -1) {
        str = 0;
      }
      // var choices = document.getElementById("producttypesale").value;
      this.strlmt = str;
      this.dataStrLmt = str;
      

      if((str * 5)<this.dataBook.length ){
        this.start = str * 5;
        this.limit = str * 5 + 5;
      }

    },
    pagination: function (c, m) {
      var current = c,
        last = m,
        delta = 2,
        left = current - delta,
        right = current + delta + 1,
        range = [],
        rangeWithDots = [],
        l;

      range.push(1)
      if (last > 1) {
        for (let i = c - delta; i <= c + delta; i++) {
          if (i >= left && i < right && i < m && i > 1) {
            range.push(i);
          }
        }
        range.push(m);

        for (let i of range) {
          if (l) {
            if (i - l === 2) {
              rangeWithDots.push(l + 1);
            } else if (i - l !== 1) {
              rangeWithDots.push('...');
            }
          }
          rangeWithDots.push(i);
          l = i;
        }
      }
      return rangeWithDots;
    },
    },
}
</script>

<style>
.list-show {
    padding: 4px 8px;
}

.list-show:hover {
    background-color: #ccc;
    padding: 4px 8px;
}
</style>