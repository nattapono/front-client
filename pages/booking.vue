<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center"  v-if="!checkBooking && loading">
      <div class="col-12 my-2 py-2 d-flex align-items-center justify-content-center  vh-80">
        <div class="border rounded mt-5 m-2 p-4 w-50 text-center d-flex align-items-center justify-content-center" style="height:200px">
          ยังไม่ถึงเวลาทำการ<br />
         เปิดเวลา: {{ timeIn(dataSetting.timeIn)}}น.
        </div>
      </div>
    </div>
    <div class="row mb-5 d-flex align-items-center justify-content-center" v-else-if="loading">
      <div class="col-12 my-2 py-2 bg-warning d-flex align-items-center justify-content-center"
        style="position: fixed;top: 52px;" v-if="payWait">
        มีรายการรอชำระเงิน
        <button class="btn btn-sm  bg-white ms-2" @click="goPay">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-exclamation-circle text-danger me-2" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
            <path
              d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
          </svg>
          ชำระเงิน</button>
      </div>
      <div class="col-12 my-5 py-2" v-if="payWait"></div>
      <div class="col-12 my-3 py-2" v-else></div>
      <div class="col-12 col-lg-8 col-sm-8 col-md-10" v-if="stepOne == true">
        <h4 class="ms-2">จองแบบครั้งเดียว</h4>
        <div class="row  mt-2">
          <div class="col-1 ms-2 text-right font-weight-bold" style="border-right:solid 4px #ccc;">
            1
          </div>
          <div class="col-10">
            <div class="form-group">
              <label for="label">สถานที่ *</label>
              <div class="d-flex align-items-center justify-content-start">
                <input type="text" ref="location" :value="showAddress" class="form-control"
                  placeholder="กรุณาเลือกสถานที่่" @click="pinLocation()">
                <button class="btn btn-sm border mx-2 p-2" @click="pinLocation()">
                  <img src="/assets/images/pin.png" height="20" alt="">
                </button>
              </div>
            </div>
            <div class="form-group my-3">
              <label for="label">อุปกรณ์ *</label>
              <select name="" id="" class="form-control" v-model="hasTool">
                <option value="0">(+0 บาท) ฉันมีอุปกรณ์ที่จำเป็นในการทำความสะอาด</option>
                <option value="1">(+{{ dataSetting.hasTool }} บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด</option>
              </select>
            </div>
            <div class="form-group">
              <label for="label">บริการที่ต้องการ *</label>
              <select name="" id="" class="form-control" v-model="hasClean">
                <option value="ทำความสะอาด">ทำความสะอาด</option>
                <option value="ทำความสะอาดและ รีดผ้า">ทำความสะอาดและ รีดผ้า</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row  mt-4">
          <div class="col-1 ms-2 text-right font-weight-bold" style="border-right:solid 4px #ccc;">
            2
          </div>
          <div class="col-10">
            <p>วิธีการเลือกแม่บ้าน</p>
            <div>
              <ul class="nav nav-pills mb-3">
                <li class="nav-item">
                  <button class="nav-link px-5" :class="{ 'active': showActive }" 
                     @click="maidAuto">เลือกแม่บ้านอัตโนมัติ</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link px-5" :class="{ 'active': !showActive }"
                     @click="showActive = false">เลือกแม่บ้านด้วยตัวเอง</button>
                </li>
              </ul>
              <div class="tab-content" >
                <div class="tab-pane text-muted fade show active" v-if="showActive">
                  เลือกแม่บ้านด้วยระบบอัตโนมัติ : สำหรับทางเลือกนี้เราจะแนะนำแม่บ้านที่อยู่บริเวณใกล้เคียงให้คุณ
                  เราขอแนะนำทางเลือกนี้สำหรับผู้ใช้ใหม่
                </div>
                <div class="tab-pane text-muted fade show active" v-else>
                  <p>
                    เลือกแม่บ้านด้วยตัวคุณเอง :
                    สำหรับทางเลือกนี้คุณสามารถเลือกแม่บ้านได้ด้วยตัวคุณเองโดยการดูข้อมูลเกี่ยวกับแม่บ้าน
                  </p>
                  <div class="d-flex align-items-center">
                    <img v-if="dataBookMaids.img"
                      :src="dataBookMaids.img"
                      width="50" height="50" class="rounded-circle mx-4" alt="avatar">
                    <img v-else src="@/public/assets/images/maid.png" width="50" class="rounded-circle mx-4"
                      alt="avatar">
                    <div>
                      <p class="mb-1 text-muted" v-if="!dataBookMaids">ยังไม่เลือกแม่บ้าน</p>
                      <p class="mb-1 d-flex justify-content-between" v-else>
                        {{ dataBookMaids.fname + ' ' + dataBookMaids.lname }}
                      <div class="bth btn-sm cursor-pointer" @click="dataBookMaids = ''">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-x-circle-fill text-danger mx-2" viewBox="0 0 16 16">
                          <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                        </svg>
                      </div>
                      </p>
                      <button class="btn btn-sm btn-outline-primary" @click="getMaid">เลือกแม่บ้าน</button>
                    </div>
                    <div class="py-4 box-shadow border bg-white rounded calendar pe-2" style="position:absolute;margin-left: -20px;width:350px;"
                      v-if="openMaid">
                      <div class="row bg-white py-4 mx-1 border w-100" style="max-height:350px; overflow:scroll">
                        <div class="btn" style="position: absolute;right: 10px;width: 50px;top:-10px;">
                          <button class="btn btn-sm" @click="openMaid = false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                              class="bi bi-x-circle-fill text-danger" viewBox="0 0 16 16">
                              <path
                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                            </svg>
                          </button>
                        </div>
                        <div class="col-12" v-for="(item, i) in dataMaids" :key="i">
                          <p class="d-flex align-items-center justify-content-between"
                            :class="{ 'border-top pt-2 ': i > 0 }">
                            <div>
                              <img v-if="item.img" :src="item.img" width="40" :alt="item.fname"  style="border-radius:50%; width:40px; height:40px;">
                              <img v-else src="@/public/assets/images/maid.png" width="40" :alt="item.fname">
                              {{ item.fname + ' ' + item.lname }}
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                              <div v-if="markerPosition" class="text-small">
                                <b class="text-danger">{{ parseFloat(getDistance(markerPosition.lat,markerPosition.lng,item.latitude,item.longitude)).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }} </b><small class="text-muted">กม.</small> 
                              </div>
                           
                              <nuxt-link to="" class="text-primary cursor-pointer" @click="overView(item)">
                                พรีวิว
                              </nuxt-link>
                              <button class="btn btn-sm btn-outline-primary" @click="bookMaid(item)">เลือกจอง</button>
                            </div>
                          </p>
                        </div>
                        <div v-if="dataMaids.length<1" class="text-center">
                          แม่บ้านคิวเต็มกรุณา<span class="text-primary cursor-pointer" @click="maidAuto">เลือกอัตโนมัติ</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-1 ms-2 text-right font-weight-bold" style="border-right:solid 4px #ccc;">
            3
          </div>
          <div class="col-10">
            <div class="form-group">
              <label for="label">วันที่ *</label>
              <input type="text" class="form-control" style="letter-spacing:1px" :value="formatDateThai(dateSelect)">
            </div>
            <div>
              <label for="labeldatepicker">เลือกวันที่:</label>
              <br>
              <div class="border">
                <div class="row">
                  <div class="span12">
                    <table class="table table-condensed table-bordered table-striped">
                      <thead>
                        <tr>
                          <th colspan="7" class="w-100">
                            <div class="w-100 d-lex justify-content-between">
                              <a class="btn" @click="prevMonth">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                  class="bi bi-chevron-left" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd"
                                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                                </svg>
                              </a>
                              <a class="active text-muted">{{ thaiMonth }} {{ year }}</a>
                              <a class="btn" @click="nextMonth">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                  class="bi bi-chevron-right" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                </svg>
                              </a>
                            </div>
                          </th>
                        </tr>
                        <tr>
                          <th class="text-muted text-center" style="width:80px">อาทิตย์</th>
                          <th class="text-muted text-center" style="width:80px">จันทร์</th>
                          <th class="text-muted text-center" style="width:80px">อังคาร</th>
                          <th class="text-muted text-center" style="width:80px">พุธ</th>
                          <th class="text-muted text-center" style="width:80px">พฤหัสบดี</th>
                          <th class="text-muted text-center" style="width:80px">ศุกร์</th>
                          <th class="text-muted text-center" style="width:80px">เสาร์</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="week in weeks" :key="week">
                          <!-- <td v-for="(thisWork, j) in listWorks" :key="j"
                              class="text-center cursor-pointer d-calendar"
                              ref="dayRefs"
                              :class="{
                                  'bg-info text-muted': new Date(year, month - 1, day) < new Date(),
                                  'text-muted': day === -1,
                                  'border-0 font-weight-bold text-primary': day === currentDate.getDate() && month === currentDate.getMonth() + 1 && year === currentDate.getFullYear(),
                                  'd-calendar-active': thisDay === day,
                                  'disabled': isDateInListWork(day) || isDateSelect(day) // เพิ่มเงื่อนไขเช็คว่า day เท่ากับ dateSelect ใน listWorks หรือไม่
                              }"
                              @click="handleDayClick(day, i)">
                              {{ day > 0 ? day : '' }}  
                          </td> -->
                          <td v-for="(day, i) in week" :key="i" 
                                  class="text-center cursor-pointer d-calendar p-2"
                                  ref="dayRefs"
                                  :class="{
                                      'bg-secondary text-muted': new Date(year, month - 1, day) < new Date(),
                                      'bg-gray-200 p-2': day === -1,
                                      'border-0 font-weight-bold text-primary': day === currentDate.getDate() && month === currentDate.getMonth() + 1 && year === currentDate.getFullYear(),
                                      'd-calendar-active': thisDay === day,
                                      'disabled': isDateSelected(day),
                                      'bg-info': day === currentDate.getDate() && month === currentDate.getMonth() + 1 && year === currentDate.getFullYear() // เพิ่มคลาส bg-info เมื่อคลิกที่วันปัจจุบัน
                                  }"
                                  @click="handleDayClick(day, i)"
                              >
                                  <div v-if="isDateSelected(day)">
                                      <div v-for="(inDay, x) in listWorks" :key="x">
                                          <div v-if="inDay.dateSelect && new Date(inDay.dateSelect).getDate() === day && new Date(inDay.dateSelect).getMonth() === month - 1" 
                                              :class="{'text-white text-small bg-secondary rounded py-1': thisDay != day , 'text-white text-small': thisDay === day,}"
                                          >
                                              ไม่ว่าง 
                                              <!-- {{ inDay.startTime }} -  {{(new Date(inDay.startTime).getHours()+inDay.unitHour+2)+':00'}} -->
                                          </div>
                                      </div>
                                      <div v-if="dateSelect.length==0 && new Date(year, month - 1, day).getMonth() === month - 1">
                                          {{ day > 0 ? day : '' }}
                                      </div>
                                  </div>
                                  <div v-else>
                                      {{ day > 0 ? day : '' }}
                                  </div>
                              </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="border">

                </div>
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="label">เวลาเริ่มทำงาน</label>
              <button class="btn btn-block border w-100 d-flex" @click="openDivTime = true"
                :disabled="dateSelect == ''">
                <span v-if="selectStartTime == ''" class="text-left">เลือกเวลาเริ่มทำงาน</span>
                <span v-else class="text-left">{{ selectStartTime }}</span>
              </button>
              <div v-if="openDivTime" class="text-center" style="margin-top:-4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-triangle-fill text-primary" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M7.022 1.566a1.13 1.13 0 0 1 1.96 0l6.857 11.667c.457.778-.092 1.767-.98 1.767H1.144c-.889 0-1.437-.99-.98-1.767z" />
                </svg>
              </div>
              <div v-if="openDivTime" class="rounded " style="
                margin-top:-4px;border-top:solid 4px #0d6efd;
                border-left:solid 1px #dee2e6;
                border-right:solid 1px #dee2e6;
                border-bottom:solid 1px #dee2e6;
                height:250px;
                overflow:scroll;
              ">
                <div class="cursor-pointer div-time text-left ps-4" v-for="time in times" :key="time"
                  @click="setTime(time)">{{ time }}</div>
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="label">กำหนดระยะเวลาการทำงาน</label>
              <button class="btn btn-block border w-100 d-flex" @click="selectHour"
                :disabled="selectStartTime == ''">
                <span v-if="selectStartHour == ''" class="text-left">เลือกเวลาเริ่มทำงาน</span>
                <span v-else class="text-left">{{ selectStartHour }} ชั่วโมง {{ selectStartAmount }} บาท</span>
              </button>
              <div v-if="openDivHour" class="text-center" style="margin-top:-4px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                  class="bi bi-triangle-fill text-primary" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M7.022 1.566a1.13 1.13 0 0 1 1.96 0l6.857 11.667c.457.778-.092 1.767-.98 1.767H1.144c-.889 0-1.437-.99-.98-1.767z" />
                </svg>
              </div>
              <div v-if="openDivHour" class="rounded " style="
                margin-top:-4px;border-top:solid 4px #0d6efd;
                border-left:solid 1px #dee2e6;
                border-right:solid 1px #dee2e6;
                border-bottom:solid 1px #dee2e6;
                overflow:scroll;
              ">
              <div class="p-2">แพ็คเกจ {{ hours.name }} <nuxt-link class="text-primary" to="/"><u>เลือกแพ็คเกจอื่น</u></nuxt-link></div>
                <div class="cursor-pointer div-time text-left ps-4" v-for="(item, i) in hours.items" :key="i"
                  @click="setHour(item.hour, item.amount)">{{ item.hour }} ชั่วโมง {{ item.amount }} บาท</div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-1 ms-2 text-right font-weight-bold" style="border-right:solid 4px #ccc;">
            4
          </div>
          <div class="col-10">
            <div class="form-group">
              <label>รูปแบบของสถานที่ทำงาน *</label>
              <select name="" id="" class="form-control" v-model="workBuilding"
                placeholder="เลือกรูปแบบของสถานที่ทำงาน">
                <option selected value="คอนโด 1ห้อง">คอนโด 1ห้อง</option>
                <option value="คอนโด 2ห้อง">คอนโด 2ห้อง</option>
                <option value="คอนโด 3ห้อง">คอนโด 3ห้อง</option>
                <option value="คอนโด 4ห้องข้นไป">คอนโด 4ห้องข้นไป</option>
                <option value="บ้าน 1 ชั้น">บ้าน 1 ชั้น</option>
                <option value="บ้าน 2 ชั้น">บ้าน 2 ชั้น</option>
                <option value="บ้าน 3 ชั้น">บ้าน 3 ชั้น</option>
                <option value="สำนักงาน">สำนักงาน</option>
                <option value="อื่นๆ">อื่นๆ</option>
              </select>
              <input type="text" v-if="workBuilding == 'อื่นๆ'" class="form-control my-2" v-model="orthorBuilding">
            </div>

            <div class="form-group mt-4">
              <label for="label">ข้อมูลเพิ่มเติม</label>
              <div class="w-100 d-flex align-items-center justify-content-start my-2" id="__BVID__162">
                <div class="custom-control">
                  <input type="checkbox" class="border me-2" value="ฉันมีแมว" v-model="hasPetCat">
                  <label for="label__BVID__163">ฉันมีแมว</label>
                </div>
                <div class="custom-control">
                  <input type="checkbox" class="border mx-2" value="ฉันมีสุนัข" v-model="hasPetDog">
                  <label for="label__BVID__164">ฉันมีสุนัข</label>
                </div>
              </div>
              <textarea name="" id="" cols="30" rows="4" v-model="description"
                placeholder="กรุณาระบุข้อมูลที่แม่บ้านจำเป็นต้องทราบเพิ่มเติม (เช่น หมายเลขห้อง หรือชื่อคอนโด/หมู่บ้านที่ไม่ได้ระบุไว้ข้างต้น)"
                class="form-control"></textarea>
              <div class=" d-flex align-items-baseline mt-3">
                <input type="checkbox" class="border mx-2" v-model="concentData">
                <label for="label__BVID__164">ฉันเข้าใจว่า madam clean ไม่ได้ให้บริการ big cleaning (หลังย้ายออก
                  การปรับปรุงห้อง หรือการไม่ทำความสะอาดเป็นเวลานาน ฯลฯ ) และยอมรับ ข้อตกลงเกี่ยวกับเงื่อนไขการใช้งาน และ
                  ขอบเขตการบริการ</label>
              </div>
            </div>
          </div>
          <div class="col-1 ms-2"></div>
          <div class="col-10 mt-4 px-0">
            <button class="btn btn-danger btn-block w-100" :disabled="concentData == ''"
              @click="handleBooking()">จองเลย</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-8 col-sm-8 col-md-10" v-if="stepTwo == true">
        <div class="row d-flex align-items-center justify-content-center">
          <div class="col-12 col-lg-8 col-sm-8 px-4 px-md-0">
            <h4>จองแบบครั้งเดียว</h4>
            <h5>รอชำระเงิน</h5>
          </div>
          <div class="col-lg-8 col-sm-8 col-md-10 my-4 px-4 px-md-0">
            <div class="form-co">
              กรุณากรอกข้อมูลผู้เสียภาษี
            </div>
              <div class="form-group mb-2 border p-4">
                <div class="form-group mb-2">
                  <label for="registerInputEmail1">นามลูกค้า</label>
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
                  oninput="this.value = this.value.replace(/[^0-9_]/g, '');"   maxlength="21"
                    aria-describedby="emailHelp" placeholder="เลขที่ผู้เสียภาษี/เลขบัตรประชาชน">
                  <small id="emailHelp" class="form-text text-danger">{{ ppcardError }}</small>
                </div>
                 <button class="btn  btn-warning my-2" @click="handleSave">บันทึก</button>
              </div>
               
          </div>
          <div class="col-12 col-lg-8 col-sm-8 col-md-10 border px-4 my-4 mx-lg-0">
            <div class="row">
              <div class="col-4 text-left">
                <img src="@/public/assets/images/messageImage_1710223947120.jpg" alt="logo" class="p-2 w-100">
              </div>
              <div class="col-8 text-lef pt-2">
                <small class="text-muted" style="font-size:12px;">
                  บริษัท มัลติเฟส เน็ตเวิร์ค จำกัด
                  MULTIPHASE NETWORK CO., LTD.
                  44/18 ซอยลาดพร้าว 15 แยก 11 ถนนลาดพร้าว แขวงจอมพล<br />
                  เขตจตุจักร กรุงเทพฯ 10900<br />
                  โทร. 02 117 3782 แฟกซ์ 02 117 3783<br />
                  เลขประจำตัวผู้เสียภาษีอากร : 0105555172337/ สำนักงานใหญ่
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
                เลขประจำตัวผู้เสียภาษี : <small class="text-muted small">{{ payWait.mppcard }}</small>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="col-12">
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
                            {{ fDateThai(payWait.booking_create_at) }}
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
                      <tr v-if="payWait.hasTool === '1'">
                        <td></td>
                        <td>
                          <div class="mx-0 px-2 d-flex justify" style="font-size:0.rem;" v-if="payWait.hasClean">
                            (+{{dataSetting.hasTool}} บาท) ฉันไม่มีอุปกรณ์ทำความสะอาด
                          </div>
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
                          <div class="border-0 px-2 d-flex justify-content-between">ราคารวม: <b>{{(payWait.amountPrice + toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
        }}</b></div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td class="px-2 d-flex justify-content-between border-0">
                          <div v-if="dataPromotion">{{ dataPromotion.name }}</div>
                        </td>
                        <td></td>
                        <td colspan="2">
                          <div class="px-2 d-flex justify-content-between">ส่วนลด: 
                            <div class="text-right" v-if="dataPromotion">
                              <b>
                                {{dataPromotion.amount}}
                              </b>
                              <span v-if="dataPromotion.unit=='percent'">%</span>
                              <span class="text-small" v-else>บาท</span>
                              <p class="text-small mb-0 text-muted">ส่วนลด = {{parseFloat((payWait.amountPrice * dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }} บาท</p>
                            </div>
                            <div v-else>
                              0.00
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="2">
                          <div class="px-2 d-flex justify-content-between">ภาษีมูลค่าเพิ่ม {{dataSetting.eTax}}%: 
                            <div v-if="dataPromotion">
                              <b v-if="dataPromotion.unit=='percent'">
                                {{ parseFloat((payWait.amountPrice-(payWait.amountPrice * dataPromotion.amount / 100)+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </b>
                              <b v-else>
                                {{ parseFloat((payWait.amountPrice-payWait.amountPrice+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                              </b>
                            </div>
                            <b v-else>
                              {{ parseFloat(((payWait.amountPrice+toolPirce) * dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                            </b>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                        <td colspan="2" class="bg-dark">
                          <div class="px-2 d-flex justify-content-between text-white" v-if="dataPromotion">ยอดเงินสุทธิ: 
                            <b v-if="dataPromotion.unit=='percent'">
                              {{ parseFloat((payWait.amountPrice)-((payWait.amountPrice * dataPromotion.amount) / 100)+toolPirce+(payWait.amountPrice-(payWait.amountPrice * dataPromotion.amount / 100)+toolPirce)* (dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }}
                            </b>
                            <b v-else>
                              {{ parseFloat(((payWait.amountPrice-dataPromotion.amount))+ (toolPirce + payWait.amountPrice)).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,") }}
                            </b>
                          </div>
                          <div class="px-2 d-flex justify-content-between text-white" v-else>ยอดเงินสุทธิ: 
                            <b>
                              {{ parseFloat((toolPirce + payWait.amountPrice)+((payWait.amountPrice+toolPirce) * dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,"$1,") }}
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
          <div class="col-12 col-lg-8 col-sm-8 col-md-10 px-4">
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
          <div class="col-6 m-4 mx-md-0"></div>
        </div>
      </div>
    </div>
    <div v-else class="vh-100">

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
              <gmap />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="openLocation = false">ปิด</button>

            <button type="button" class="btn btn-primary" @click="showLL()">ยืนยันตำแหน่ง</button>
          </div>
        </div>
      </div>
    </div>

    <!-- modal -->
    <div v-if="openModal" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h6>
            <button type="button" class="close text-white btn text-xl" @click="openModal = false"
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
                  <div v-if="markerPosition" class="">
                    <img src="/assets/images/pin.png" class="mx-1" height="20" alt="">
                    ห่างจากคุณ <b class="text-danger">{{ parseFloat(getDistance(markerPosition.lat,markerPosition.lng,dataMaidShow.latitude,dataMaidShow.longitude)).toFixed(1).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") }} </b><small class="text-muted">กม.</small> 
                  </div>
                </div>
                <div class="col-6 text-center">
                  <img v-if="dataMaidShow.img" :src="dataMaidShow.img" class="w-100" alt="maid">
                  <img v-else src="@/public/assets/images/maid.png" class="w-100" alt="maid">
                  <button class="btn btn-sm btn-outline-primary mt-2" @click="bookMaid(dataMaidShow)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                      class="bi bi-pencil-square mx-2" viewBox="0 0 16 16">
                      <path
                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                      <path fill-rule="evenodd"
                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                    จองเลย</button>
                </div>
              </div>

            </div>
          </div>
          <div class="px-4 py-2 border-top">
            <!-- <button type="button" class="btn btn-secondary" @click="openModal = false">ปิด</button> -->
            <p class="d-flex justify-content-between text-left"><b>รีวิว</b>
              <button class="btn btn-sm btn-info" v-if="isReview" @click="isReview = false">
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
                  <label for="label" class="text-muted">แสดงความคิดเห็น</label>
                  <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder=". . . ."></textarea>
                </div>
                <div class="col-12 text-right mt-2">
                  <button class="btn btn-danger">
                    ให้คะแนน
                  </button>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 bg-light my-2  px-0">
                <div class="justify-content-between my-2 px-2" v-for="(item,i) in dataMaidShow.dataCommet" :key="i" :class="{ 'bg-light': i % 2 !== 0, 'bg-white': i % 2 === 0 ,'d-none':i>3,'d-flex': i<4}">
                  <div class="d-flex justify-content-start align-items-center">
                    <div v-if="item.member_fname">
                      <div class="user ms-2 border text-center text-white bg-danger text-uppercase me-2 d-flex align-items-center justify-content-center" 
                      style="width: 40px;height: 40px;">
                      {{ shotName(item.member_fname) }}
                      </div>
                    </div>
                    <div v-else>
                      <img src="@/public/assets/images/customer01.jpg" class="avatar avatar-sm me-2" alt="customer">
                    </div>
                    <div style="min-width:240px">
                      {{item.message}}
                    </div>
                  </div>
                  <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" v-for="index in item.stars" :key="index"
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
import Swal from 'sweetalert2';
import { format, addDays } from 'date-fns';
import { th } from 'date-fns/locale';
import gmap from "../components/gmap"
import eventBus from '../components/event-bus.js';
const thaiMonths = {
  1: 'มกราคม',
  2: 'กุมภาพันธ์',
  3: 'มีนาคม',
  4: 'เมษายน',
  5: 'พฤษภาคม',
  6: 'มิถุนายน',
  7: 'กรกฎาคม',
  8: 'สิงหาคม',
  9: 'กันยายน',
  10: 'ตุลาคม',
  11: 'พฤศจิกายน',
  12: 'ธันวาคม',
}
export default {
  data() {
    return {
      stepOne: true,
      stepTwo: false,
      selectPackage: '',
      hasPetCat: '',
      hasPetDog: '',
      workBuilding: '',
      orthorBuilding: '',
      markerPosition: '',
      description: '',
      concentData: '',
      hasTool: '',
      hasClean: '',
      isLogin: true,
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
      selectedDate: new Date(),
      formattedDate: '',
      openLocation: false,
      showActive: false,
      openMaid: false,
      openModal: false,
      apiBase: import.meta.env.VITE_AGENT_BASE_URL,
      gmKey: import.meta.env.VITE_YOUR_GOOGLE_MAPS_API_KEY,
      dataMaids: '',
      dataBookMaids: '',
      dataMaidShow: '',
      currentDate: new Date(),
      month: new Date().getMonth() + 1,
      year: new Date().getFullYear(),
      daysInMonth: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 0).getDate(),
      dateSelect: new Date().toISOString(),
      thisDay: '',
      showAddress: '',
      addressAt: '',
      myBankData: '',
      payWait: '',
      imageData: '',
      imageUrl: '',
      selectStartTime: '',
      openDivTime: false,
      times: [],
      hours: [],
      selectStartHour: '',
      dataPromotion: '',
      toolPirce: 0,
      selectStartAmount: 0,
      openDivHour: false,
      copy: false,
      dataSetting:'',
      listWorks:'',
      checkBooking:false,
      loading:false
      
    }
  },
  computed: {
    weeks() {
      const firstDay = new Date(this.year, this.month - 1, 1).getDay();
      const totalDays = this.daysInMonth;
      const weeks = [];
      let currentDay = 1;
      for (let i = 0; i < 6; i++) {
        const week = [];
        for (let j = 0; j < 7; j++) {
          if (i === 0 && j < firstDay) {
            week.push(-1);
          } else if (currentDay <= totalDays) {
            week.push(currentDay++);
          } else {
            week.push(-1);
          }
        }
        weeks.push(week);
      }
      return weeks;
    },
    thaiMonth() {
      return thaiMonths[this.month];
    }
  },
  mounted() {
    this.getSetting();
    this.fetchPayWait();
   
    // เช็คว่าเวลาปัจจุบันเป็น 00:00:00 หรือไม่
    
    const currentDate = new Date();
    const currentMonth = currentDate.getMonth();
    this.currentMonth = currentMonth;
    if (localStorage.getItem("bookingId")) {
      this.selectPackage = localStorage.getItem("bookingId");
      console.log(this.selectPackage);
    }
    if (localStorage.getItem("hours-package")) {
      this.hours = JSON.parse(localStorage.getItem("hours-package"));
      console.log(this.hours);
    }else{
      this.getPackage();
    }

  },
  created() {
    // this.generateTimes(); // เรียกฟังก์ชัน generateTimes() เมื่อ component ถูกสร้าง
  },
  methods: {
    isDateSelected(day) {
        // ตรวจสอบว่า this.dateSelect เป็น array และมีค่าใน array หรือไม่
        // console.log('return',Array.isArray(this.dateSelect) && this.dateSelect.some(item => new Date(item.dateSelect).getHours() === day));

        return Array.isArray(this.listWorks) && this.listWorks.some(item => new Date(item.dateSelect).getDate() === day);
    },
    selectHour(){
      this.openDivHour = true;
    },
    handleSave: async function () {
      this.profile = JSON.parse(localStorage.getItem("Profile"));
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
    getPackage: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/packages/4",
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.hours = response.data;
            this.thisPackage=response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    fDateThai(date) {
      return format(new Date(date), ' d MMM yy', { locale: th });
    },
    thaiYearFormat(date) {
      const newDate = addDays(new Date(date), 1); // เพิ่ม 1 วัน
      const formattedDate = format(newDate, ' d MMM yy', { locale: th });
      return formattedDate;
    },
    generateTimes(selectedDate) {
      const startTime = 6; // เวลาเริ่มต้นที่ 6:00 เช้า
      const endTime = 19; // เวลาสิ้นสุดที่ 19:00
      const currentHour = new Date().getHours(); // เวลาปัจจุบัน (ชั่วโมง)
      const currentDay = new Date().getDate(); // วันที่ปัจจุบัน
      this.times=[];
      for (let hour = startTime; hour <= endTime; hour++) {
        if (new Date(selectedDate).getDate() === currentDay && (hour <= currentHour + 2 || hour <= currentHour)) {
          //this.times.push('--:--'); // ถ้าเป็นเวลาหลังจากตอนนี้ไปสองชั่วโมง หรือก่อนตอนนี้
        } else {
          this.times.push(`${this.pad(hour)}:00`); // เพิ่มเวลาทุกๆชั่วโมง
          this.times.push(`${this.pad(hour)}:30`); // เพิ่มเวลาทุกๆ 30 นาที
        }
      }
    },

    pad(number) {
      return number.toString().padStart(2, '0'); // เพิ่มเลข 0 ด้านหน้าถ้าไม่ครบ 2 หลัก
    },
    maidAuto(time) {
      this.showActive = true;
      this.openMaid = false;
      this.dataBookMaids ='';
    },
    setTime(time) {
      this.selectStartTime = time;
      this.openDivTime = false;
    },
    setHour(hour, amount) {
      this.selectStartHour = hour;
      this.selectStartAmount = amount;
      this.openDivHour = false;
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
              // เมื่อคลิกปุ่ม "ตกลง" ใน SweetAlert2
              // ให้เปลี่ยนเส้นทางของหน้าไปที่ 'history'
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
    showLL: async function () {
      this.markerPosition = eventBus.markerPosition;

      try {
        const response = await axios.get(`https://maps.googleapis.com/maps/api/geocode/json?latlng=${this.markerPosition.lat},${this.markerPosition.lng}&language=th&key=${this.gmKey}`);

        if (response.data.status === 'OK') {
          const addressComponents = response.data.results[0].address_components;
          this.showAddress = response.data.results[0].formatted_address;
          const address = {
            street: '',
            district: '',
            subdistrict: '',
            province: '',
            country: ''
          };

          // Loop through address components to get desired information
          addressComponents.forEach(component => {
            if (component.types.includes('route')) {
              address.street = component.long_name;
            } else if (component.types.includes('sublocality')) {
              address.subdistrict = component.long_name;
            } else if (component.types.includes('sublocality_level_1')) {
              address.subdistrict = component.long_name;
            } else if (component.types.includes('administrative_area_level_2')) {
              address.district = component.long_name;
            } else if (component.types.includes('administrative_area_level_1')) {
              address.province = component.long_name;
            } else if (component.types.includes('country')) {
              address.country = component.long_name;
            }
          });
          this.addressAt = address;
        } else {
          console.error('Error occurred while fetching address:', response.data.error_message);
        }
      } catch (error) {
        console.error('An error occurred while fetching address:', error);
      }

      this.openLocation = false;
    },
    deg2rad(deg) {
        return parseFloat(deg) * (Math.PI / 180);
    },
    getDistance(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        // แปลงค่าละติจูดและลองจิจูดเป็นตัวเลขก่อนคำนวณ
        const parsedLat1 = parseFloat(lat1);
        const parsedLon1 = parseFloat(lon1);
        const parsedLat2 = parseFloat(lat2);
        const parsedLon2 = parseFloat(lon2);
        const dLat = this.deg2rad(parsedLat2 - parsedLat1);  
        const dLon = this.deg2rad(parsedLon2 - parsedLon1);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(this.deg2rad(parsedLat1)) * Math.cos(this.deg2rad(parsedLat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c; // Distance in km
        return distance;
    },
    pinLocation() {
      const auth = JSON.parse(localStorage.getItem("Profile"));
      if (!auth || auth == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเข้าสู่ระบบก่อน',
          showConfirmButton: false,
        });
        return false;
      } else {
        this.openLocation = true;
      }

    },

    timeIn(date) {
      const dateObject = new Date(`2000-01-01T${date}`);
      const hours = dateObject.getHours();
      const minutes = dateObject.getMinutes();

      const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

      return formattedTime;
    },
    timeCheckInBooking() {
      const dateObject = new Date();
      const hours = dateObject.getHours();
      const minutes = dateObject.getMinutes();

      const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

      return formattedTime;
    },
    formatDateThai(date) {
      return format(new Date(date), 'EEEE d MMM yyyy', { locale: th });
    },
    overView: async function (data) {
      this.dataMaidShow = data;
      this.openModal = true;
    },
    bookMaid: async function (data) {
      this.openMaid = false;
      this.openModal = false;
      this.dataBookMaids = data;
      this.maidListWork(data.id);
    },
    handleBooking: async function () {
      const auth = JSON.parse(localStorage.getItem("Profile"));
      if (!auth || auth == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเข้าสู่ระบบก่อน',
          showConfirmButton: false,
        });
        return false;
      }

      if (this.showAddress == '') {
        this.$refs.location.focus();
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกตำแหน่ง',
          showConfirmButton: false,
        });
        return false;
      }
      if (this.hasTool == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกอุปกรณ์',
          showConfirmButton: false,
        });
        return false;
      }
      if (this.hasClean == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกการทำความสะอาด',
          showConfirmButton: false,
        });
        return false;
      }
      if (this.dateSelect == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกวันที่ให้บริการ',
          showConfirmButton: false,
        });
        return false;
      }
      if (this.workBuilding == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกสถานที่ให้บริการ',
          showConfirmButton: false,
        });
        return false;
      }
      if (this.selectStartHour == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกช่วโมงการใช้บริการ',
          showConfirmButton: false,
        });
        return false;
      }
      if (this.workBuilding == 'อื่นๆ' && this.orthorBuilding == '') {
        swal({
          position: "top-center",
          icon: "warning",
          title: 'กรุณาเลือกสถานที่ให้บริการ',
          showConfirmButton: false,
        });
        return false;
      }
      let maidId = 0;
      if (!this.dataBookMaids.id) {
        maidId = 0;
      } else {
        maidId = this.dataBookMaids.id;
      }
      const dataBooking = {
        maid_id: maidId,
        hasPetCat: this.hasPetCat,
        hasPetDog: this.hasPetDog,
        hasClean: this.hasClean,
        hasTool: this.hasTool,
        workBuilding: this.workBuilding,
        orthorBuilding: this.orthorBuilding,
        convertedDate: this.dateSelect,
        showAddress: this.showAddress,
        address: this.addressAt,
        description: this.description,
        member_id: auth.member_id,
        lat: this.markerPosition.lat.toString(),
        lng: this.markerPosition.lng.toString(),
        pId: parseInt(this.selectPackage),
        startTime: this.selectStartTime,
        unitHour: this.selectStartHour,
        price: this.selectStartAmount,
        concentData: this.concentData
      }
      try {
        let config = {
          method: "post",
          url: this.apiBase + "/booking",
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Profile").token
          },
          data: dataBooking
        };

        await axios
          .request(config)
          .then((response) => {
            swal({
              position: "top-center",
              icon: "",
              title: 'ทำการจองบริการแม่บ้านเรียบร้อย  และโปรดทำรายการชำระเงินขั้นตอนต่อไป',
              html: 'ทำการจองบริการแม่บ้านเรียบร้อย<br><br>โปรดทำรายการชำระเงินขั้นตอนต่อไป',
              showConfirmButton: false,
            });
            this.getPromotion();
            this.fetchBank();
            this.fetchPayWait();
            this.stepOne = false;
            this.stepTwo = true;
            // localStorage.removeItem('bookingId');
            
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    getMaid: async function () {
      this.openMaid = true;
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/maids/0",
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataMaids = response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    shotName(name){
      let nn = name.charAt(0);

        if (nn == 'เ' || nn == 'โ' || nn == 'ไ' || nn == 'ใ') {
          return name.charAt(1);
        } else {
          return name.charAt(0);
        }
    },
    maidListWork: async function (id) {
      // this.openMaid = true;
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/maid-list-work/"+id,
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.listWorks = response.data;
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
                    if(this.dataSetting){
                      const currentTime = new Date();
                      const dateObject = new Date(`2000-01-01T${this.dataSetting.timeIn}`);
                      const hours = dateObject.getHours();
                      if (currentTime.getHours() === 0 || currentTime.getHours()< hours) {
                        // กระทำเมื่อเวลาปัจจุบันเป็น 00:00:00 หรือมากกว่า
                        this.checkBooking=false;
                        this.loading=true;
                        localStorage.removeItem('checkIn');
                        // console.log('เวลาปัจจุบันคือ 00:00:00 หรือมากกว่า');
                      } else {
                        // กระทำเมื่อเวลาปัจจุบันไม่ได้เป็น 00:00:00
                        this.checkBooking=true;
                        this.loading=true;
                        // console.log('getHours',currentTime.getHours('H'));
                        // console.log('getMinutes',currentTime.getMinutes());
                        // console.log('getSeconds',currentTime.getSeconds());
                      }
                    }
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
            this.payWait = response.data;
            if (this.payWait.hasTool == '1') {
              this.toolPirce = this.dataSetting.hasTool;
            }
            if(this.payWait){
              if(this.dataPromotion){
                this.total_promotion_amount =parseFloat((this.payWait.amountPrice * this.dataPromotion.amount) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                // <!-- ราคารวมส่วนลดแล้ว -->
                if(this.dataPromotion.unit=='percent'){
                  this._amount  = parseFloat((this.payWait.amountPrice)-((this.payWait.amountPrice * this.dataPromotion.amount) / 100)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  this.total_vat = parseFloat((this.payWait.amountPrice-(this.payWait.amountPrice * this.dataPromotion.amount / 100)+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                }else{
                  this._amount  = parseFloat((this.payWait.amountPrice)-this.dataPromotion.amount+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                  this.total_vat = parseFloat((this.payWait.amountPrice-this.dataPromotion.amount+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                }
                this.amount_total = parseFloat(this.total_vat)+parseFloat(this._amount);
                const dataReceipt = {
                  bookId:this.payWait.bookId,
                  promotionId:this.dataPromotion.id,
                  total_vat:this.total_vat,
                  total_promotion_amount:parseFloat(this.total_promotion_amount),
                  vat:this.dataSetting.eTax,
                  tool_price:this.toolPirce,
                  amount_price:this.payWait.amountPrice,
                  amount_total:parseFloat(this.total_vat)+parseFloat(this._amount),
                  promotion_amount:this.dataPromotion.amount,
                  proType:this.dataPromotion.unit
                };
              }else{
                this._amount  =  parseFloat((this.payWait.amountPrice)+this.toolPirce).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                this.total_vat = parseFloat((this.payWait.amountPrice+this.toolPirce)* (this.dataSetting.eTax) / 100).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
                const dataReceipt = {
                  bookId:this.payWait.bookId,
                  promotionId:'',
                  total_vat:this.total_vat,
                  total_promotion_amount:0,
                  vat:this.dataSetting.eTax,
                  tool_price:this.toolPirce,
                  amount_price:this.payWait.amountPrice,
                  amount_total:parseFloat(this.total_vat)+parseFloat(this._amount),
                  promotion_amount:0,
                  proType:''
                }
                this.saveReceipt(dataReceipt);
              }
            }
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    goPay() {
      this.fetchBank();
      this.stepOne = false;
      this.stepTwo = true;
      this.getPromotion();
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
    isDateInListWork(day) {
      const currentDate = new Date(this.year, this.month - 1, day);
      const dateString = currentDate.toISOString().split('T')[0]; // สร้างรูปแบบของวันที่เพื่อเปรียบเทียบ
      if (currentDate && Array.isArray(currentDate) && currentDate.some) {
      // ดำเนินการต่อเมื่อ currentDate ไม่ใช่ undefined หรือ null
      // และเป็นอาร์เรย์ที่มีเมธอด some()
        if (currentDate.some(cell => cell.trim() !== '')) {
          return this.listWork.some(work => {
                const workDate = new Date(work.dateSelect).toISOString().split('T')[0];
                return dateString === workDate;
            });
        }
      } else {
          console.error('Date In List Work is not defined or not an array');
      }
    },
    isDateSelect(day) {
        // ตรวจสอบว่ามีข้อมูล listWorks หรือไม่
        if (!this.listWorks || !this.listWorks.dateSelect) {
            return false; // หากไม่มีข้อมูลให้คืนค่าเป็น false
        }
        
        const formattedListWorks = this.listWorks.map(work => new Date(work.dateSelect).toISOString().split('T')[0]);
        // แปลงวันที่ day เป็นรูปแบบ 'Y-m-d'
        const formattedDay = new Date(this.year, this.month - 1, day).toISOString().split('T')[0];
        
        // เช็คว่าวันที่ใน formattedDay เป็นวันที่ใน listWorks หรือไม่
        return formattedListWorks.includes(formattedDay);
    },
    handleDayClick(day, i) {
        if (day > 0 && !this.isDateInListWork(day)) {
            this.selectDay(day, i);
        }
    },
    selectDay(day, i) {
      if (day > 0) {
        let selectedDate = new Date(this.year, this.month - 1, day);
        let today = new Date();
        today.setHours(0, 0, 0, 0); // เซ็ตเวลาเป็น 00:00:00 เพื่อเปรียบเทียบกับวันปัจจุบัน
        
        if (selectedDate < today) {
          swal({
              position: "top-center",
              icon: "error",
              title: 'ไม่สามารถเลิกวันย้อนหลังได้',
              showConfirmButton: false,
            });
            return false;
        }
        this.dateSelect = selectedDate;
        this.thisDay = day;
        this.$refs.dayRefs.forEach(ref => {
          ref.classList.remove('d-calendar-active');
        });
        this.generateTimes(selectedDate);
        // เพิ่มคลาส d-calendar-active ให้กับ <td> ที่ถูกคลิก
        // this.$refs.dayRefs[i].classList.add('d-calendar-active');
      }
    },
    prevMonth() {
      // ลดค่าเดือนลง 1 หากเดือนปัจจุบันไม่ใช่เดือน 1
      this.month = this.month === 1 ? 12 : this.month - 1;
      // ลดค่าปีลง 1 หากเดือนปัจจุบันเป็นเดือน 1
      this.year = this.month === 1 ? this.year - 1 : this.year;
      // อัปเดตจำนวนวันในเดือนใหม่
      this.daysInMonth = new Date(this.year, this.month - 1, 0).getDate();
    },
    nextMonth() {
      // เพิ่มค่าเดือนขึ้น 1 หากเดือนปัจจุบันไม่ใช่เดือน 12
      this.month = this.month === 12 ? 1 : this.month + 1;
      // เพิ่มค่าปีขึ้น 1 หากเดือนปัจจุบันเป็นเดือน 12
      this.year = this.month === 12 ? this.year + 1 : this.year;
      // อัปเดตจำนวนวันในเดือนใหม่
      this.daysInMonth = new Date(this.year, this.month - 1, 0).getDate();
    }
  }
}
</script>

<style scope>
.vuejs-datepicker {
  font-family: 'Tahoma', sans-serif;
}

.text-right {
  text-align: right;
}

.text-muted {
  color: #ccc;
}

.font-weight-bold {
  font-weight: bold;
}


@media (max-width: 768px) {
  .calendar{
    position: absolute;margin-top: 150px;width:450px;z-index:2;
  }
}

@media (max-width: 480px) {
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