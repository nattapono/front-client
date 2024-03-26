<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center" v-if="stepTwo == false">
      <div class="col-12 my-4 pb-2"></div>
      <div class="col-12 col-lg-10 col-md-10 px-4 px-md-0">
        <h4>ประวัติการจอง</h4>
        <div class="table-responsive mt-2">
          <table class="table" style="min-height: 350px;">
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
                <td colspan="7" v-if="dataBook.length == 0" class="text-center py-5 text-muted">
                  <div class="py-4 mb-5">
                    - No Data -
                  </div>
                </td>
              </tr>
            </tbody>
            <tbody v-for="(booking, i) in dataBook" :key="booking.bookId" >
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
    </div>
    <div class="row d-flex justify-content-center" v-if="stepTwo == true">
      <div class="col-12 col-lg-8 col-sm-8 ">
        <div class="row d-flex justify-content-center mt-4">
          <div class="col-12 col-md-9 px-4 px-md-0  d-flex justify-content-between">
            <h4>รอชำระเงิน</h4>
            <h4 @click="stepTwo = false" class="text-info cursor-pointer">
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

          <div class="col-12 col-lg-9 border px-4 mb-5 mx-lg-0">
            <div class="row">
              <div class="col-4 text-left">
                <img src="@/public/assets/images/messageImage_1710223947120.jpg" alt="logo" class="p-2 w-100">
              </div>

              <div class="col-8 text-lef pt-2">
                <small class="text-muted" style="font-size:12px;" v-html="dataSetting.bname"></small>
                <small class="text-muted" style="font-size:12px;" v-html="dataSetting.baddress"></small>
              </div>

            </div>
            <div class="border">
              <div class="border-bottom px-2 py-1">
                นามลกค้า: <small class="text-muted">{{ payWait.mfname }} {{ payWait.mlname }}</small>
              </div>
              <div class="border-bottom px-2 py-1">
                ที่อยู่: <small class="text-muted small">{{ payWait.showAddress }}</small>
              </div>
              <div class=" px-2 py-1">
                เลขประจำตัวผู้เสียภาษี :
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
                        <th>วันที่เอกสาร</th>
                        <th>ครบกำหนด</th>
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
                          <div class="mx-0 px-2 d-flex justify" style="font-size:0.rem;" v-if="payWait.fname">
                            บริการแม่บ้าน {{ payWait.fname }} {{ payWait.lname }}
                          </div>
                        </td>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2 text-nowrap">
                            {{ fDateThai(payWait.create_at) }}
                          </div>
                        </td>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2 text-nowrap">
                            {{ fDateThai(payWait.dateSelect) }}
                          </div>
                        </td>
                        <td class="mx-0 px-0">
                          <div class="mx-0 px-2 text-nowrap">
                            {{ payWait.amountPrice.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                          </div>
                        </td>
                      </tr>
                      <tr v-if="payWait.hasTool == '1'">
                        <td></td>
                        <td>
                          <div class="mx-0 px-2 d-flex justify" style="font-size:0.rem;" v-if="payWait.hasClean">
                            (+{{ dataSetting.hasTool }} บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด</div>
                        </td>
                        <td></td>
                        <td></td>
                        <td>{{ toolPirce.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td>
                          <div class="mx-0 px-2 d-flex justify" style="font-size:0.rem;" v-if="payWait.hasClean">
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
                          <div class="px-2 d-flex justify-content-between">ราคารวม: <b>{{ (payWait.amountPrice +
      toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b></div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2">
                          <div class="px-2 d-flex justify-content-between">ส่วนลด: <b></b></div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2">
                          <div class="px-2 d-flex justify-content-between">ภาษีมูลค่าเพิ่ม / 7%:
                            <b>{{ parseFloat((payWait.amountPrice + toolPirce) * 7 / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                        <td colspan="2" class="bg-dark">
                          <div class="px-2 d-flex justify-content-between text-white">ยอดเงินสุทธิ:
                            <b>{{ parseFloat((((payWait.amountPrice + toolPirce) * 7) / 100) + (toolPirce +
                              payWait.amountPrice)).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-10 px-4">
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
    <!-- modal -->
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
          <div class="modal-body">
            <div class="row">
              <div class="col-12 border px-2 mx-lg-0" id="receipt" v-if="dataSlip">
                <div class="row">
                  <div class="col-3 text-left d-flex align-items-center">
                    <img src="@/public/assets/images/messageImage_1710223947120.jpg" alt="logo" class="p-0 w-100">
                  </div>
                  <div class="col-7 col-md-5 text-lef py-3 px-0">
                    <div class="text-muted text-small p-0" style="font-size: 10px;" v-html="dataSetting.bname"></div>
                    <div class="text-muted text-small p-0" style="font-size: .5rem;" v-html="dataSetting.baddress"></div>
                  </div>
                  <div class="col-12 col-md-4 text-lef py-md-3 pb-3 px-3 d-flex align-items-end  justify-content-end">
                    <div class="border px-2 py-1 text-nowrap text-small text-center bg-gray-200"> ใบกำกับภาษี/ใบเสร็จรับเงิน
                    </div>
                  </div>

                </div>
                <div class="border" style="font-size:12px;line-height: 1rem;">
                  <div class="border-bottom px-2 py-1">
                    นามลกค้า: <small class="text-muted">{{ dataSlip.title }}{{ dataSlip.mfname }} {{ dataSlip.mlname }}</small>
                  </div>
                  <div class="border-bottom px-2 py-0 d-flex align-items-center  justify-content-between">
                    <div style="width:78%" class="py-2">
                      ที่อยู่: <small class="text-muted small">{{ dataSlip.showAddress }}</small>
                    </div>
                    <div class="my-0 p-2 border-date">
                      <div class="d-flex align-items-center justify-content-between"><span>วันที่:</span> <span>{{ fDateThai(dataSlip.create_at) }}</span></div>
                      <div class="d-flex align-items-center justify-content-between"><span>เลขที่:</span><span>{{ dataSlip.bookId.toString().padStart(4, '0') }}</span></div> 
                    </div>
                  </div>
                  <div class=" px-2 py-1">
                    เลขประจำตัวผู้เสียภาษี :
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
                            <th>วันที่เอกสาร</th>
                            <th>ครบกำหนด</th>
                            <th>จำนวนเงิน</th>
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
                              <div class="mx-0 px-2 d-flex justify" style="font-size:0.rem;" v-if="dataSlip.fname">
                                บริการแม่บ้าน {{ dataSlip.fname }} {{ dataSlip.lname }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap">
                                {{ fDateThai(dataSlip.create_at) }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap">
                                {{ fDateThai(dataSlip.dateSelect) }}
                              </div>
                            </td>
                            <td class="mx-0 px-0">
                              <div class="mx-0 px-2 text-nowrap">
                                {{ dataSlip.amountPrice.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </div>
                            </td>
                          </tr>
                          <tr v-if="dataSlip.hasTool == '1'">
                            <td></td>
                            <td class="text-nowrap mx-0 px-0">
                              <div class="mx-0 px-2 d-flex justify" style="font-size:0.rem;" v-if="dataSlip.hasClean">
                                (+{{ dataSetting.hasTool }} บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด
                              </div>
                            </td>
                            <td></td>
                            <td></td>
                            <td>{{ toolPirce.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td class="text-nowrap mx-0 px-0">
                              <div class="mx-0 px-2 d-flex justify-content-start" style="font-size:0.rem;"
                                v-if="dataSlip.hasClean">
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
                            <td></td>
                            <td></td>
                            <td colspan="3">
                              <div class="px-2 d-flex justify-content-between">ราคารวม: <b>{{ (dataSlip.amountPrice +toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b></div>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                              <div class="px-2 d-flex justify-content-between">ส่วนลด: <b></b></div>
                            </td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td colspan="3">
                              <div class="px-2 d-flex justify-content-between">ภาษีมูลค่าเพิ่ม / 7%:
                                <b>{{ parseFloat((dataSlip.amountPrice + toolPirce) * 7 / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" class="bg-gray-300">
                              <img src="@/public/assets/images/paid-preview.png" alt="paid" class="paid-preview" v-if="dataSlip.isActive>2">
                            </td>
                            <td colspan="3" class="bg-dark">
                              <div class="px-2 d-flex justify-content-between text-white">ยอดเงินสุทธิ:
                                <b>{{ parseFloat((((dataSlip.amountPrice + toolPirce) * 7) / 100) + (toolPirce +
                                  dataSlip.amountPrice)).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}</b>
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
            <button type="button" class="btn btn-primary" @click="downloadAsImage()">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
  <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/>
  <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/>
</svg>
 ดาวน์โหลด</button>
            <button type="button" class="btn btn-secondary" @click="opSm = false">ปิด</button>
            
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
import Swal from 'sweetalert2';
import html2canvas from 'html2canvas';

export default {
  data() {
    return {
      dataStrLmt: 0,
      pagetotal: 0,
      total: 0,
      strlmt: 0,
      start:0,
      limit:5,
      dataBook: '',
      dataBookForSearch: '',
      profile: '',
      opSm: false,
      stepTwo: false,
      copy: false,
      payWait: '',
      dataSlip: '',
      toolPirce:0,
      myBankData: '',
      imageData: '',
      dataSetting:'',
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
    }
  },

  watch: {

  },
  mounted() {

    this.getBooking();
    this.getSetting();
  },
  methods: {
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
    getSetting: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/vat-for-maid",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": localStorage.getItem("Admin-mdc").token
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
    reDateThai(date) {
      return format(new Date(date), 'd-MM-yyyy', { locale: th });
    },
    fDateThai(date) {
      return format(new Date(date), ' d MMM yy', { locale: th });
    },
    openSlip(data) {
      this.fetchBank();
      // this.fetchPayWait();
      
      this.opSm = true;
      this.dataSlip = data;
      if(this.dataSlip.hasTool==='1'){
        this.toolPirce = this.dataSetting.hasTool;
      }else{
        this.toolPirce = 0;
      }
    },
    formatDateThai(date) {
      return format(new Date(date), 'd MMM yy', { locale: th });
    },
    getBooking: async function () {
      try {
        this.profile = JSON.parse(localStorage.getItem("Profile"));
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
      this.fetchBank();
      this.fetchPayWait();
      this.stepTwo = true;
    },
    fetchBank: async function () {
      const profile = JSON.parse(localStorage.getItem("Profile"));
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
      const profile = JSON.parse(localStorage.getItem("Profile"));
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/pay/" + profile.member_id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": profile.token
          },
        };

        await axios
          .request(config)
          .then((response) => {
            if(response.data){
              this.payWait = response.data;
              this.dataSlip = response.data;
              if (this.payWait.hasTool == '1' || this.dataSlip.hasTool == '1') {
                this.toolPirce = this.dataSetting.hasTool;
              }else{
                this.toolPirce = 0;
              }
            }else{
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
            "Authorization": localStorage.getItem("Profile").token
          },
          data: { receipt: this.imageUrl }
        };

        await axios
          .request(config)
          .then((response) => {
            Swal.fire({
              position: "top-center",
              icon: "success",
              title: 'ชำระเงินเรียบร้อย  จองบริการแม่บ้านสำเร็จแล้ว',
              showConfirmButton: true,
            }).then(() => {
              this.$router.push('/history');
            });
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

.bg-gray-300 {
  background-color: #dee2e6 !important;
}

.bg-gray-200 {
  background-color: #e9ecef !important;
}

.paid-preview {
  position: absolute;
  width: 207px;
  margin-top: -165px;
  margin-left: -89px;
  opacity: 0.8;
}


</style>