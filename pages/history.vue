<template>
  <div class="bg-gray-300 bg-md-white" style="min-height:100vh">
    <div class="row pb-5 d-flex align-items-center justify-content-center" v-if="stepTwo == false">
      <div class="col-12 my-4 pb-2"></div>
      <div class="col-12 col-lg-11 col-md-11 px-4 px-md-0 d-none d-md-block">
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
            <tbody v-if="dataBook.length == 0" >
              <tr>
                <td colspan="8" class="text-center py-5 text-muted">
                  <div class="py-4 mb-5">
                    - No Data -
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-for="(booking, i) in dataBook" :key="booking.bookId">
              <tr v-if="i >= start && i < (limit)">
                <td>{{ i + 1 }}</td>
                <td>{{ booking.fname }} {{ booking.lname }}</td>
                <td>{{ booking.hasClean }}</td>
                <td>{{ booking.workBuilding }}</td>
                <td style="width:300px" class="small text-muted">{{ booking.showAddress }}</td>
                <td class="text-primary">วันที่:{{ tfDateThai(booking.dateSelect) }} <small
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
                  <div v-if="booking.isActive == -1" class="text-warning text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-hourglass-split" viewBox="0 0 16 16">
                      <path
                        d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                    </svg> รอตรวจสอบ
                  </div>
                  <div v-if="booking.isActive == -2" class="text-nowrap text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                      </svg>
                    <small>
                      การชำระเงินไม่ถูกต้อง
                     </small>
                  </div>
                  <div v-if="booking.isActive == 2" class="text-warning text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-hourglass-split" viewBox="0 0 16 16">
                      <path
                        d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                    </svg> รอชำระเงิน
                  </div>
                  <div v-if="booking.isActive > 2" class="text-success text-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-check2-circle" viewBox="0 0 16 16">
                      <path
                        d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                      <path
                        d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                    </svg> ชำระแล้ว
                    </div>
                    <button class="btn btn-danger btn-sm py-0" @click="openCommentMaid(booking)" v-if="booking.isActive ==4 &&  booking.comments == 0">ให้คะแนน</button>
                  <div v-if="booking.receipt" class="d-none"><img :src="booking.receipt" alt="" width="80"></div>
                  <p v-if="booking.isActive == 2 ">
                    <button class="btn btn-sm btn-outline-danger py-0" @click="toPay">ชำระเงิน</button>
                  </p>
                  <p v-if=" booking.isActive == -2">
                    <button class="btn btn-sm btn-danger py-0" @click="toPay">ชำระเงิน</button>
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
      <div class="col-12 col-lg-8 col-md-8 px-4 px-md-0 d-block d-md-none">
        <h4>ประวัติการจอง</h4>
        <div class="bborder rounded-3 bg-white box-shadow px-0 py-2 my-2"
          v-for="(booking, i) in dataBook" :key="i" @click="openDetail(booking,i)">
          <div class="d-flex align-items-center justify-content-between" v-if="i >= start && i < (limit)">
            <div class="text-primary w-50 px-2">
              <h5> วันที่:{{ formatDateThai(booking.dateSelect) }} <span class="text-muted">เวลา:</span>{{ booking.startTime }}</h5>
            </div>
            <div class="d-flex align-items-center justify-content-between w-50 px-2">
              <div class="me-2">
                <button class="btn btn-outline-info" @click="openSlip(booking)" v-if="booking.isActive > -1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-file-text-fill" viewBox="0 0 16 16">
                    <path
                      d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M5 4h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5M5 8h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1m0 2h3a.5.5 0 0 1 0 1H5a.5.5 0 0 1 0-1" />
                  </svg>
                </button>
              </div>
              <div v-if="booking.isActive == -1" class="text-warning text-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-hourglass-split" viewBox="0 0 16 16">
                  <path
                    d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                </svg> รอตรวจสอบ
              </div>
              <div v-if="booking.isActive == 2" class="text-warning text-nowrap">
                <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-hourglass-split" viewBox="0 0 16 16">
                    <path
                      d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                  </svg> รอชำระเงิน</h5>
                <p v-if="booking.isActive == 2">
                  <button class="btn btn-sm btn-outline-danger py-0" @click="toPay">ชำระเงิน</button>
                </p>
              </div>
              <div v-if="booking.isActive > 2" class="text-success text-nowrap">
                <h5 class="mb-0">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-check2-circle" viewBox="0 0 16 16">
                    <path
                      d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                    <path
                      d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                  </svg> ชำระแล้ว
                </h5>
              </div>
              <div v-if="booking.isActive == -2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                  </svg>
                <small>
                  การชำระเงินไม่ถูกต้อง
                  </small>
                  <p v-if=" booking.isActive == -2" class="text-right">
                    <button class="btn btn-sm btn-danger py-0 px-3" @click="toPay">ชำระเงิน</button>
                  </p>
              </div>
            </div>
          </div>
          <div class="text-center w-100" v-if="booking.isActive ==4 && booking.comments == 0">
            <button class="btn text-danger"  @click="openCommentMaid(booking)">ให้คะแนนบริการ</button>
          </div>
          <div class="text-center w-100" :id="'icon1'+i">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor"
              class="bi bi-chevron-compact-down text-info" viewBox="0 0 16 16">
              <path fill-rule="evenodd"
                d="M1.553 6.776a.5.5 0 0 1 .67-.223L8 9.44l5.776-2.888a.5.5 0 1 1 .448.894l-6 3a.5.5 0 0 1-.448 0l-6-3a.5.5 0 0 1-.223-.67" />
            </svg>
          </div>
          <div class="text-left w-100 p-0 bg-gray-200 d-none" :id="'doo'+i">
              <div class="text-muted p-3">
                แม่บ้าน:{{ booking.fname }} {{ booking.lname }}<br />
                {{ booking.hasClean }}
                {{ booking.workBuilding }}<br />
                <span class="text-small p-3">ที่อยู่: {{ booking.showAddress }}</span>
              </div> 
            <div class="text-center w-100 bg-white" :id="'icon2'+i">
              <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-chevron-compact-up text-primary" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M7.776 5.553a.5.5 0 0 1 .448 0l6 3a.5.5 0 1 1-.448.894L8 6.56 2.224 9.447a.5.5 0 1 1-.448-.894z"/>
              </svg>
          </div>
          </div>
        </div>
        <div class="text-right d-flex justify-content-between " id="slide-page" v-if="dataBook.length > 10">
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
    <div class="row d-flex justify-content-center" v-if="stepTwo == true">
      <div class="col-12 col-lg-8 col-sm-8 col-md-10 ">
        <div class="row d-flex justify-content-center mt-4">
          <div class="col-12 col-lg-8 col-sm-8 px-4 px-md-0  d-flex justify-content-between">
            <h4>รอชำระเงิน</h4>
            <h4 @click="stepTwo = false" class="text-info cursor-pointer bg-white rounded px-2">
              <b>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-arrow-left" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                </svg>
              </b>
              กลับ
            </h4>
          </div>
          <div class="col-lg-8 col-sm-8 col-md-10 my-4 px-4 px-md-0 ">
            <div class="">
              กรุณากรอกข้อมูลผู้เสียภาษี
            </div>
              <div class="form-group mb-2 border p-4 bg-white">
                <div class="form-group mb-2">
                  <label for="registerInputEmail1">นามลูกค้า (บริษัท/บุคคล)</label>
                  <input type="text" v-model="payWait.nickname" class="form-control text-muted" id="registerInputPhone"
                  oninput="this.value = this.value.replace(/[0-9_]/g, '');"
                    aria-describedby="emailHelp" placeholder="ชื่อนามสกุล">
                  <small id="emailHelp" class="form-text text-danger">{{ addressError }}</small>
                </div>
                <div class="form-group mb-2">
                  <label for="registerInputEmail1">ที่อยู่</label>
                  <textarea cols="30" rows="2" v-model="payWait.maddress" class="form-control text-muted" id="registerInputPhone"

                    aria-describedby="emailHelp" placeholder="ที่อยู่"></textarea>
                  <small id="emailHelp" class="form-text text-danger">{{ addressError }}</small>
                </div>
                <div class="form-group mb-2">
                  <label for="registerInputEmail1">เลขที่ผู้เสียภาษี/เลขบัตรประชาชน</label>
                  <input type="text" v-model="payWait.mppcard" class="form-control text-muted" id="registerInputPhone"
                  oninput="this.value = this.value.replace(/[^0-9_]/g, '');" maxlength="13"
                    aria-describedby="emailHelp" placeholder="เลขที่ผู้เสียภาษี/เลขบัตรประชาชน">
                  <small id="emailHelp" class="form-text text-danger">{{ ppcardError }}</small>
                </div>
                 <button class="btn  btn-warning my-2" @click="handleSave">บันทึก</button>
              </div>
          </div>
          <div class="col-12 col-lg-8 col-sm-8 col-md-10 border p-2 mb-5 mx-lg-0 bg-white">
            <div class="row mx-2">
              <div class="col-4 text-left">
                <img src="@/public/assets/images/messageImage_1710223947120.jpg" alt="logo" class="p-2 w-100">
              </div>

              <div class="col-8 text-lef pt-2">
                <small class="text-muted" style="font-size:12px;">
                  {{dataSetting.bname}}<br>
                  {{dataSetting.baddress}}<br>
                  โทร. {{dataSetting.phone}} แฟกซ์ {{dataSetting.phone}} <br>
                  เลขประจำตัวผู้เสียภาษีอากร:{{dataSetting.vat_no}}/ สำนักงานใหญ่
                </small>
              </div>
            </div>
            <div class="border">
              <div class="border-bottom px-2 py-1">
                นามลูกค้า: <small class="text-muted">{{ payWait.nickname }}</small>
              </div>
              <div class="border-bottom px-2 py-1">
                ที่อยู่: <small class="text-muted small">{{ payWait.maddress }}</small>
              </div>
              <div class=" px-2 py-1">
                เลขประจำตัวผู้เสียภาษี : <small class="text-muted small">{{ dataSlip.mppcard }}</small>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table border" style="min-height:250px">
                    <tbody>
                      <tr>
                        <th>ลำดับ</th>
                        <th>รายละเอียด</th>
                        <th class="text-center">วันที่ชำระค่าบริการ</th>
                        <th class="text-center">วันที่เข้าดำเนินการ</th>
                        <th>จำนวนเงิน</th>
                      </tr>
                    </tbody>
                    <tbody>
                      <tr>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2" v-if="payWait.fname">
                            1
                          </div>
                        </td>
                        <td class="text-nowrap mx-0 px-0">
                          <div class="mx-0 px-2 d-flex justify" v-if="payWait.fname">
                            บริการแม่บ้าน {{ payWait.fname }} {{ payWait.lname }}
                          </div>
                        </td>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2 text-nowrap">
                            {{ tfDateThai(payWait.booking_create_at) }}
                          </div>
                        </td>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2 text-nowrap">
                            {{ tfDateThai(payWait.dateSelect) }}
                          </div>
                        </td>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2 text-nowrap">
                            {{ payWait.amountPrice.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                          </div>
                        </td>
                      </tr>
                      <tr v-if="payWait.hasTool === '1'">
                        <td></td>
                        <td>
                          <div class="mx-0 px-2 d-flex justify" v-if="payWait.hasClean">
                            (+49 บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด
                          </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td>{{ toolPirce.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>
                          <div class="mx-0 px-2 d-flex justify" v-if="payWait.hasClean">
                            {{ payWait.hasClean }} {{ payWait.workBuilding }} {{ payWait.startTime }}
                          </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                          <p></p>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                          <p></p>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2">
                          <div class="border-0 px-2 d-flex justify-content-between">ราคารวม: <b>{{(payWait.amountPrice + toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b></div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td class="px-2 d-flex justify-content-between border-0">
                          <div v-if="dataPromotion && dataPromotion.unit!='no'">{{ dataPromotion.name }}</div>
                        </td>
                        <td></td>
                        <td colspan="2">
                          <div class="px-2 d-flex justify-content-between">ส่วนลด: 
                            <div v-if="dataPromotion">
                              <div class="text-right">
                              <b>
                                {{dataPromotion.amount}}
                              </b>
                              <span v-if="dataPromotion.unit=='percent'">%</span>
                              <span v-if="dataPromotion.unit=='no'"></span>
                              <span class="text-small" v-else>บาท</span>
                            </div>
                              
                            </div>
                            <div v-else>
                              0.00
                            </div>
                          </div>
                            <div  v-if="dataPromotion && dataPromotion.unit=='percent'" class="text-small mb-0 text-muted w-100 text-right pe-2">ส่วนลด = {{parseFloat((payWait.amountPrice * dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }} บาท</div>
                          
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td colspan="3">
                          <div class="px-2 d-flex justify-content-between">ภาษีมูลค่าเพิ่ม {{dataSetting.eTax}}%: 
                            <!-- <div v-if="dataPromotion">
                              <b v-if="dataPromotion.unit=='percent'">
                                {{ parseFloat((payWait.amountPrice-(payWait.amountPrice * dataPromotion.amount / 100)+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </b>
                              <b v-else>
                                {{ parseFloat((payWait.amountPrice-payWait.amountPrice+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </b>
                            </div>
                            <b v-else>
                              {{ parseFloat(((payWait.amountPrice+toolPirce) * dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                            </b> -->
                            <b>{{ dataNoPay.total_vat }}</b>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="bg-gray-200"></td>
                        <td colspan="3" class="bg-dark">
                          <div class="px-2 d-flex justify-content-between text-white">ยอดเงินสุทธิ: 
                            <b>
                              {{ parseFloat(dataNoPay.amount_total).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,") }}
                            </b>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-8 col-sm-8 col-md-10 bg-white px-4 mb-4">
            <div class="row">
              <h5 class="py-3">การชำระเงิน</h5>
              <div class="col-3 col-md-2 col-lg-2 mx-4">
                <div v-for="(item, i) in bankData" :key="i">
                  <div v-if="myBankData.bank_type == item.id">
                    <img :src="item.img" :alt="item.shortname" class="around" width="85"><br />
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4 mb-4">
                <div v-for="(item, i) in bankData" :key="i">
                  <div v-if="myBankData.bank_type == item.id">
                    ธนาคาร: {{ item.name }}
                  </div>
                </div>
                <div class="border-button">ชื่อบัญชี: {{ myBankData.bank_name }} {{ myBankData.bank_surname }}</div>
                <div class="border-button text-nowrap">เลขที่บัญชี: {{ myBankData.bank_number }}
                  <span v-if="copy">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-check2-circle text-success" viewBox="0 0 16 16">
                      <path
                        d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0" />
                      <path
                        d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                    </svg>
                  </span>
                </div>
                <button class="btn btn-sm btn-outline-info border" @click="copyBankNumber">คัดลอก
                  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                    class="bi bi-copy ms-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                      d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z" />
                  </svg>
                </button>
              </div>

              <div class="col-12 col-md-6 mb-4 mx-md-0">
                <div class="form-control px-2" style="overflow: hidden;">
                  <div v-if="imageData" class="my-2">
                    <img :src="imageData" alt="Uploaded Image" class="w-100">
                  </div>
                  <label for="label">อัพโหลดสลิป *</label><br />
                  <input type="file" @change="uploadImage">

                </div>
                <button class="btn btn-success w-100 mt-2" v-if="imageData" @click="sendSlip">ยืนยันการชำระเงิน</button>
              </div>
            </div>
          </div>
          <!-- <div class="col-6 m-4 mx-md-0"></div> -->
        </div>
      </div>
    </div>
    <!-- modal download-->
    <div v-if="opSm" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h6 class="modal-title" id="exampleModalLongTitle">ใบกำกับภาษี/ใบเสร็จรับเงิน</h6>
            <button type="button" class="close text-white btn text-xl" @click="opSm = false"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="font-family:sans-serif;" >
            <div class="row">
              <div class="col-12 border px-2 mx-lg-0" id="receipt" v-if="dataSlip">
                <div class="row">
                  <div class="col-3 text-left d-flex align-items-center">
                    <img src="@/public/assets/images/messageImage_1710223947120.jpg" alt="logo" class="p-0 w-100">
                  </div>
                  <div class="col-7 col-md-5 text-lef py-3 px-0">
                    <div class="text-muted text-small p-0" style="font-family:sans-serif;font-size: .5rem;">
                      <span class="text-nowrap"> {{dataSetting.bname}}</span>                       <br>
                      {{dataSetting.baddress}}<br>
                      โทร. {{dataSetting.phone}} แฟกซ์ {{dataSetting.phone}} <br>
                      เลขประจำตัวผู้เสียภาษีอากร:{{dataSetting.vat_no}}/ สำนักงานใหญ่
                    </div>
                  </div>
                  <div class="col-12 col-md-4 text-lef py-md-3 pb-3 px-3 d-flex align-items-end justify-content-end">
                    <div class="border px-2 py-1 text-nowrap text-small text-center bg-gray-200" style="font-family:sans-serif;" >
                      ใบกำกับภาษี/ใบเสร็จรับเงิน
                    </div>
                  </div>

                </div>
                <div class="border" style="font-size:12px;line-height: 1rem;">
                  <div class="border-bottom px-2 py-1" style="font-family:sans-serif;" >
                    นามลูกค้า: 
                    <small class="text-muted" v-if="dataSlip.nickname">{{ dataSlip.nickname }}</small>
                    <small class="text-muted" v-else>{{ profile.fullname }}</small>
                  </div>
                  <div class="border-bottom px-2 py-0 d-flex align-items-center  justify-content-between">
                    <div style="font-family:sans-serif;width:70%" class="py-2">
                      ที่อยู่: <small class="text-muted small">{{ dataSlip.maddress }}</small>
                    </div>
                    <div class="my-0 py-2 px-0 border-date">
                      <div class="d-flex align-items-center justify-content-between">
                        <span style="font-family:sans-serif;" >วันที่:</span>  <span style="font-family:sans-serif;" >{{
                          thaiYearFormat(dataSlip.booking_create_at) }}</span></div>
                                        <div class="d-flex align-items-center justify-content-between"><span style="font-family:sans-serif;" >เลขที่:</span><span style="font-family:sans-serif;" >{{
                        dataSlip.bookId.toString().padStart(4, '0') }}</span>
                        </div>
                    </div>
                  </div>
                  <div class=" px-2 py-1" style="font-family:sans-serif;" >
                    เลขประจำตัวผู้เสียภาษี :  <small class="text-muted small" style="font-family:sans-serif;" >{{ dataSlip.mppcard }}</small>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-striped small" v-if="dataRecept.length>0">
                        <tbody>
                          <tr>
                            <th style="font-family:sans-serif;">ลำดับ</th>
                            <th style="font-family:sans-serif;">รายละเอียด</th>
                            <th style="text-align:center;font-family:sans-serif;">วันที่ชำระค่าบริการ</th>
                            <th style="text-align:center;font-family:sans-serif;">วันที่เข้าดำเนินการ</th>
                            <th style="font-family:sans-serif;">จำนวนเงิน</th>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2" v-if="dataSlip.fname">
                                1
                              </div>
                            </td>
                            <td class="text-nowrap mx-0 px-0">
                              <div class="mx-0 px-2 d-flex justify" style="font-family:sans-serif;"  v-if="dataSlip.fname">
                                บริการแม่บ้าน {{ dataSlip.fname }} {{ dataSlip.lname }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap" style="font-family:sans-serif;" >
                                {{ tfDateThai(dataSlip.booking_create_at) }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap " style="font-family:sans-serif;" >
                                {{ tfDateThai(dataSlip.dateSelect) }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap text-right" style="font-family:sans-serif;" >
                                {{ dataSlip.amountPrice.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </div>
                            </td>
                          </tr>
                          <tr v-if="dataSlip.hasTool==1">
                            <td></td>
                            <td>
                              <div class="mx-0 px-0 d-flex justify-content-end" style="font-family:sans-serif;" >
                                (+{{ toolPirce }} บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด
                              </div>
                            </td>
                            <td></td>
                            <td class="text-right" style="font-family:sans-serif;" >{{ dataRecept.tool_price  }}</td>
                            <td class="text-right" style="font-family:sans-serif;" >{{ dataRecept.tool_price.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>
                              <div class="mx-0 px-0 d-flex justify" style="font-family:sans-serif;"  v-if="dataSlip.hasClean">
                                {{ dataSlip.hasClean }} {{ dataSlip.workBuilding }} {{ dataSlip.startTime }}
                              </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                              <p></p>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                              <p></p>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <div v-if="dataSlip.isActive==2">
                                <img src="@/public/assets/images/emovebg-preview.png" alt="logo" class="p-0" style="position: absolute;
                                      left: 100px;
                                      width: 180px;
                                      margin-top: -35px;
                                      opacity: 0.6;
                                  transform: rotate(-16deg);">
                              </div>
                              <div  v-if="dataSlip.isActive>2">
                                <img src="@/public/assets/images/preview.png" alt="logo" class="p-0" style="position: absolute;
                                      left: 100px;
                                      width: 180px;
                                      margin-top: -35px;
                                      opacity: 0.6;
                                  transform: rotate(-16deg);">
                              </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td colspan="2">{{ (dataSlip.amountPrice )}}{{dataRecept.tool_price }}
                              <div class="px-0 d-flex justify-content-between" style="font-family:sans-serif;" >ราคารวม: <b style="font-family:sans-serif;" >{{parseFloat((dataSlip.amountPrice )+ dataRecept.tool_price).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b></div>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>
                              <div class="px-0 d-flex justify-content-between" style="font-family:sans-serif;"  v-if="dataRecept.promotion_name">{{ dataRecept.promotion_name }}</div>
                            </td>
                            <td></td>
                            <td colspan="2">
                              <div class="px-0 d-flex justify-content-between" style="font-family:sans-serif;" >ส่วนลด: 
                                <div v-if="dataRecept.promotion_amount">
                                  <b style="font-family:sans-serif;" >
                                    {{dataRecept.promotion_amount}}
                                  </b>
                                  <span style="font-family:sans-serif;" v-if="dataRecept.proType=='percent'">%</span>
                                  <span style="font-family:sans-serif;" v-if="dataRecept.proType=='no'"></span>
                                  <span style="font-family:sans-serif;" class="text-small" v-else>บาท</span>
                                </div>
                                <div v-else style="font-family:sans-serif;" >
                                  0.00
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                        <td></td>
                        <td></td>
                        <td colspan="3">
                          <div class="px-2 d-flex justify-content-between">ภาษีมูลค่าเพิ่ม {{dataSetting.eTax}}%: 
                            <b>{{ dataReceipt.total_vat }}</b>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="bg-gray-200"></td>
                        <td colspan="3" class="bg-dark">
                          <div class="px-2 d-flex justify-content-between text-white">ยอดเงินสุทธิ: 
                            <b>
                              {{ parseFloat(dataReceipt.amount_total).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,") }}
                            </b>
                          </div>
                        </td>
                      </tr>
                        </tbody>
                      </table>
                      <table class="table table-condensed table-bordered table-striped small" v-else>
                        <tbody>
                          <tr>
                            <th style="font-family:sans-serif;">ลำดับ</th>
                            <th style="font-family:sans-serif;">รายละเอียด</th>
                            <th style="text-align:center;font-family:sans-serif;">วันที่ชำระค่าบริการ</th>
                            <th style="text-align:center;font-family:sans-serif;">วันที่เข้าดำเนินการ</th>
                            <th style="font-family:sans-serif;">จำนวนเงิน</th>
                          </tr>
                        </tbody>
                        <tbody>
                          <tr>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2" v-if="payWait.fname" style="font-family:sans-serif;">
                                1
                              </div>
                            </td>
                            <td class="text-nowrap mx-0 px-0">
                              <div class="mx-0 px-2 d-flex justify" v-if="payWait.fname" style="font-family:sans-serif;">
                                บริการแม่บ้าน {{ payWait.fname }} {{ payWait.lname }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap"  style="font-family:sans-serif;">
                                {{ tfDateThai(payWait.booking_create_at) }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap"  style="font-family:sans-serif;">
                                {{ tfDateThai(payWait.dateSelect) }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap" style="font-family:sans-serif;">
                                {{ payWait.amountPrice.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </div>
                            </td>
                          </tr>
                          <tr v-if="payWait.hasTool === '1'">
                            <td></td>
                            <td>
                              <div class="mx-0 px-2 d-flex justify" v-if="payWait.hasClean" style="font-family:sans-serif;">
                                (+49 บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด
                              </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td style="font-family:sans-serif;">{{ toolPirce.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>
                              <div class="mx-0 px-2 d-flex justify" style="font-family:sans-serif;" v-if="payWait.hasClean">
                                {{ payWait.hasClean }} {{ payWait.workBuilding }} {{ payWait.startTime }}
                              </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                              <p></p>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                              <p></p>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>
                              <div v-if="dataSlip.isActive==2">
                                <img src="@/public/assets/images/emovebg-preview.png" alt="logo" class="p-0" style="position: absolute;
                                      left: 100px;
                                      width: 180px;
                                      margin-top: -35px;
                                      opacity: 0.6;
                                  transform: rotate(-16deg);">
                              </div>
                              <div  v-if="dataSlip.isActive>2">
                                <img src="@/public/assets/images/preview.png" alt="logo" class="p-0" style="position: absolute;
                                      left: 100px;
                                      width: 180px;
                                      margin-top: -35px;
                                      opacity: 0.6;
                                  transform: rotate(-16deg);">
                              </div>
                            </td>
                            <td></td>
                            <td colspan="2">
                              <div class="border-0 px-2 d-flex justify-content-between" style="font-family:sans-serif;">ราคารวม: <b>{{(payWait.amountPrice + toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b></div>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>
                              <div class="px-2 d-flex justify-content-between border-0" style="font-family:sans-serif;" v-if="dataPromotion && dataPromotion.unit!='no'">{{ dataPromotion.name }}</div>
                            </td>
                            <td></td>
                            <td colspan="2">
                              <div class="px-2 d-flex justify-content-between" style="font-family:sans-serif;">ส่วนลด: 
                                <div v-if="dataPromotion">
                                  <div class="text-right">
                                  <b style="font-family:sans-serif;">
                                    {{dataPromotion.amount}}
                                  </b>
                                  <span v-if="dataPromotion.unit=='percent'" style="font-family:sans-serif;">%</span>
                                  <span v-if="dataPromotion.unit=='no'"></span>
                                  <span class="text-small" v-else style="font-family:sans-serif;">บาท</span>
                                </div>
                                  
                                </div>
                                <div v-else style="font-family:sans-serif;">
                                  0.00
                                </div>
                              </div>
                                <!-- <div  v-if="dataPromotion" class="mb-0 text-muted w-100 text-right pe-2">ส่วนลด = {{parseFloat((payWait.amountPrice * dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }} บาท</div> -->
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                              <div class="px-2 d-flex justify-content-between" style="font-family:sans-serif;">ภาษีมูลค่าเพิ่ม {{dataSetting.eTax}}%: 
                                <!-- <div v-if="dataPromotion">
                                  <b v-if="dataPromotion.unit=='percent'">
                                    {{ parseFloat((payWait.amountPrice-(payWait.amountPrice * dataPromotion.amount / 100)+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                                  </b>
                                  <b v-else>
                                    {{ parseFloat((payWait.amountPrice-payWait.amountPrice+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                                  </b>
                                </div>
                                <b v-else>
                                  {{ parseFloat(((payWait.amountPrice+toolPirce) * dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                                </b> -->
                                <b style="font-family:sans-serif;">{{ dataNoPay.total_vat }}</b>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" class="bg-gray-200"></td>
                            <td colspan="3" class="bg-dark">
                              <div class="px-2 d-flex justify-content-between text-white"  style="font-family:sans-serif;">ยอดเงินสุทธิ: 
                                <b style="font-family:sans-serif;">
                                  {{ parseFloat(dataNoPay.amount_total).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,") }}
                                </b>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 border px-4 mb-5 mx-lg-0 text-center" v-else>
                ---
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" @click="downloadAsImage()" v-if="dataSlip.isActive>2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download"
                viewBox="0 0 16 16">
                <path
                  d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                <path
                  d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
              </svg>
              ดาวน์โหลด</button>
            <button type="button" class="btn btn-secondary" @click="opSm = false">ปิด</button>

          </div>
        </div>
      </div>
    </div>

    <!-- show comment -->
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
                <div class="d-flex justify-content-center text-center w-50 d-none">
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
                  <p><b>ที่อยู่:</b> {{ dataMaidShow.maidAddress }}</p>
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
                  <div class="tex-white text-small" v-if="dataMaidShow.myDesc">{{ dataMaidShow.myDesc }}</div>
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

            </p>
            <div v-if="profile && isReview" class="mt-2">
              <div class="row">
                <div class="col-6">
                  <div class="d-flex justify-content-start my-2 d-none" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star text-muted mx-1" viewBox="0 0 16 16">
                      <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star text-muted mx-1" viewBox="0 0 16 16">
                      <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star text-muted mx-1" viewBox="0 0 16 16">
                      <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star text-muted mx-1" viewBox="0 0 16 16">
                      <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-star text-muted mx-1" viewBox="0 0 16 16">
                      <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                    </svg>
                  </div>
                  <div class="d-flex justify-content-start my-2" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" @click="addStart(1,dataMaidShow.maid_id,dataMaidShow.bookId)"
                      class="bi bi-star-fill star text-warning mx-1" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" @click="addStart(2,dataMaidShow.maid_id,dataMaidShow.bookId)"
                      class=" star mx-1" :class="{'bi bi-star-fill text-warning':dataStar.stars>=2,'bi bi-star-fill text-muted':dataStar.stars<2}" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" @click="addStart(3,dataMaidShow.maid_id,dataMaidShow.bookId)"
                      class="bi bi-star-fill star text-warning mx-1"  :class="{'bi bi-star-fill text-warning':dataStar.stars>=3,'bi bi-star-fill text-muted':dataStar.stars<3}" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" @click="addStart(4,dataMaidShow.maid_id,dataMaidShow.bookId)"
                      class="bi bi-star-fill star text-warning mx-1" :class="{'bi bi-star-fill text-warning':dataStar.stars>=4,'bi bi-star-fill text-muted':dataStar.stars<4}" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" @click="addStart(5,dataMaidShow.maid_id,dataMaidShow.bookId)"
                      class="bi bi-star-fill star text-warning mx-1" :class="{'bi bi-star-fill text-warning':dataStar.stars==5,'bi bi-star-fill text-muted':dataStar.stars<5}" viewBox="0 0 16 16">
                      <path
                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                    </svg>
                  </div>
                </div>
                <div class="col-6 pt-2">ให้คะแนนดาว  <b class="text-warning" style="font-size: 30px;line-height: 1rem;">{{ dataStar.stars }}</b></div>
                <div class="col-12">
                  <label for="" class="text-muted">แสดงความคิดเห็น</label>
                  <textarea name="" id="" cols="30" rows="4" v-model="massage" class="form-control" placeholder=". . . ."></textarea>
                </div>
                <div class="col-12 text-right mt-2">
                  <button class="btn me-2 btn-info" @click="isModal=false">
                    เอาไว้ภายหลัง
                  </button>
                  <button class="btn btn-danger" @click="addMessage">
                    ให้คะแนน
                  </button>
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
import { format, addDays } from 'date-fns';
import { th } from 'date-fns/locale';
import Swal from 'sweetalert2';
import html2canvas from 'html2canvas';

export default {
  data() {
    return {
      dataStrLmt: 0,
      pagetotal: 0,
      total: 0,
      strlmt: 0,
      start: 0,
      limit: 5,
      dataBook: '',
      dataPromotion:'',
      dataBookForSearch: '',
      profile: '',
      dataMaidShow:'',
      dataReceipt:'',
      dataNoPay:'',
      isModal: false,
      isReview: true,
      massage:'',
      idRandom:'',
      opSm: false,
      stepTwo: false,
      copy: false,
      isDetail: false,
      payWait: '',
      dataSlip: '',
      toolPirce: 0,
      myBankData: '',
      imageData: '',
      dataSetting: '',
      dataRecept: '',
      dataStar: '',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL,
      bankData: [
        { "img": "https://www.logolynx.com/images/logolynx/ac/acc6db2f0532b74dff3f2525adbc56a3.jpeg", "id": "1", "shortname": "kbank", "name": "กสิกรไทย" },
        { "img": "https://media-exp1.licdn.com/dms/image/C510BAQElNZUFumis3Q/company-logo_200_200/0/1519912092504?e=2159024400&v=beta&t=UXn2iHDhq4cwYLoRjYxo3FgGkjJR3ekhlnDo-dw5KB4", "id": "2", "shortname": "scb", "name": "ไทยพาณิชย์" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXMiwU15ngT63kAECxWfVQUvzjkOsbB_ujb3VAlr1VZYThd1EQ_JxFNCTVC7TwuREYBb8&usqp=CAU", "id": "3", "shortname": "bbl", "name": "กรุงเทพ" },
        { "img": "https://upload.wikimedia.org/wikipedia/en/thumb/f/f0/Krung_Thai_Bank_logo.svg/220px-Krung_Thai_Bank_logo.svg.png", "id": "4", "shortname": "ktb", "name": "กรุงไทย" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGqrt4IpIhN4sOmI3du7EJiFmB50Z5sTHzd7TxmSDjLn1KF0pL38fjOZPa7vn3NJJqIkU&usqp=CAU", "id": "5", "shortname": "bay", "name": "กรุงศรีอยุธยา" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ0qwsNsBRVA1r0DkIg3DoYNfpRGrua_FQkIVSkM09LBJJOwKMT7NSIQugWZtHGq_hd_s&usqp=CAU", "id": "6", "shortname": "gsb", "name": "ออมสิน" },
        { "img": "https://media.glassdoor.com/sqll/11462/united-overseas-bank-squarelogo-1464075746597.png", "id": "7", "shortname": "uob", "name": "ยูโอบี" },
        { "img": "https://res.cloudinary.com/crunchbase-production/image/upload/c_lpad,h_170,w_170,f_auto,b_white,q_auto:eco,dpr_1/p8x01c4i9u0hmierixpe", "id": "8", "shortname": "lhb", "name": "แลนด์&เฮ้าส์" },
        { "img": "https://marketsavvy.co/wp-content/uploads/2020/04/GHlogo-300x300.jpg", "id": "9", "shortname": "ghb", "name": "อาคารสงเคราะห์" },
        { "img": "https://i.pinimg.com/originals/06/70/69/067069fcbe69567ec81b0240996c0632.png", "id": "11", "shortname": "ibank", "name": "อิสลามแห่งประเทศไทย" },
        { "img": "https://upload.wikimedia.org/wikipedia/en/f/f8/Tisco_logo.png", "id": "12", "shortname": "tisco", "name": "ทิสโก้" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJZHdAC3gRb5lGbO8Op2Qqui2LRh1mMRtgOk9SGkMigvTHDYyNZjl70oGDxN_IddXSpXM&usqp=CAU", "id": "13", "shortname": "kk", "name": "เกียรตินาคิน" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrs-WPHU6UjzNTDQILwK1x0WvRP0Un5eATlEaUb-llTIbrFUXEXGeO-HxooJoyhyKdE2A&usqp=CAU", "id": "14", "shortname": "baac", "name": "ธกส." },
        { "img": "http://www.logotaglines.com/wp-content/uploads/2016/11/JPMorgan-Chase-Co-Logo-487x365.jpg", "id": "15", "shortname": "jpm", "name": "เจพีมอร์แกนเชส " },
        { "img": "https://www.jobtopgun.com/content/filejobtopgun/logo_com_job/j3651.gif?_=13", "id": "16", "shortname": "ttb", "name": "ทหารไทยธนชาต" },
        { "img": "https://i.pinimg.com/originals/f0/52/4a/f0524a1937ff5b1e03c6c92ad014d821.png", "id": "17", "shortname": "tcrb", "name": "ไทยเครดิต" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPIvcD_NGgZzOu6QDrP_yFwaa1-GOuNtfwLLTLL9D3b40CveggydAII0ZudwhZqxwbdSc&usqp=CAU", "id": "18", "shortname": "citi", "name": "ซิตี้แบ้งค์" },
        { "img": "https://www.1213.or.th/App/MCPD/Resources/Images/fi/449176.png", "id": "19", "shortname": "smbc", "name": "ซูมิโตโมมิตซุย แบงกิ้ง" },
        { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRveApa65w_dnKgmRo2HrkL0lwLAxzQC5b9vYsNf3K8zmb8Pjq6rebYMOtCdqL8FKqP--U&usqp=CAU", "id": "20", "shortname": "cimb", "name": "ซีไอเอ็มบีไทย" },
        { "img": "https://1.bp.blogspot.com/-22UW_ctLnWo/XBzuZkP0RXI/AAAAAAAAAd0/rzpg3S5XQtswJoJ3cTWDYdHnqpQlOzYbgCK4BGAYYCw/s1600/Bank%2BMEGA%2B%255Bsiklogo.blogspot.com%255D.png", "id": "21", "shortname": "mega", "name": "เมกะสากลพาณิชย์" },
      ],
      dataNewReceipt:''
    }
  },
  mounted() {
    this.profile = JSON.parse(sessionStorage.getItem("Profile"));
    if (!this.profile) {
      setTimeout(() => {
        window.location=window.location.origin;
      }, 400);
    }
    this.getBooking();
    this.getSetting();
  },
  methods: {
    openCommentMaid(item) {
      this.isModal = true;
      this.dataMaidShow = item;
      this.dataStar={stars : 5};
    },
    addStart: async function (star,mid, bookId) {
      if(this.idRandom ==''){
        const timestamp = Date.now().toString(36); // แปลง timestamp เป็นเลขฐาน 36
        const randomStr = Math.random().toString(36).substr(2, 5); // สร้างสตริงสุ่มเพื่อเป็นส่วนต่อไปของรหัส
        this.idRandom = timestamp + randomStr;
      }
      this.dataStar = {
            stars:star,
            maid_id:mid,
            member_id:this.profile.member_id,
            commentId:  this.idRandom,
            book_id: bookId,
          }
    },
    addMessage: async function (star) {
      if(this.idRandom ==''){
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกคะแนนดาวก่อน',
          showConfirmButton: false,
        });
        return false;
      }
      this.dataStar.massage=this.massage;
      try {
        let config = {
          method: "post",
          url: this.apiBase + "/maids-star",
          headers: {
            "Content-Type": "application/json",
          },
          data:this.dataStar
        };

        await axios
          .request(config)
          .then((response) => {
            this.getBooking();
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: "ขอบคุณ "+response.data.message,
              showConfirmButton: true,
            }).then(() => {
              this.isModal=false;
            });
          })
          .catch((error) => {
            this.idRandom =='';
            console.log(error);            
          });

      } catch (error) {
        console.error(error);
      }
      /*
      try {
        let config = {
          method: "put",
          url: this.apiBase + "/maids-star/"+this.idRandom,
          headers: {
            "Content-Type": "application/json",
          },
          data:{
            massage:this.massage,
          }
        };

        await axios
          .request(config)
          .then((response) => {
            this.getBooking();
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: response.data.message,
              showConfirmButton: true,
            }).then(() => {
              this.isModal=false;
            });
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }

      */
    },
    downloadAsImage() {
      const element = document.getElementById('receipt'); // เปลี่ยนเป็น ID ของ HTML ที่ต้องการสร้างภาพ
      Swal.fire({
        position: "top-center",
        icon: "rerequest",
        title: 'ดาวนโหลดใบเสร็จรับเงิน',
        showConfirmButton: true,
      }).then(() => {
        html2canvas(element).then(canvas => {
          const imgData = canvas.toDataURL('image/jpeg');
          const a = document.createElement('a');
          a.href = imgData;
          const filename = 'madam-clean-Receipt' + this.reDateThai(new Date());
          a.download = filename + '.jpg'; // ชื่อไฟล์ที่ต้องการให้ดาวน์โหลด
          a.click();
        });
      });
    },
    handleSave: async function () {
      if(this.payWait.nickname==''){
        swal({
          position: "top-center",
          icon: "info",
          title: 'กรุณากรอก ชื่อนามสกุล ผู้เสียภาษี',
          showConfirmButton: false,
        });
        return false;
      }
      if(this.payWait.maddress==''){
        swal({
          position: "top-center",
          icon: "info",
          title: 'กรุณากรอก ที่อยู่ผู้เสียภาษี',
          showConfirmButton: false,
        });
        return false;
      }
      if(this.payWait.mppcard.length<13){
        swal({
          position: "top-center",
          icon: "info",
          title: 'กรุณากรอก เลขประจําตัวผู้เสียภาษี',
          showConfirmButton: false,
        });
        return false;
      }
      this.profile = JSON.parse(sessionStorage.getItem("Profile"));
      try {
        let config = {
          method: "put",
          url: this.apiBase + "/members/"+this.profile.member_id,
          headers: {
            "Content-Type": "application/json",
          },
          data: {
            mppcard:this.payWait.mppcard,
            maddress:this.payWait.maddress,
            nickname:this.payWait.nickname,
          }
        };

        await axios
          .request(config)
          .then((response) => {
            swal({
                position: "top-center",
                icon: "success",
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500
              });
             this.goPay();
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    getPromotion: async function () {
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
    getSetting: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/vat-for-maid",
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
    openDetail(date,i) {
      if($('#doo'+i).hasClass('d-block')){
        $('#doo'+i).addClass('d-none');
        $('#doo'+i).removeClass('d-block');
        $('#icon1'+i).addClass('d-block');
        $('#icon1'+i).removeClass('d-none');
      }else{
        $('#doo'+i).addClass('d-block');
        $('#doo'+i).removeClass('d-none');
        $('#icon1'+i).addClass('d-none');
        $('#icon1'+i).removeClass('d-block');
      }
    },
    reDateThai(date) {
      return format(new Date(date), 'd-MM-yyyy', { locale: th });
    },
    fullDateThai(date) {
      return format(new Date(date), ' d MMM yyyy', { locale: th });
    },
    fDateThai(date) {
      return format(new Date(date), ' d MMM yy', { locale: th });
    },
    tfDateThai(date) {
      // const newDate = addDays(new Date(date), -1); // ลด 1 วัน
      
        const currentDate = new Date(date).getDate();
        const thaiMonthNames = [
            "ม.ค.", "ก.พ.", "มี.ค.",
            "เม.ย.", "พ.ค.", "มิ.ย.",
            "ก.ค.", "ส.ค.", "ก.ย.",
            "ต.ค.", "พ.ย.", "ธ.ค."
        ];
        const currentMonth = thaiMonthNames[new Date(date).getMonth()]; // ใช้ชื่อเดือนไทยแทน
        const thaiYear = new Date(date).getFullYear() + 543; // แปลงปีเป็น พ.ศ.
        const currentYear = thaiYear.toString().slice(2); // ใช้เฉพาะสองตัวอักษรของปี

        return `${currentDate} ${currentMonth} ${currentYear}`;
    },
    thaiYearFormat(date) {
      const formattedDate = format(new Date(date), 'dd MMM yyyy', { locale: th });
      const year = parseInt(formattedDate.slice(-2), 10) + 543; // เอาสองหลักสุดท้ายของปีและเพิ่ม 543 เพื่อแปลงเป็น พ.ศ.
      return formattedDate.slice(0, -3) + year; // ตัด 'YY' และเปลี่ยนเป็น พ.ศ.
    },
    openSlip: async function(data) {
      this.getPromotion();
      let item = await Object.assign(data);
      this.fetchBank();
      this.opSm = true;
      this.dataSlip =  data;
      this.payWait =  data;
      if (this.dataSlip.hasTool === '1') {
        this.toolPirce = this.dataSetting.hasTool;
      } else {
        this.toolPirce = 0;
      }
      
      this.fetchReceipt();
      if(this.dataPromotion){
        // <!-- ราคารวมส่วนลดแล้ว -->
        if(this.dataPromotion.unit=='percent'){
          this.total_promotion_amount =parseFloat((this.dataSlip.amountPrice * this.dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
          this._amount  = parseFloat((this.dataSlip.amountPrice)-((this.dataSlip.amountPrice * this.dataPromotion.amount) / 100)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
          this.total_vat = parseFloat((this.dataSlip.amountPrice-(this.dataSlip.amountPrice * this.dataPromotion.amount / 100)+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        }else{
          this.total_promotion_amount =parseFloat(this.dataPromotion.amount).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");//ส่วนลดทีเป็นจำนวนบาท
          this._amount  = parseFloat((this.dataSlip.amountPrice-this.dataPromotion.amount)+this.toolPirce);
          this.total_vat = parseFloat((parseFloat(this._amount)*this.dataSetting.eTax)/100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        }
        this.amount_total = parseFloat(this.total_vat)+parseFloat(this._amount);
        let at = parseFloat(this.total_vat)+parseFloat(this._amount);
        this.dataNoPay = {
          bookId:this.dataSlip.bookId,
          promotionId:this.dataPromotion.id,
          total_vat:this.total_vat,
          total_promotion_amount:this.total_promotion_amount,
          vat:this.dataSetting.eTax,
          tool_price:this.toolPirce,
          amount_price:this.dataSlip.amountPrice,
          amount_total:at,
          promotion_amount:this.dataPromotion.amount,
          proType:this.dataPromotion.unit
        };
      }else{
        this._amount  =  parseFloat((this.dataSlip.amountPrice)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        this.total_vat = parseFloat((this.dataSlip.amountPrice+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
        let at = parseFloat(this.total_vat)+parseFloat(this._amount);
        this.dataNoPay = {
          bookId:this.dataSlip.bookId,
          promotionId:'',
          total_vat:this.total_vat,
          total_promotion_amount:0,
          vat:this.dataSetting.eTax,
          tool_price:this.toolPirce,
          amount_price:this.dataSlip.amountPrice,
          amount_total:at,
          promotion_amount:0,
          proType:''
        }
      }
    },
    formatDateThai(date) {
      return format(new Date(date), 'd MMM yy', { locale: th });
    },
    getBooking: async function () {
      try {
        this.profile = JSON.parse(sessionStorage.getItem("Profile"));
        let config = {
          method: "get",
          url: this.apiBase + "/booking-history/" + this.profile.member_id,
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataBook = response.data;
            this.dataBookForSearch = response.data;
            if (this.dataBook.length > 5 && this.dataBook.length < 10) {
              this.total = true;
              this.pagetotal = 1;
            } else {
              this.total = false;
              this.pagetotal = parseInt(this.dataBook.length / 5);
            }
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    toPay() {
      this.getPromotion();
      this.fetchBank();
      this.fetchPayWait();
      this.stepTwo = true;
    },
    fetchReceipt: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/fetchReceipt/" + this.dataSlip.bookId,
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            if(response.data.success==false){
              this.dataRecept = '';
            }else{
              this.dataRecept = response.data;
            }
          })
          .catch((error) => {
            this.dataRecept='';
            console.log(error);
          });

      } catch (error) {
        this.dataRecept='';
        console.error(error);
      }
    },
    fetchBank: async function () {
      const profile = JSON.parse(sessionStorage.getItem("Profile"));
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/bank/" + profile.member_id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": profile.token
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.myBankData = response.data[0];
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }

    },
    fetchPayWait: async function () {
      const profile = JSON.parse(sessionStorage.getItem("Profile"));
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/pay-history/" + profile.member_id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": profile.token
          },
        };

        await axios
          .request(config)
          .then((response) => {
            if (response.data) {
              this.payWait = response.data;
              this.dataSlip = response.data;
              if (this.payWait.hasTool == '1' || this.dataSlip.hasTool == '1') {
                this.toolPirce = this.dataSetting.hasTool;
              } else {
                this.toolPirce = 0;
              }
              if(this.payWait){
                if(this.dataPromotion){
                  // <!-- ราคารวมส่วนลดแล้ว -->
                  if(this.dataPromotion.unit=='percent'){
                    this.total_promotion_amount =parseFloat((this.payWait.amountPrice * this.dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                    this._amount  = parseFloat((this.payWait.amountPrice)-((this.payWait.amountPrice * this.dataPromotion.amount) / 100)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                    this.total_vat = parseFloat((this.payWait.amountPrice-(this.payWait.amountPrice * this.dataPromotion.amount / 100)+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  }else{
                    this.total_promotion_amount =parseFloat(this.dataPromotion.amount).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");//ส่วนลดทีเป็นจำนวนบาท
                    this._amount  = parseFloat((this.payWait.amountPrice-this.dataPromotion.amount)+this.toolPirce);
                    this.total_vat = parseFloat((parseFloat(this._amount)*this.dataSetting.eTax)/100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  }
                  this.amount_total = parseFloat(this.total_vat)+parseFloat(this._amount);
                  let at = parseFloat(this.total_vat)+parseFloat(this._amount);
                  this.dataNoPay = {
                    bookId:this.payWait.bookId,
                    promotionId:this.dataPromotion.id,
                    total_vat:this.total_vat,
                    total_promotion_amount:this.total_promotion_amount,
                    vat:this.dataSetting.eTax,
                    tool_price:this.toolPirce,
                    amount_price:this.payWait.amountPrice,
                    amount_total:at,
                    promotion_amount:this.dataPromotion.amount,
                    proType:this.dataPromotion.unit
                  };
                }else{
                  this._amount  =  parseFloat((this.payWait.amountPrice)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  this.total_vat = parseFloat((this.payWait.amountPrice+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  let at = parseFloat(this.total_vat)+parseFloat(this._amount);
                  this.dataNoPay = {
                    bookId:this.payWait.bookId,
                    promotionId:'',
                    total_vat:this.total_vat,
                    total_promotion_amount:0,
                    vat:this.dataSetting.eTax,
                    tool_price:this.toolPirce,
                    amount_price:this.payWait.amountPrice,
                    amount_total:at,
                    promotion_amount:0,
                    proType:''
                  }
                }
              }
            } else {
              this.payWait = '';
              this.dataSlip = '';
              this.toolPirce = 0;
            }
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    copyBankNumber() {
      const bankNumber = this.myBankData.bank_number;
      navigator.clipboard.writeText(bankNumber)
        .then(() => {
          // alert('คัดลอกเลขที่บัญชีเรียบร้อยแล้ว');
          this.copy = true;
        })
        .catch((err) => {
          console.error('ไม่สามารถคัดลอกเลขที่บัญชี:', err);
        });
      setTimeout(() => {
        this.copy = false;
      }, 2400);
    },
    uploadImage(event) {
      const file = event.target.files[0];
      const reader = new FileReader();
      this.imageData = URL.createObjectURL(file);

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
          this.imageUrl = base64Image;
        };
      };

      reader.readAsDataURL(file);
    },
    sendSlip: async function () {
      try {
        let config = {
          method: "put",
          url: this.apiBase + "/send-slip/" + this.payWait.bookId,
          headers: {
            "Content-Type": "application/json",
            "Authorization": sessionStorage.getItem("Profile").token
          },
          data: { receipt: this.imageUrl }
        };

        await axios
          .request(config)
          .then((response) => {
            if(this.payWait){
              if (this.payWait.hasTool == '1') {
                this.toolPirce = this.dataSetting.hasTool;
              }
              if(this.dataPromotion){
                // <!-- ราคารวมส่วนลดแล้ว -->
                if(this.dataPromotion.unit=='percent'){
                  this.total_promotion_amount =parseFloat((this.payWait.amountPrice * this.dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  this._amount  = parseFloat((this.payWait.amountPrice)-((this.payWait.amountPrice * this.dataPromotion.amount) / 100)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  this.total_vat = parseFloat((this.payWait.amountPrice-(this.payWait.amountPrice * this.dataPromotion.amount / 100)+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                }else{
                  this.total_promotion_amount =parseFloat(this.dataPromotion.amount).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");//ส่วนลดทีเป็นจำนวนบาท
                  this._amount  = parseFloat((this.payWait.amountPrice-this.dataPromotion.amount)+this.toolPirce);
                  this.total_vat = parseFloat((parseFloat(this._amount)*this.dataSetting.eTax)/100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                }
                this.amount_total = parseFloat(this.total_vat)+parseFloat(this._amount);
                let at = parseFloat(this.total_vat)+parseFloat(this._amount);
                this.dataNewReceipt = {
                  bookId:this.payWait.bookId,
                  promotionId:this.dataPromotion.id,
                  total_vat:this.total_vat,
                  total_promotion_amount:this.total_promotion_amount,
                  vat:this.dataSetting.eTax,
                  tool_price:this.toolPirce,
                  amount_price:this.payWait.amountPrice,
                  amount_total:at,
                  promotion_amount:this.dataPromotion.amount,
                  proType:this.dataPromotion.unit
                };
                this.saveReceipt(this.dataNewReceipt);
              }else{
                this._amount  =  parseFloat((this.payWait.amountPrice)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                this.total_vat = parseFloat((this.payWait.amountPrice+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                let at = parseFloat(this.total_vat)+parseFloat(this._amount);
                this.dataNewReceipt = {
                  bookId:this.payWait.bookId,
                  promotionId:'',
                  total_vat:this.total_vat,
                  total_promotion_amount:0,
                  vat:this.dataSetting.eTax,
                  tool_price:this.toolPirce,
                  amount_price:this.payWait.amountPrice,
                  amount_total:at,
                  promotion_amount:0,
                  proType:''
                }
                this.saveReceipt(this.dataNewReceipt);
              }
            }
            this.getBooking();
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: 'ชำระเงินเรียบร้อย  จองบริการแม่บ้านสำเร็จแล้ว',
              showConfirmButton: true,
            }).then(() => {
              this.$router.push('/history');
              this.stepTwo=false;
            });
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    saveReceipt: async function (data) {
      try {
        let config = {
          method: "post",
          url: this.apiBase + "/receipt",
          headers: {
            "Content-Type": "application/json",
          },
          data:data
        };

        await axios
          .request(config)
          .then((response) => {
            console.log(response.data);
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
  }
}
</script>

<style scope>
.w-60 {
  width: 60%;
}

.w-40 {
  width: 40%;
}

.vuejs-datepicker {
  font-family: 'Tahoma', sans-serif;
}

.text-right {
  text-align: right;
}

.bg-gray-300 {
  background-color: #dee2e6 !important;
}

.bg-gray-200 {
  background-color: #e9ecef !important;
}

.paid-preview {
  position: absolute;
  width: 144px;
  margin-top: -117px;
  margin-left: -39px;
  opacity: 0.8;
}

.unpaid-preview {
  position: absolute;
  width: 144px;
  margin-top: -192px;
  margin-left: -39px;
  opacity: 0.8;
}

@media (max-width: 768px) {
  .calendar{
    position: absolute;margin-top: 150px;width:450px;z-index:2;
  }

  .table.table-condensed.table-bordered.table-striped.small{
    font-size: 14px;
  }
}

@media (max-width: 480px) {
  .table.table-condensed.table-bordered.table-striped.small{
    font-size: 10px;
  }
  .calendar{
    position: absolute;margin-top: 150px;width:332px;z-index:2;
  }
  .span12 table.table.table-condensed{
    font-size: 12px;
  }
}
.d-calendar:hover {
  background-color: #ff0202;
  color: #fff;

}

.text-danger.text-small{
  color: #fff;
}
.d-calendar.d-calendar-active {
  background-color: #ff0202;
  color: #fff;
}

table.border {
  border-collapse: collapse;
  width: 100%;
}

table.border th,
table.border td {
  border: 1px solid #dee2e6;
  padding: 8px 0px;
  text-align: center;
  font-size: 0.8rem;
}

.btn-closes {
  position: absolute;
  right: 0;
  width: 50px;
}

.div-time {
  padding: 4px;
}

.div-time:hover {
  border-bottom: 2px solid #7b7e80;
  background-color: #dee2e6;
  padding: 4px;
}

td .bg-gray{
  background-color: #dee2e6;
}
</style>