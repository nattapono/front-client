<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">
      <div class="col-12">
        <div class="card">
          <h6 class="header-pretitle">Overview</h6>
          <div class="card-header">
            <h1 class="card-header-title">ข้อมูลแม่บ้าน</h1>
            <div class="d-flex justify-content-between">
              <input type="text" class="form-control me-2" v-model="nameSearch" @change="filteredMaids()">
              <select v-model="selectedStatus" @change="filteredMaids">
                <option value="">ทั้งหมด</option>
                <option value="1">ปฏิบัติงาน</option>
                <option value="2">ไม่เข้างาน</option>
                <option value="4">รอยืนยันบัญชี</option>
              </select>
            </div>
            <nuxt-link to="addmaid" class="btn btn btn-primary">เพิ่มแม่บ้าน</nuxt-link>

          </div>
          <div class="table-responsive">
            <table class="table-nowrap card-table table table-sm">
              <thead>
                <tr>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px">Maid
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px">สถานะ
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px">จำนวนงาน</th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px">คะแนน</th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px">วันที่</th>
                  <th colspan="1" class="text-end" style="font-size:18px">จัดการ</th>
                  <th colspan="1" class="text-end">&nbsp;</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="!dataMaids || dataMaids.length < 1">
                  <td colspan="7" class="text-center text-muted"> ไม่มีข้อมูล </td>
                </tr>
                <tr v-for="(rows, i) in dataMaids" :key="i">
                  <td>{{ rows.fname }} {{ rows.lname }}</td>
                  <td>
                    <div v-if="rows.status == 4">
                      <button class="btn btn-sm btn-warning" @click="handleData(rows)">
                        <span class="text-danger">●</span> รอยืนยันบัญชี
                      </button>
                    </div>
                    <div v-if="rows.status == 3">
                      <button class="btn btn-sm btn-danger" @click="handleData(rows)">
                        <span class="text-white">●</span> ปฏิเสธ
                      </button>
                    </div>
                    <div v-else-if="rows.status == 1"><span class="text-success">●</span> ปฏฺบัติงาน</div>
                    <div v-else-if="rows.status == 2"><span class="text-muted">●</span> ไม่เข้างาน</div>
                    <div v-else-if="rows.status !=3"><span class="text-success">●</span> พักงาน</div>

                  </td>
                  <td>0</td>
                  <td>15</td>
                  <td><time datetime="2018-08-26">{{ formatDateThai(rows.create_at) }}</time></td>
                  <td class="text-end">
                    <div class="avatar-group">
                      <button class="btn btn-sm btn-outline-info" @click="handleData(rows)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-eye" viewBox="0 0 16 16">
                          <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                          <path
                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                      </button>
                      <button class="btn btn-sm btn-outline-primary mx-1" @click="openModal(rows, 'edit')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-pencil-square" viewBox="0 0 16 16">
                          <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                          <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                        </svg>
                      </button>
                      <button class="btn btn-sm btn-outline-danger" @click="openModal(rows, 'del')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-trash text-danger" viewBox="0 0 16 16">
                          <path
                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                          <path
                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                      </button>
                    </div>
                  </td>

                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div v-if="isModalData" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h3 class="modal-title" id="exampleModalLongTitle">ข้อมล {{ appData.fname + ' ' + appData.lname }}</h3>
            <button type="button" class="close text-white btn text-xl" @click="isModalData = false"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="" id="approve">
              <div>
                <div class="row">
                  <div class="col-12  mb-2 bg-muted p-2">
                    <p class="mb-0 font-weight-bold">ชื่อ-นามสกุล</p>
                      {{ appData.fname }} {{ appData.lname }}
                  </div>
                  
                  <div class="col-12  mb-2 bg-muted p-2">
                    <p class="mb-0 font-weight-bold">อีเมล์</p>
                      {{ appData.email }}
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <p class="mb-0 font-weight-bold">เบอร์โทร</p>
                      {{ appData.phone }}
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <p class="mb-0 font-weight-bold">ที่อยู่</p>
                      {{ appData.address }}
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <p class="mb-0 font-weight-bold">เลขบัตรประชาชน(13หลัก) </p>
                      {{ appData.ppCard }}
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <p class="mb-0 font-weight-bold">วัน/เดือน/ปี เกิด </p>
                      {{ appData.birthDay }}
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">สัญชาติไทย </p>
                      <div class="form-check mx-4 text-left">
                        <label class="form-check-label" v-if="appData.thaiNationality == 1" for="thaiNationalityYes">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ใช่</label>
                        <label class="form-check-label" for="thaiNationalityNo" v-else>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ไม่ใช่</label>
                      </div>

                    </div>
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">ประสบการณ์การทำงานแม่บ้าน </p>
                      <div class="form-check mx-4 text-left">
                        <label class="form-check-label" v-if="experience < 6" for="experience1Year">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          {{ appData.experience }} ปี</label>
                        <label class="form-check-label" v-else for="experience2Years">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          มากกว่า 5 ปี</label>
                      </div>

                    </div>


                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">เดินทางได้ในรัศมี 10 - 15 กม. (กทม. นนทบุรี สมุทรปราการ หรือปทุมธานี)
                        </p>
                      <div class="form-check mx-4 text-left">
                        <label class="form-check-label" v-if="appData.workIn == 1" for="experience1Year">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ได้</label>
                        <label class="form-check-label" v-else for="experience2Years">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ไม่ได้</label>
                      </div>

                    </div>
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">ปัจจุบันทำงานกี่วัน/สัปดาห์ (กรณีมีงานทำ) </p>

                      <div class="form-check mx-4 text-left">
                        <label class="form-check-label" for="experience7Years">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          {{ appData.workOn }} วัน</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">สามารถทำงานกับเราได้กี่วัน/สัปดาห์ </p>
                      <div class="form-check mx-4 text-left">
                        <label class="form-check-label" for="experience1Year">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          {{ appData.workDays }} วัน</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">ยืนยันว่าไม่เคยมีประวัติอาชญากรรม </p>
                      <div class="form-check mx-4 text-left">

                        <label class="form-check-label" for="concentYes" v-if="appData.noCriminalHistory">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          มี</label>
                        <label class="form-check-label" for="concentNo" v-else>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ไม่มี</label>
                      </div>

                    </div>
                  </div>
                  <div class="col-12  mb-2 bg-muted p-2">
                    <div class="">
                      <p class="mb-0 font-weight-bold">คุณยินยอมให้เปิดเผยข้อมูลส่วนบุคคลแก่บริษัทเพื่อใช้ประเมินการรับสมัครงาน
                        </p>
                      <div class="form-check mx-4 text-left">
                        <label class="form-check-label" for="thaiNationalityYes" v-if="appData.personalDataConsent==1">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ยินยอม</label>
                        <label class="form-check-label" for="thaiNationalityNo" v-else>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle-fill text-primary mx-1" viewBox="0 0 16 16">
                            <path
                              d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                          </svg>
                          ไม่ยินยอม</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 d-none mb-4 bg-muted p-2">
                    <div class="  ">
                      <p class="mb-0 font-weight-bold">ตำเหน่งของคุณ</p>
                      <div class="d-flex justify-content-start">

                        <p>Latitude: <span v-if="!latitude" class="text-muted mx-2">
                            <small><i>กำลังค้นหา..</i></small></span> <span class="text-primary" v-else>{{ latitude
                            }}</span></p>
                        <p class=" mx-2"> Longitude: <span class="text-muted mx-2"
                            v-if="!longitude"><small><i>กำลังค้นหา..</i></small></span> <span class="text-primary"
                            v-else>{{ longitude }}</span></p>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" v-if="appData.status==4">
            <button type="button" class="btn btn-danger" @click="confirmApprove(3)">ปฏิเสธ</button>
            <button type="button" class="btn btn-success" @click="confirmApprove(1)">ยืนยัน</button>
          </div>
          <div class="modal-footer" v-else>
            <button type="button" class="btn btn-danger px-4" @click="isModalData = false">ปิด</button>
          </div>
        </div>
      </div>
    </div> <!-- modal -->
    <div v-if="statusApprove" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h3 class="modal-title" id="exampleModalLongTitle">ยืนยันบีญชี</h3>
            <button type="button" class="close text-white btn text-xl" @click="statusApprove = false"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="text-center" id="approve">
              <div>
                <div class="row">
                  <div class="col-12 col-md-6">
                    <p class="text-center">ยืนยันข้อมูล <b>{{ appData.fname + ' ' + appData.lname }}</b></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" @click="statusApprove = false">ปิด</button>
            <button type="button" class="btn btn-success" @click="confirmApprove">ยืนยัน</button>
          </div>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div v-if="openLocation" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h3 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h3>
            <button type="button" class="close text-white btn text-xl" @click="openLocation = false"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>
              <div class="row" v-if="action == 'edit'">
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <p>ชื่อ</p>
                    <input type="text" name="" id="" v-model="dataItem.fname" class="form-control" placeholder="กรอกชื่อ">
                  </div>
                </div>
                <div class="col-12 col-md-6">
                  <div class="form-group">
                    <p>นามสกุล</p>
                    <input type="text" name="" id="" v-model="dataItem.lname" class="form-control"
                      placeholder="กรอกนามสกุล">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <p>อีเมล์</p>
                    <input type="text" name="" id="" v-model="dataItem.email" class="form-control"
                      placeholder="กรอกอีเมล์">
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group">
                    <p>ที่อยู่</p>
                    <input type="text" name="" id="" v-model="dataItem.address" class="form-control"
                      placeholder="กรอกที่อยู่">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <p>เบอร์โทร</p>
                    <input type="text" name="" id="" v-model="dataItem.phone" class="form-control"
                      placeholder="กรอกเบอร์โทร">
                  </div>
                </div>
              </div>
              <div class="row" v-else>
                <h4 class="text-center">ลบข้อมูล <b>{{ dataItem.fname + ' ' + dataItem.lname }}</b></h4>
                <h1 class="text-center mt-4">
                  <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor"
                    class="bi bi-trash text-danger" viewBox="0 0 16 16">
                    <path
                      d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                    <path
                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                  </svg>
                </h1>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="openLocation = false">ปิด</button>
            <button type="button" class="btn btn-primary" v-if="action == 'edit'" @click="handleEdit()">{{
              textTitle
            }}</button>
            <button type="button" class="btn btn-primary" v-else @click="handleDel()">{{ textTitle
            }}</button>
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
      action: '',
      isLogin: true,
      dateNow: new Date().toISOString().substr(0, 10),
      dataMaids: [],
      dataItem: '',
      textTitle: '',
      nameSearch: '',
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
      dataMaidsForSearch: '',
      openLocation: false,
      statusApprove: false,
      isModalData: false,
      selectedStatus: '',
      appData: '',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    }
  },

  watch: {

  },
  mounted() {
    this.getMaid();
    const currentDate = new Date();

    // ดึงค่าเดือนปัจจุบัน
    const currentMonth = currentDate.getMonth();

    // เก็บค่าเดือนปัจจุบันลงในข้อมูลของ Vue
    this.currentMonth = currentMonth;
    this.filteredMaids();
  },

  methods: {
    filteredMaids() {
      if (this.nameSearch && this.selectedStatus) {
        this.dataMaids = this.dataMaidsForSearch.filter(maid => maid.fname == this.nameSearch && maid.status == this.selectedStatus);
      } else if (this.nameSearch && !this.selectedStatus) {
        this.dataMaids = this.dataMaidsForSearch.filter(maid => maid.fname == this.nameSearch);
      } else if (!this.nameSearch && this.selectedStatus) {
        this.dataMaids = this.dataMaidsForSearch.filter(maid => maid.status == this.selectedStatus);
      } else {
        this.getMaid(); // กรณีที่ไม่มีการกรอง
      }
      console.log(this.dataMaids);
    },
    formatDateThai(date) {
      return format(new Date(date), 'MMM d, yyyy', { locale: th });
    },
    handleData(data) {
      this.isModalData = true;
      this.appData = data;
    },
    openModalApprove(data) {
      this.statusApprove = true;
      this.appData = data;
    },
    openModal(rows, action) {
      this.openLocation = true;
      this.dataItem = rows;
      if (action == 'edit') {
        this.action = 'edit';
        this.textTitle = 'แก้ไขข้อมูล';
      } else {
        this.action = 'del';
        this.textTitle = 'ลบข้อมูล';
      }
      this.dataItem.password = '';


    },
    getMaid: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/maids",
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Admin-mdc").token
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
    handleDel: async function () {
      try {
        let config = {
          method: "delete",
          url: this.apiBase + "/maid/" + this.dataItem.id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Admin-mdc").token
          },
          data: {},
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
    },
    handleEdit: async function () {
      try {
        let config = {
          method: "put",
          url: this.apiBase + "/maid/" + this.dataItem.id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Admin-mdc").token
          },
          data: {
            fname: this.dataItem.fname,
            lname: this.dataItem.lname,
            address: this.dataItem.address,
            email: this.dataItem.email,
            phone: this.dataItem.phone,
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
    },
    confirmApprove: async function (approve) {
      try {
        let config = {
          method: "put",
          url: this.apiBase + "/confirm-approve/" + this.appData.id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Admin-mdc").token
          },
          data: {
            status:approve
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
.bg-muted{
  background-color:#ffdfdf;
  border-radius: 8px;

}

.font-weight-bold{
  font-weight: bold;
}
</style>