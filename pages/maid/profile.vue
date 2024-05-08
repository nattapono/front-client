<template>
    <div class="row d-flex align-items-top justify-content-center mb-5">
        <div class="col-12 col-md-10 my-4">
            <div class="card mx-3">
                <div class="row d-flex align-items-top justify-content-start p-3">
                    <div class="col-12 col-md-4 p-2 text-center">
                        <div class="w-100 border rounded" v-if="maidProfile.img">
                            <img :src="maidProfile.img" class="w-100" alt="maid">
                        </div>
                        <div class="w-100 text-center  border rounded py-2" v-else>
                            <img src="@/public/assets/images/maid.png" width="100" alt="maid">
                        </div>
                        <input type="file" ref="upImg" class="d-none" @change="handleFileUpload">
                        <button class="btn btn-outline-danger btn-sm my-2 w-100"
                            @click="uploadImage">อัพรูปโปรไฟล์</button>
                        <span class="text-success" v-if="uploadStatus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                <path
                                    d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                            </svg>
                            อัพโหลดสำเร็จ
                        </span>
                    </div>
                    <div class="col-12 col-md-8">
                        <!-- ชื่อ : {{ maidProfile.fname }} {{ maidProfile.lname }} -->
                        <div v-if="edit" class="row">
                            <label for="">ธนาคาร</label>
                            <button class="btn border form-control" @click="listSt = true">
                                <div v-if="!maidProfile.bank_type" class="d-flex justify-content-start">
                                    เลือกธนาคาร</div>
                                <div v-for="(item, i) in bankData" :key="i" v-else>
                                    <div v-if="maidProfile.bank_type == item.id"
                                        class="d-flex align-items-center justify-content-start">
                                        <img :src="item.img" :alt="item.shortname" class="rounded me-2" width="35">
                                        <div class="text-dark pb-0"> ธนาคาร{{ item.name }}</div>
                                    </div>
                                </div>
                            </button>
                            <div class="border p-2" style="overflow:scroll" v-if="listSt == true">
                                <div v-for="(item, i) in bankData" :key="i">
                                    <div class="d-flex align-items-center justify-content-start my-2 list-show"
                                        @click="chooseBankEdit(item.id)">
                                        <img :src="item.img" :alt="item.shortname" class="rounded me-2" width="35">
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
                                    <input type="text" class="form-control" maxlength="10" v-model="maidProfile.bank_number">
                                </div>
                            </div>
                            <div class="col-12 p-3">
                                <div class="border p-2 rounded-2 mb-2 bg-gray-200">
                                    <label for="">ข้อความแนะนำตัว</label>
                                    <textarea name="" id="" cols="30" rows="3" v-model="maidProfile.myDesc"
                                        placeholder="ข้อความแนะนำตัว" class="form-control"></textarea>
                                </div>
                                <div class="border p-2 rounded-2">
                                    <label for="">เปลี่ยนรหัสผ่าน</label>
                                    <input type="text" v-model="pass" placeholder="เปลี่ยนรหัสผ่าน"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div v-else class="row">
                            <div class="col-6">
                                <div v-if="!maidProfile.bank_type">
                                    <p class="text-danger">กรุณาเพิ่มข้อมูลธนาคาร</p>
                                </div>
                                <div v-for="(item, i) in bankData" :key="i">
                                    <div v-if="maidProfile.bank_type == item.id">
                                        <img :src="item.img" :alt="item.shortname" class="around" width="85">
                                        <p class="text-dark">ธนาคาร: {{ item.name }}</p>
                                    </div>
                                </div>
                                ชื่อบัญชี: {{ maidProfile.fname }} {{ maidProfile.lname }}
                                <p>เลขที่บัญชี: {{ maidProfile.bank_number }}</p>
                            </div>
                            <div class="col-12 col-md-6 p-3">
                                <div class="border p-2 rounded-2 mb-2  bg-gray-200">
                                    <label for="">ข้อความแนะนำตัว</label>
                                    <div class="tex-white text-small" v-if="maidProfile.myDesc">{{ maidProfile.myDesc }}
                                    </div>
                                    <div class="tex-white text-small" v-else>{{ maidProfile.myDesc }}</div>
                                </div>
                                <div class="border p-2 rounded-2">
                                    <label for="">เปลี่ยนรหัสผ่าน</label>
                                    <input readonly type="text" v-model="pass" placeholder="เปลี่ยนรหัสผ่าน"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-8" v-if="!edit">
                                <button class="btn btn-primary" v-if="!maidProfile.bank_type"
                                    @click="editBank">เพิ่มข้อมูล</button>
                                <button class="btn btn-primary" v-else @click="editBank">แก้ไข</button>
                            </div>

                            <div class="col-8" v-else>
                                <button class="btn btn-danger me-2" @click="edit = false">ปิด</button>
                                <button class="btn btn-success" @click="saveEdit">แก้ไข</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card mx-3 my-3 p-0">
                <h4 class="bg-warning p-2 text-white">ประวัติรายได้</h4>
                <div class="row pb-5 d-flex align-items-center justify-content-center">
                    <div class="col-12 col-lg-10 col-md-10 px-0 px-md-0 d-none d-md-block">
                        <div class="table-responsive mt-2  px-0">
                            <table class="table rounded-4" style="min-height: 350px;">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>วันที่</th>
                                        <th>ยอด</th>
                                        <th></th>
                                        <th></th>
                                        <th>สลิป</th>
                                        <th>สถานะ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" v-if="dataHistory.length == 0"
                                            class="text-center py-5 text-muted">
                                            <div class="py-4 mb-5">
                                                - No Data -
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-for="(booking, i) in dataHistory" :key="booking.id">
                                    <tr v-if="i >= start && i < (limit)">
                                        <td></td>
                                        <td class="text-muted text-nowrap">{{ formatDateThai(booking.create_at) }} </td>
                                        <td class="text-primary text-nowrap">{{booking.amount}}</td>
                                        <td></td>
                                        <td style="width:300px" class="small text-muted"></td>
                                        <td @click="openSlip(booking)" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-file-text-fill text-info"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />
                                            </svg>
                                        </td>
                                        <td class="text-success text-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                <path
                                                    d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                            </svg> ได้รับแล้ว
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 col-lg-10 col-md-10 px-4 px-md-0 d-block d-md-none">
                        <div colspan="7" v-if="dataHistory.length == 0" class="text-center py-5 text-muted">
                            <div class="py-4 mb-5">
                                - No Data -
                            </div>
                        </div>
                        <div class="border rounded-3 bg-white box-shadow p-2 my-2 " v-else style="height:85px;"
                            v-for="(booking, i) in dataHistory" :key="booking.id">
                            <div class="d-flex align-items-center justify-content-between"
                                v-if="i >= start && i < (limit)">
                                <div class="text-primary w-50 px-2">
                                    <h5> วันที่:{{ formatDateThai(booking.create_at) }} <span
                                            class="text-muted">ยอด:</span>{{accordingSection.amount}}</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-50 px-2">
                                    <div class="me-2">
                                        <button class="btn btn-outline-info" @click="openSlip(booking)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="currentColor" class="bi bi-file-text-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />
                                            </svg>
                                        </button>
                                    </div>


                                    <div class="text-success text-nowrap">
                                        <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                                                <path
                                                    d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                                            </svg> ได้รับแล้ว</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-10 col-md-10 px-4">
                        <div class="text-right d-flex justify-content-between " id="slide-page"
                            v-if="dataHistory.length > 10">
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
                                <li class="page-item" :class="{ active: strlmt == 1 }" v-if="total"
                                    @click="fetchPageData(1)">
                                    <a class="page-link">2</a>
                                </li>
                                <li class="page-item" :class="{ active: item == strlmt }" v-if="pagetotal > 1"
                                    v-for="item in pagination(strlmt, pagetotal)" @click="fetchPageData(item)">
                                    <a class="page-link" v-if="item > 0">{{ item + 1 }}</a>
                                    <a class="page-link" v-else>{{ item }}</a>
                                </li>
                                <li class="page-item" @click="fetchPageData((strlmt + 1))">
                                    <a class="page-link me-0" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="opSm" class="modal fade show d-block bg-modal text-small">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-2">
                    <div class="modal-header text-white bg-danger py-2 ">
                        <h4 class="modal-title" id="exampleModalLongTitle">หนังสือรับรองการหักภาษี ณ ที่จ่าย</h4>
                        <button type="button" class="close text-white btn text-xl" @click="opSm = false"
                            style="font-size: 33px;line-height: 0;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="according-section" style="font-family:sans-serif;">
                        <div class="text-center text-small according-section" style="letter-spacing: 1px;font-size:8px;">
                            <div class="text-primary" style="font-family:sans-serif;">แบบฟอร์มหนังสือรับรองการหักภาษี ณ ที่จ่าย</div>
                            <div style="font-family:sans-serif;">ตามมาตรา 50 ทวิ แหล่งประมวลรัษฎากร</div>
                            <div class="mb-2 d-flex justify-content-between" style="font-family:sans-serif;"><span style="font-family:sans-serif;">ลำดับที่ .....   ในแบบ   แบบยื่น   ภงด.3   (บุคคลธรรมดา)</span> เลขที่     {{accordingSection.id.toString().padStart(6, '0') }}</div>
                            <div class="p-2 w-100" style="border-right: solid 0.05rem #000;border-left: solid 0.05rem #000; border-bottom: solid 0.05rem #000; border-top: solid 0.07rem #000;">
                                <div class="d-flex justify-content-between" style="font-family:sans-serif;"><span style="font-family:sans-serif;">ผู้มีหน้าที่หักภาษี ณ ที่จ่าย:</span> <span style="font-family:sans-serif;">เลขประจําตัวผู้เสียภาษี</span> <span style="font-family:sans-serif;">0105555172337</span> สํานักงานใหญ่  </div>
                                <div  class="row d-flex justify-content-center">
                                    <div  style="font-family:sans-serif;text-align-last:left" class="col-2 text-left ps-4">ชื่อ  </div>
                                    <div class="col-10 d-flex justify-content-start ps-0"   style="font-family:sans-serif;text-align-last:left" >
                                        {{ dataSetting.bname }}
                                    </div>
                                </div>
                                <div  class="row">
                                    <div style="font-family:sans-serif;font-family:sans-serif;text-align-last:left" class="col-2 ps-4">ที่อยู่  </div>
                                    <div class="col-10 d-flex justify-content-start ps-0"  style="font-family:sans-serif;text-align: justify;">
                                        {{ dataSetting.baddress }}
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between" style="font-family:sans-serif;"><span style="font-family:sans-serif;">ผู้ถูกหักภาษี ณ ที่จ่าย:</span> <span style="font-family:sans-serif;">เลขประจําตัวผู้เสียภาษี</span> <span style="font-family:sans-serif;">{{ profile.ppCard }}</span> สํานักงานใหญ่  </div>
                                <div  class="row d-flex justify-content-center">
                                    <div  style="font-family:sans-serif;text-align-last:left" class="col-2 text-left ps-4">ชื่อ  </div>
                                    <div class="col-10 d-flex justify-content-start ps-0"   style="font-family:sans-serif;text-align-last:left" >
                                        {{ profile.fullname }}
                                    </div>
                                </div>
                                <div  class="row">
                                    <div  style="font-family:sans-serif;text-align-last:left" class="col-2 ps-4">ที่อยู่  </div>
                                    <div class="col-10 d-flex justify-content-start ps-0"  style="font-family:sans-serif;text-align: justify;">
                                        {{ profile.address }}
                                    </div>
                                </div>
                            </div>
                            <div class="py-1" style="border: solid 0.05rem #000;">
                                <div class="row d-flex justify-content-between px-2">
                                    <div class="col-6 ps-4"  style="font-family:sans-serif;text-align-last: justify;">ประเภทเงินได้พึงประเมินที่จ่าย:<br> <spa class="text-primary" style="font-family:sans-serif;">1.ค้างจ่าย</spa></div>
                                    <div style="font-family:sans-serif;" class="col-2  px-0">วัน เดือนปี<br>ภาษี ที่จ่าย</div>
                                    <div style="font-family:sans-serif;" class="col-2">จำนวนเงินที่จ่าย</div>
                                    <div style="font-family:sans-serif;" class="col-2 px-0">ภาษีที่หัก<br>และนำส่งไว้</div>
                                </div>
                            </div>
                            <div class="text-left py-1"   style="font-family:sans-serif;border: solid 0.05rem #000;font-weight:100">
                                <div class="d-flex d-flex justify-content-center w-100">
                                    <div class="row d-flex justify-content-between w-100 px-1">
                                        <div class="col-6 text-left px-0"  style="font-family:sans-serif;text-align: left;">1.เงินเดือน ค่าจ้าง เบี้ยเลี้ยง โบนัสฯลฯ ตาม ม.40(1):</div>
                                        <div style="font-family:sans-serif;" class="col-2 px-0">{{ fDateThai(accordingSection.create_at) }}</div>
                                        <div style="font-family:sans-serif;" class="col-2">
                                            {{ accordingSection.amount }}
                                        </div>
                                        <div class="col-2 px-1"  style="font-family:sans-serif;text-align-last: right;">{{parseFloat(accordingSection.vat).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")}}</div>
                                    </div>
                                </div>
                                <div class=" w-100">
                                    <div class="row d-flex justify-content-between w-100 px-3">
                                        <div class="col-6 text-left px-0"  style="font-family:sans-serif;text-align: left;">2.ค่าธรรมเนียม ค่านายหน้า ฯลฯ ตามมาตรา 40(2)</div>
                                    </div>
                                    <div class="row d-flex justify-content-between w-100 px-3">
                                        <div class="col-6 text-left px-0"  style="font-family:sans-serif;text-align: left;">3.ค่าแห่งลิขสิทธิ์ ฯลฯ ตามมาตรา 40(3)</div>
                                    </div>
                                    <div class="row d-flex justify-content-between w-100 px-3">
                                        <div class="col-12 text-left px-0"  style="font-family:sans-serif;text-align: left;">4.(ก) ค่าดอกเบี้ย ฯลฯ ตามมาตรา 40(4)(ก)</div>
                                        <div class="col-12 text-left px-2"  style="font-family:sans-serif;text-align: left;">(ข) เงินปันผล เงินส่วนแบ่งกําไร ฯลฯ ตาม ม.40(4)(ข)</div>
                                        <div class="col-12 text-left px-4"  style="font-family:sans-serif;text-align: left;">(1) กรณีผู้ได้รับเงินปันผลได้รับเครดิตภาษี โดยจ่ายจาก</div>
                                        <div class="col-12 text-left px-5"  style="font-family:sans-serif;text-align: left;">
                                            กําไรสุทธิของกิจการที่ต้องเสียภาษีเงินได้นิติบุคคลในอัตราดังนี้<br/>
                                            (1.1) อัตราร้อยละ 30 ของกําไรสุทธิ<br/>
                                            (1.2) อัตราร้อยละ 25 ของกําไรสุทธิ<br/>
                                            (1.3) อัตราร้อยละ 20 ของกําไรสุทธิ<br/>
                                            (1.4) อัตราอื่นๆ(ระบุ).....ของกําไรสุทธิ
                                        </div>
                                        <div class="col-12 text-left px-4"  style="font-family:sans-serif;text-align: left;">(2) กรณีผู้ได้รับเงินปันผลไม่ได้รับเครดิตภาษี เนื่องจากจ่าย</div>
                                        <div class="col-12 text-left px-5"  style="font-family:sans-serif;text-align: left;">
                                            (2.1) กําไรสุทธิของกิจการที่ได้รับยกเว้นภาษี<br/>
                                            (2.2) เงินปันผลหรือเงินส่วนแบ่งของกําไรที่ได้รับยกเว้น <br/>
                                            <div style="font-family:sans-serif;" class=" px-3">ไม่ต้องนํามารวมคํานวณเป็นรายได้เพื่อเสียภาษ</div>
                                            <div style="font-family:sans-serif;" class=" px-3">เงินได้นิติบุคคล</div>
                                            (2.3) กําไรสุทธิส่วนที่ได้หักผลขาดทุนสุทธิยกมาไม่เกิน 5 ปี
                                            <div style="font-family:sans-serif;" class=" px-3">ก่อนรอบระยะเวลาบัญชีปีปัจจุบัน</div>
                                            (2.4) กําไรที่รับรู้ทางบัญชีโดยวิธีส่วนได้เสีย 
                                            <div style="font-family:sans-serif;" class=" px-3">(equity method) </div>
                                            (2.5) อื่นๆ (ระบุ)
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between w-100 px-3">
                                        <div class="col-12 text-left px-0 text-nowrap"  style="font-family:sans-serif;text-align: left;">
                                            5.การจ่ายเงินได้ที่ต้องหักภาษี ณ ที่จ่ายตามคําสั่งกรมสรรพากรที่ออกตาม 
                                            <div style="font-family:sans-serif;" class="ms-2"> มาตรา 3เตรส (ระบุ) </div>
                                            <div style="font-family:sans-serif;" class="ms-2 text-nowrap"> (เช่น รางวัล ส่วนลดหรือประโยชนะใดๆ เนื่องจากการส่งเสริมการขาย</div>
                                            <div style="font-family:sans-serif;" class="ms-2 text-nowrap"> รางวัลในการประกวด การแข่งขัน การชิงโชค ค่าแสดงของนักแสดง</div>
                                            <div style="font-family:sans-serif;" class="ms-2 text-nowrap"> สาธารณะ ค่าขนส่ง ค่าบริการ ค่าเบี้ยประกันวินาศภัย ฯลฯ)</div>
                                        </div>
                                        <div class="col-12 text-left px-0 text-nowrap"  style="font-family:sans-serif;text-align: left;">6.อื่นๆ (ระบุ)</div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-1" style="border: solid 0.05rem #000;">
                                <div class="d-flex d-flex justify-content-center w-100">
                                    <div class="row d-flex justify-content-between w-100 px-1">
                                        <div class="col-8 text-left px-3"  style="font-family:sans-serif;text-align: right;">รวมเงินที่จ่ายและภาษีที่หักนําส่ง</div>
                                        <div style="font-family:sans-serif;" class="col-2"> {{parseFloat(accordingSection.totalAmount).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")}}</div>
                                        <div class="col-2 px-1"  style="font-family:sans-serif;text-align-last: right;"> {{parseFloat(accordingSection.vat).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,")}}</div>
                                    </div>
                                </div>
                                <div class="d-flex d-flex justify-content-center w-100">
                                    <div class="row d-flex justify-content-between w-100 p-1">
                                        <div class="col-3 px-0 text-left"  style="font-family:sans-serif;text-align: left;">รวมเงินภาษีที่หักนําส่ง</div>
                                        <div class="col-3 px-0" style="font-family:sans-serif;">(ห้าร้อยสี่สิบบาทถ้วน).</div>
                                        <div class="col-6 px-1" style="text-align-last: right;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="py-1" style="border: solid 0.05rem #000;">
                                <div class="row d-flex justify-content-between w-100 px-4">
                                    <div class="col-4 px-0 text-center" style="font-family:sans-serif;">ผู้จ่ายเงิน</div>
                                    <div class="col-4 px-0" style="font-family:sans-serif;text-align: justify;">[ x ]   หักภาษี ณ ที่จ่าย</div>
                                    <div class="col-4 px-1" style="font-family:sans-serif;text-align: justify;">[    ]   ออกให้ตลอดไป </div>
                                </div>
                                <div class="row d-flex justify-content-between w-100 px-4">
                                    <div class="col-4 px-0 text-left" style="text-align: left;"></div>
                                    <div class="col-4 px-0"  style="font-family:sans-serif;text-align: justify;">[    ]   ออกภาษีให้ครั้งเดียว</div>
                                    <div class="col-4 px-1"  style="font-family:sans-serif;text-align: justify;">[    ]   อื่นๆ   (ระบุ) ..............</div>
                                </div>
                            </div>
                            <div class="py-1"  style="border: solid 0.05rem #000;">
                                <div class="row d-flex justify-content-between w-100 px-4">
                                    <div class="col-12 px-0 mb-3 text-left"  style="font-family:sans-serif;text-align: left;">ขอรับรองว่าข้อความและตัวเลขดังกล่าวถูกต้องตรงกับความเป็นจริงทุกประการ</div>
                                    <div class="col-6 pe-0 ps-0 ps-md-5"  style="font-family:sans-serif;text-align: left;">ผู้มีหน้าที่หักภาษี ณ.ที่จ่าย<br/>วันเดือนปี ที่ออกหนังสือรับรองฯ</div>
                                    <div class="col-3 px-0 text-center"  style="font-family:sans-serif;letter-spacing: 2px;">..........................<br/>{{ fDateThai(accordingSection.create_at) }}</div>
                                    <div class="col-3 px-1 text-center" style="font-family:sans-serif;">ประทับตรา<br/>นิติบุคคล</div>
                                    <img src="@/public/assets/images/linecent.png" alt="logo" class="linecent">
                                    <img src="@/public/assets/images/pratab.png" alt="logo" style="width:100px;position:absolute;right:20px">
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="opSm = false">ปิด</button>
                        <button type="button" class="btn btn-primary" @click="downloadAsImage()"> ดาวน์โหลด</button>
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
import html2canvas from 'html2canvas';
export default {
    data() {
        return {
            profile: '',
            pass: '',
            maidProfile: '',
            imageData: '',
            dataHistory: '',
            selectBank: '',
            myDesc: '',
            opSm: false,
            edit: false,
            listSt: false,
            uploadStatus: false,
            apiBase: import.meta.env.VITE_AGENT_BASE_URL,
            bankData: [
                { 
                    "img": "https://www.logolynx.com/images/logolynx/ac/acc6db2f0532b74dff3f2525adbc56a3.jpeg", "id": "1", "shortname": "kbank", "name": "กสิกรไทย" },
                ],
            dataStrLmt: 0,
            pagetotal: 0,
            total: 0,
            strlmt: 0,
            start: 0,
            limit: 5,
            dataSetting:'',
            accordingSection:''
        }
    },
    mounted() {
        this.profile = JSON.parse(sessionStorage.getItem("X-Maid"));
        if (this.profile) {
            this.getProfile();
            this.getHistory();
        } else {
            this.$route.push('/maid-sign-in');
        }
    },
    methods: {
        downloadAsImage() {
            const element = document.getElementById('according-section'); // เปลี่ยนเป็น ID ของ HTML ที่ต้องการสร้างภาพ
            Swal.fire({
                position: "top-center",
                icon: "rerequest",
                title: 'ดาวน์โหลดแบบฟอร์มหนังสือรับรองการหักภาษี ณ ที่จ่าย',
                showConfirmButton: true,
            }).then(() => {
                html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/jpeg');
                const a = document.createElement('a');
                a.href = imgData;
                const filename = 'madam-clean-according-section-' + this.reDateThai(new Date());
                a.download = filename + '.jpg'; // ชื่อไฟล์ที่ต้องการให้ดาวน์โหลด
                a.click();
                });
            });
        },
        formatDateThai(date) {
            return format(new Date(date), 'd MMM yy', { locale: th });
        },
        fDateThai(date) {
            const formattedDate = format(new Date(date), 'dd/MM/yy', { locale: th });
            const year = parseInt(formattedDate.slice(-2), 10) + 43; // เอาสองหลักสุดท้ายของปีและเพิ่ม 543 เพื่อแปลงเป็น พ.ศ.
            return formattedDate.slice(0, -2) + year; // ตัด 'YY' และเปลี่ยนเป็น พ.ศ.
        },
        reDateThai(date) {
            const formattedDate = format(new Date(date), 'dd/MM/yyyy', { locale: th });
            const year = parseInt(formattedDate.slice(-2), 10) + 543; // เอาสองหลักสุดท้ายของปีและเพิ่ม 543 เพื่อแปลงเป็น พ.ศ.
            return formattedDate.slice(0, -3) + year; // ตัด 'YY' และเปลี่ยนเป็น พ.ศ.
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
                    if (base64Image) {
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
                    data: { img: this.maidProfile.img }
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.uploadStatus = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        openSlip(data) {
            this.accordingSection = data;
            this.opSm = true;
            this.getSetting();
        },
        getHistory: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/pay-week/" + this.profile.maid_id,
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
        editBank() {
            this.getProfile();
            this.edit = true;
        },
        saveEdit: async function () {
            try {
                let config = {
                    method: "put",
                    url: this.apiBase + "/maid-profile/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data: {
                        bank_number: this.maidProfile.bank_number,
                        fname: this.maidProfile.fname,
                        lname: this.maidProfile.lname,
                        bank_type: this.maidProfile.bank_type,
                        myDesc: this.maidProfile.myDesc,
                        pass: this.pass,
                    }
                };
                await axios
                    .request(config)
                    .then((response) => {
                        this.getProfile();
                        this.edit = false;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        getSetting: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/patrol",
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.dataSetting = response.data;
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


            if ((str * 5) < this.dataBook.length) {
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

<style scoped>

.modal-body.according-section,
    .modal-body#according-section {
        font-family: "Taviraj" , sans-serif;
        font-weight: 100;
        font-style: normal;
    }

.list-show {
    padding: 4px 8px;
}

.list-show:hover {
    background-color: #ccc;
    padding: 4px 8px;
}

@media (min-width: 768px) {
    .linecent{
        width:100px;position:absolute;right:33%;
    }
}
@media (max-width: 480px) {
    .linecent{
        width:100px;position:absolute;right:30%;
        margin-top:5px;
    }
}
</style>