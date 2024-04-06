<template>
  <div class="topbar px-md-5 bg-danger d-flex justify-content-between" :class="{'d-none':$route.name==maid}" @click="handleBodyClick">
    <div class="text-white text-1xl align-items-center d-flex justify-content-between">
      <img src="@/public/assets/images/logomdc.png" width="45" alt="">
      <span class="d-none d-md-block">Madam-Clean</span>
    </div>
    <div class="align-items-center d-none d-md-flex" v-if="loading">
      <nuxt-link class="text-white" :to="pathOrigin" :class="{ 'active': $route.name === '' }">หน้าแรก</nuxt-link>
      <nuxt-link class="text-white" :to="pathOrigin+'/booking'" @click="packageSelect(0)" :class="{ 'active': $route.name === 'booking' }">จองแม่บ้าน</nuxt-link>
      <!-- <nuxt-link class="text-white" to="madam" :class="{ 'active': $route.name === 'madam' }">แม่บ้าน</nuxt-link> -->
      <div>
        <nuxt-link class=" text-white" to="/madam" :class="{ 'active': $route.name === 'madam' || isMadamDropdownOpen }"
          @click="toggleMadamDropdown">แม่บ้าน</nuxt-link>
        <div v-if="isMadamDropdownOpen" class="text-center mx-2 mb-0" style="margin-top: 0px;z-index: 2;position: absolute;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-triangle-fill text-white" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M7.022 1.566a1.13 1.13 0 0 1 1.96 0l6.857 11.667c.457.778-.092 1.767-.98 1.767H1.144c-.889 0-1.437-.99-.98-1.767z" />
          </svg>
        </div>
        <div class="dropdown-s bg-white rounded box-shadow" v-if="isMadamDropdownOpen">
          <div aria-labelledby="dropdownMenuButton" class="py-2 px-0">
            <a class="dropdown-item px-3 mx-0" @click="linkTo('madam')">รายละเอียดแม่บ้าน</a>
            <a class="dropdown-item px-3 mx-0" @click="linkTo('maid')">ฉันเป็นแม่บ้าน</a>
            <a class="dropdown-item px-3 mx-0" @click="linkTo('madam-register')">สมัครเป็นแม่บ้าน</a>
          </div>
        </div>
      </div>
      <nuxt-link class="text-white" :to="pathOrigin+'/service'" :class="{ 'active': $route.name === 'service' }">บริการ</nuxt-link>
      <nuxt-link class="text-white" :to="pathOrigin+'/promotion'" :class="{ 'active': $route.name === 'promotion' }">โปรโมชั่น</nuxt-link>
      <nuxt-link class="text-white" :to="pathOrigin+'/about'" :class="{ 'active': $route.name === 'about' }">เกี่ยวกับเรา</nuxt-link>

      <div class="d-flex align-items-center justify-content-between btn btn-sm px-3 text-white ms-2"
        style="background:rgba(0,0,0,0.2); border-radius:10px;" @click="openToggle" v-if="profile">
        <div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ profile.fullname }}</div>
        <div class="user ms-2 border text-center text-white bg-danger text-uppercase">{{ shotName }}</div>
      </div>
      <div class="" v-else>
        <button class="btn btn-sm text-muted bg-white ms-3" @click="logIn">เข้าสู่ระบบ</button>
      </div>
    </div>
    <div class="w-50 d-flex d-md-none align-items-center justify-content-between me-3" v-if="loading">
      <div class="d-flex d-md-none">
        <button class="btn" @click="toggleMenu">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
            class="bi bi-list text-white" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
          </svg>
        </button>
      </div>
      <div class="d-flex d-md-none">
        <div class="">
          <div class="d-flex align-items-center justify-content-between btn btn-sm px-3 text-white ms-2"
            style="background:rgba(0,0,0,0.2); border-radius:10px;" @click="openToggle" v-if="profile">
            <div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">{{ profile.fullname }}</div>
            <div
              class=" ms-2 border justify-content-center text-white bg-danger text-uppercase d-flex align-items-center"
              style="border-radius:50%;width:30px;height:30px;font-size: 20px;">{{ shotName }}</div>
          </div>
          <div class="" v-else>
            <button class="btn btn-sm text-muted bg-white ms-3" @click="logIn">เข้าสู่ระบบ</button>
          </div>
        </div>
      </div>
      
    </div>
    <div class="p-2 card-profile border bg-white small" v-if="toggle">
      <div>
        <nuxt-link :to="pathOrigin+'/history'" class="text-muted" @click="toggle = false">
          ประวัติบริการ
        </nuxt-link>
      </div>
      <div @click="logOut()" class="text-center">
        ออกจากระบบ
      </div>
    </div>
    <div v-if="showMenu" class="mobile-menu bg-danger px-2 pt-4"
      style="position:absolute; margin-top:326px;left: 0;right: 0;z-index:2;">
      <p><nuxt-link @click="showMenu = false" class="text-white" to=""
          :class="{ 'active': $route.name === '/' }">หน้าแรก</nuxt-link></p>
      <p>
        <nuxt-link class="text-white"  :to="pathOrigin+'/booking'" :class="{ 'active': $route.name === 'booking' }">จองแม่บ้าน</nuxt-link></p>
      <p><div>
        <nuxt-link class="ho text-white" to="/madam"
          :class="{ 'active': $route.name === 'madam' || isMadamDropdownOpen }"
          @click="toggleMadamDropdown">แม่บ้าน</nuxt-link>
        <div v-if="isMadamDropdownOpen" class="text-center mx-2 mb-0" style="margin-top: 0px;z-index: 2;position: absolute;">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-triangle-fill text-white" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M7.022 1.566a1.13 1.13 0 0 1 1.96 0l6.857 11.667c.457.778-.092 1.767-.98 1.767H1.144c-.889 0-1.437-.99-.98-1.767z" />
          </svg>
        </div>
        <div class="dropdown-s bg-white rounded box-shadow" v-if="isMadamDropdownOpen">
          <div aria-labelledby="dropdownMenuButton" class="py-2 px-0">
            <a class="dropdown-item px-3 mx-0" @click="linkTo('madam')">รายละเอียดแม่บ้าน</a>
            <a class="dropdown-item px-3 mx-0" @click="linkTo('maid')">ฉันเป็นแม่บ้าน</a>
            <a class="dropdown-item px-3 mx-0" @click="linkTo('madam-register')">สมัครเป็นแม่บ้าน</a>
          </div>
        </div>
      </div></p>
      <p><nuxt-link @click="showMenu = false" class="text-white" :to="pathOrigin+'/service'"
          :class="{ 'active': $route.name === 'service' }">บริการ</nuxt-link></p>
      <p><nuxt-link @click="showMenu = false" class="text-white" :to="pathOrigin+'/promotion'"
          :class="{ 'active': $route.name === 'promotion' }">โปรโมชั่น</nuxt-link></p>
      <p><nuxt-link @click="showMenu = false" class="text-white" :to="pathOrigin+'/about'"
          :class="{ 'active': $route.name === 'about' }">เกี่ยวกับเรา</nuxt-link></p>
    </div>
    <!-- Modal -->
    <div v-if="isModalOpen" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h6>
            <button type="button" class="close text-white btn text-xl" data-dismiss="modal" @click="isModalOpen = false"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-if="isLogin">
              <div class="form-group">
                <label for="exampleInputEmail1">อีเมล์</label>
                <input type="email" v-model="dataLogin.email" class="form-control" id="exampleInputEmail1"
                  aria-describedby="emailHelp" placeholder="อีเมล์">
                <small id="emailHelp" class="form-text text-danger">{{ emailError }}</small>
              </div>
              <div class="form-group my-3 text-muted">
                  <label for="registerInputPassword">รหัสผ่าน</label>
                  <input type="password" v-model="dataLogin.password" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-if="!dooPassword">
                    <input type="text" v-model="dataLogin.password" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-else>
                  <small id="emailHelp" class="form-text text-danger">{{ passError }}</small>
                  <button class="btn btn-sm"  style="position: absolute;right: 28px;margin-top: -34px;" @click="seePassword">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash text-muted" viewBox="0 0 16 16"  v-if="!dooPass">
                      <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                      <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                      <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye text-info" viewBox="0 0 16 16" v-else>
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                      <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                    </svg>
                  </button>
                </div>
              <div class="form-check">
                <!--  <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label> -->
                
              </div>
              <div class="d-grid">
                <nuxt-link to="" @click="rePass()" class="cursor-pointer small">
                  <u>ลืมรหัสผ่าน</u>
                </nuxt-link>
                <nuxt-link to="" @click="reGister()"
                class="text-primary cursor-pointer small"><u>ลงทะเบียน</u>
              </nuxt-link>
              </div>
              
            </div>
            <div v-if="isRepass">
              <div class="border rounded px-2 mt-2">
                <label class="bg-white px-2" style="position: absolute;margin-top: -14px;background: #fff;">ใช้เข้าระบบ</label>
                <div class="form-group my-3 text-muted">
                  <label for="registerInputEmail1">กรอกอีเมล์</label>
                  <input type="email" v-model="dataRegister.email" class="form-control text-muted"
                    id="registerInputEmail1" aria-describedby="emailHelp" placeholder="อีเมล์">
                  <small id="emailHelp" class="form-text text-danger">{{ emailError }}</small>
                </div>
                <div class="form-group my-3 text-muted">
                  <label for="registerInputPassword">รหัสผ่าน</label>
                  <input type="password" v-model="dataRegister.pass" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-if="!dooPass">
                    <input type="text" v-model="dataRegister.pass" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-else>
                  <small id="emailHelp" class="form-text text-danger">{{ passError }}</small>
                  <button class="btn btn-sm"  style="position: absolute;right: 28px;margin-top: -34px;" @click="seePass">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash text-muted" viewBox="0 0 16 16"  v-if="!dooPass">
                      <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                      <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                      <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye text-info" viewBox="0 0 16 16" v-else>
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                      <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                    </svg>
                  </button>
                </div>
                <div class="form-group my-3 text-muted">
                  <label for="registerInputPassword">ยืนยันรหัสผ่าน</label>
                  <input type="password" v-model="dataRegister.cfpass" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-if="!dooPass2">
                    <input type="text" v-model="dataRegister.cfpass" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-else>
                  <small id="emailHelp" class="form-text text-danger">{{ passError }}</small>
                  <button class="btn btn-sm"  style="position: absolute;right: 28px;margin-top: -34px;" @click="seePass2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash text-muted" viewBox="0 0 16 16"  v-if="!dooPass">
                      <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                      <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                      <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye text-info" viewBox="0 0 16 16" v-else>
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                      <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                    </svg>
                  </button>
                </div>
              </div>
              <div class="form-check">
                <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label> -->
              </div>
              <nuxt-link to="" @click="logIn()" class="text-primary cursor-pointer small"><u>เข้าสู่ระบบ</u></nuxt-link>
            </div>
            <div v-if="isRegister">
              <div class="form-group py-0 my-0">
                <div class="row">
                  <div class="col-12">
                    <div class="row">
                      <div class="col-6 form-group">
                        <label for="regisInputName">คำนำหน้าชื่อ</label>

                        <select name="" id="" v-model="dataRegister.title" class="form-control" placeholder="ชื่อ">
                          <option value="">เลือก</option>
                          <option value="นาย">นาย</option>
                          <option value="นาง">นาง</option>
                          <option value="นางสาว">นางสาว</option>
                        </select>
                        <small id="emailHelp" class="form-text text-danger">{{ titleError }}</small>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="form-group my-3">
                      <label for="regisInputName">ชื่อ</label>
                      <input type="email" v-model="dataRegister.mfname" class="form-control" id="regisInputName"
                      oninput="this.value = this.value.replace(/[0-9_ ]/g, '');"
                        aria-describedby="emailHelp" placeholder="ชื่อ">
                      <small id="emailHelp" class="form-text text-danger">{{ mfnameError }}</small>
                    </div>
                  </div>
                  <div class="col-12 col-md-6 my-0">
                    <div class="form-group my-3">
                      <label for="regisInputmLName">นามสกุล</label>
                      <input type="email" v-model="dataRegister.mlname" class="form-control" id="regisInputmLName"
                      oninput="this.value = this.value.replace(/[0-9_ ]/g, '');"
                        aria-describedby="emailHelp" placeholder="นามสกุล">
                      <small id="emailHelp" class="form-text text-danger">{{ mlnameError }}</small>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group mb-4">
                <label for="registerInputEmail1">เบอร์โทร</label>
                <input type="phone" v-model="dataRegister.mphone" class="form-control" id="registerInputPhone"
                oninput="this.value = this.value.replace(/[^0-9_]/g, '');"   maxlength="10"
                  aria-describedby="emailHelp" placeholder="เบอร์โทร">
                <small id="emailHelp" class="form-text text-danger">{{ phoneError }}</small>
              </div>
              <div class="border rounded px-2 mt-2">
                <label class="bg-white px-2" style="position: absolute;margin-top: -14px;background: #fff;">ใช้เข้าระบบ</label>
                <div class="form-group my-3 text-muted">
                  <label for="registerInputEmail1">อีเมล์</label>
                  <input type="email" v-model="dataRegister.email" class="form-control text-muted"
                    id="registerInputEmail1" aria-describedby="emailHelp" placeholder="อีเมล์">
                  <small id="emailHelp" class="form-text text-danger">{{ emailError }}</small>
                </div>
                <div class="form-group my-3 text-muted">
                  <label for="registerInputPassword">รหัสผ่าน</label>
                  <input type="password" v-model="dataRegister.pass" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-if="!dooPass">
                    <input type="text" v-model="dataRegister.pass" class="form-control text-muted"
                    id="registerInputPassword" placeholder="รหัสผ่าน" v-else>
                  <small id="emailHelp" class="form-text text-danger">{{ passError }}</small>
                  <button class="btn btn-sm"  style="position: absolute;right: 28px;margin-top: -34px;" @click="seePass">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash text-muted" viewBox="0 0 16 16"  v-if="!dooPass">
                      <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                      <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                      <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye text-info" viewBox="0 0 16 16" v-else>
                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                      <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                    </svg>
                  </button>
                </div>
              </div>
              <div class="form-group mb-2">
                  <label for="registerInputEmail1">ที่อยู่</label>
                  <textarea cols="30" rows="2" v-model="dataRegister.maddress" class="form-control" id="registerInputPhone"

                    aria-describedby="emailHelp" placeholder="ที่อยู่"></textarea>
                  <small id="emailHelp" class="form-text text-danger">{{ addressError }}</small>
                </div>
                <div class="form-group mb-2">
                  <label for="registerInputEmail1">เลขที่ผู้เสียภาษี/เลขบัตรประชาชน</label>
                  <input type="text" v-model="dataRegister.mppcard" class="form-control" id="registerInputPhone"
                  oninput="this.value = this.value.replace(/[^0-9_]/g, '');"   maxlength="13"
                    aria-describedby="emailHelp" placeholder="เลขที่ผู้เสียภาษี/เลขบัตรประชาชน">
                  <small id="emailHelp" class="form-text text-danger">{{ ppcardError }}</small>
                </div>
              <div class="form-check">
                <!-- <input type="checkbox" class="form-check-input" id="exampleCheck1">
                  <label class="form-check-label" for="exampleCheck1">Check me out</label> -->
              </div>
              <nuxt-link to="" @click="logIn()" class="text-primary cursor-pointer small"><u>เข้าสู่ระบบ</u></nuxt-link>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="isModalOpen = false">ปิด</button>
            <button type="button" class="btn btn-primary" v-if="isRegister" @click="handleRegister()">{{ textTitle
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
      profile: '',
      auth: '',
      dooPass: false,
      dooPass2: false,
      dooPassword: false,
      isModalOpen: false,
      isLogin: true,
      toggle: false,
      isRegister: false,
      isRepass: false,
      textTitle: 'เข้าสู่ระบบ',
      // dataRegister: {
      //   mfname: "ลออ",
      //   mlname: "สีไสว",
      //   email: "sisawai@online.com",
      //   pass: "1111",
      //   mphone: '0941325432',
      //   title: ''
      // },
      dataRegister:{
        mfname:'',
        mlname:'',
        email:'',
        pass:'',
        cfpass: "",
        mphone:'',
        maddress:'',
        mppcard:'',
        title:''
      },
      mfnameError: '',
      mlnameError: '',
      emailError: '',
      passError: '',
      ppcardError: '',
      addressError: '',
      dataLogin: {
        email: '',
        password: '',
      },
      shotName: '',
      titleError: '',
      phoneError: '',
      loading: false,
      showMenu: false,
      apiBase: import.meta.env.VITE_AGENT_BASE_URL,
      isMadamDropdownOpen: false,
      pathOrigin:''
    };
  },
  mounted() {
    this.pathOrigin = window.location.origin;
    this.profile = JSON.parse(localStorage.getItem("Profile"));
    if (this.profile) {
      this.auth = this.profile.token;
      let nn = this.profile.fullname.charAt(0);
      if (this.profile.fullname) {
        if (nn == 'เ' || nn == 'โ' || nn == 'ไ' || nn == 'ใ') {
          this.shotName = this.profile.fullname.charAt(1);
        } else {
          this.shotName = this.profile.fullname.charAt(0);
        }
        this.loading = true;
      this.routers =  this.$route.name;
      }
    }else{
      this.loading = true;
    }
    
    // this.admin = JSON.parse(localStorage.getItem("Maid"));
    // if (this.admin) {
    //   this.auth = this.admin.token;
    //   if (this.admin.user) {
    //     this.shotName = this.admin.user.charAt(0);
    //     this.loading = true;
    //     // if(this.routers=='sign-in'){
    //     //   window.location = '/';
    //     //   this.loading = true;
    //     // }
    //   }
    // } else {
    //   this.loading = true;
    //   if(this.routers=='maid'){
    //     window.location = 'sign-in';
    //   }
    // }
  
    document.body.addEventListener('click', this.handleClick);
  },
  beforeDestroy() {
    document.body.removeEventListener('click', this.handleClick);
  },

  methods: {
    handleBodyClick() {
      // setTimeout(() => {
      //   this.isMadamDropdownOpen = !this.isMadamDropdownOpen;
      // }, 20);
      
    },
    toggleMadamDropdown() {
      this.isMadamDropdownOpen = !this.isMadamDropdownOpen;
    },
    linkTo(path) {
      window.location=window.location.origin+'/'+path;
    },
    packageSelect: async function (id) {
      localStorage.setItem("bookingId", JSON.stringify(id));
      localStorage.removeItem('hours-package');
      window.location = 'booking';
      this.showMenu = false;
    },
    toggleMenu() {
      this.showMenu = !this.showMenu;
      this.toggle = false;
    },
    handleClick(event) {
      if (event.target === document.body) {
        if (this.toggle == true) {
          setTimeout(() => {
            this.toggle = false;
          }, 20);
        }
      }
    },
    logIn() {
      this.isModalOpen = true;
      this.isLogin = true;
      this.isRegister = false;
      this.isRepass = false;
      this.textTitle = 'เข้าสู่ระบบ';
    },
    logOut() {
      this.toggle = false;
      this.isModalOpen = false;
      this.isLogin = false;
      this.isRegister = false;
      this.isRepass = false;
      this.textTitle = 'เข้าสู่ระบบ';
      this.auth = '';
      this.profile = '';
      localStorage.removeItem('Profile');
      
    },
    rePass() {
      this.isLogin = false;
      this.isRepass = true;
      this.textTitle = 'รีเซ็ตรหัสผ่าน';
    },
    reGister() {
      this.isLogin = false;
      this.isRegister = true;
      this.textTitle = 'ลงทะเบียน';
    },
    openToggle() {
      if (this.toggle == true) {
        this.toggle = false;
      } else {
        this.toggle = true;
      }
      this.showMenu = false;
    },
    validateEmail: function(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regular expression for valid email format
        return emailRegex.test(email); // Return true if email is in valid format, false otherwise
    },
    validateEmail: function(email) {
        return String(email)
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    },
    
    handleRegister: async function () {
      let chkphone = String(this.dataRegister.mphone.substring(2, 0));
      const chkEmail = this.validateEmail(this.dataRegister.email);

      if (this.dataRegister.title == '') {
        this.titleError = '-';
        setTimeout(() => {
          this.titleError = 'กรุณากรอกคำนำหน้าชื่อ';
        }, 20);
        return false;
      }
      if (this.dataRegister.mfname == '') {
        this.mfnameError = '-';
        setTimeout(() => {
          this.mfnameError = 'กรุณากรอกชื่อ';
        }, 20);
        this.titleError = '';
        return false;
      }
      if (this.dataRegister.mlname == '') {
        this.mlnameError = '-';
        setTimeout(() => {
          this.mlnameError = 'กรุณากรอกนามสกุล';
        }, 20);
        this.mfnameError = '';
        return false;
      }else if (this.dataRegister.mphone == '') {
        this.phoneError = '-';
        setTimeout(() => {
          this.phoneError = 'กรุณากรอกเบอร์โทร';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
        return false;
      } else if (this.dataRegister.mphone.length <10) {
        this.phoneError = '-';
        setTimeout(() => {
          this.phoneError = 'กรุณากรอกเบอร์โทรใหถูกต้อง';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
        return false;
      } else if (chkphone != "02" && chkphone != "06" && chkphone != "08" && chkphone != "09") {
       
        this.phoneError = '-';
        setTimeout(() => {
          this.phoneError = 'กรุณากรอกเบอร์โทรใหถูกต้อง';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
        return false;
      }
      if (this.dataRegister.email == '') {
        this.emailError = '-';
        setTimeout(() => {
          this.emailError = 'กรุณากรอกนามอีเมล์';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        this.phoneError = '';
        return false;
      }else if (!chkEmail) {
        this.emailError = '-';
        setTimeout(() => {
          this.emailError = 'รูปแบบอีเมล์ ไม่ถูกต้อง';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        return false;
      }
      if (this.dataRegister.pass == '') {
        this.passError = '-';
        setTimeout(() => {
          this.passError = 'กรุณาตั้งรหัสผ่าน';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
        return false;
      }else if (this.dataRegister.pass.length < 4) {
        this.passError = 'กรุณาตั้งรหัสผ่านให้มากกว่า 4 หลัก';
        this.passError = '-';
        setTimeout(() => {
          this.passError = 'กรุณาตั้งรหัสผ่าน';
        }, 20);
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
          return false;
      }
      if (this.dataRegister.maddress == '') {
        this.addressError = '-';
        setTimeout(() => {
          this.addressError = 'กรุณากรอกทีอยู่';
        }, 20);
        this.passError = '';
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
        return false;
      }
        if (this.dataRegister.mppcard == '') {
        this.ppcardError = '-';
        setTimeout(() => {
          this.ppcardError = 'กรุณากรอกทีอยู่';
        }, 20);
        this.passError = '';
        this.mfnameError = '';
        this.mlnameError = '';
        this.emailError = '';
        this.addressError = '';
        return false;
      } else{
        this.mfnameError = '';
        this.addressError = '';
        this.mlnameError = '';
        this.emailError = '';
        this.passError = '';
        this.ppcardError = '';
        this.phoneError = '';
        try {
          let config = {
            method: "post",
            url: this.apiBase + "/member-register",
            headers: {
              "Content-Type": "application/json",
              'mode': 'no-cors',
              "rejectUnauthorized": "false",
            },
            rejectUnauthorized: false,
            data: this.dataRegister, // ข้อมูลที่ต้องการส่งไปยังเซิร์ฟเวอร์
          };

          await axios
            .request(config)
            .then((response) => {
              if (response.data.success) {
                localStorage.setItem("Profile", JSON.stringify(response.data.member));
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
    },
    seePassword(){
      this.dooPassword=true;
      setTimeout(() => {
        this.dooPassword=false;
      }, 1500);
    },
    seePass(){
      this.dooPass=true;
      setTimeout(() => {
        this.dooPass=false;
      }, 1500);
    },
    seePass2(){
      this.dooPass2=true;
      setTimeout(() => {
        this.dooPass2=false;
      }, 1500);
    },
    handleLogin: async function () {
      if (this.dataLogin.email == '') {
        this.emailError = '-';
        setTimeout(() => {
          this.emailError = 'กรุณากรอกอีเมล์';
        }, 20);
        // $("#exampleInputEmail1").focus();
        // $('input[name="exampleInputEmail1"]').focus();
        return false;
      } else if (this.dataLogin.password == '') {
        this.passError = '-';
        setTimeout(() => {
          this.passError = 'กรุณากรอกรหัสผ่าน';
        }, 20);
        return false;
      } else {
        this.emailError = '';
        this.passError = '';
        try {
          let config = {
            method: "post",
            url: this.apiBase + "/login",
            headers: {
              "Content-Type": "application/json",
            },
            data: this.dataLogin,
          };

          await axios
            .request(config)
            .then((response) => {
              if (response.data.success) {
                localStorage.setItem("Profile", JSON.stringify(response.data.member));
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
              } else {
                swal({
                  position: "top-center",
                  icon: "error",
                  title: response.data.message,
                  showConfirmButton: false,
                  timer: 1500
                });
                this.passError = '-';
                setTimeout(() => {
                  this.passError = 'รหัสผ่านไม่ถูกต้อง กรณาลองใหม่';
                }, 20);
                return false;
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

};
</script>

<style scope>
.card-profile {
  position: absolute;
  display: inline-grid;
  right: 20px;
  top: 50px;
  color: #666;
  border-radius: 8px;
  cursor: pointer;
  line-height: 1.8rem;
}

.router-link-active.router-link-exact-active {
  color: #000;
  text-decoration: none;
  border-bottom: 2px solid #fff;
  padding-bottom: 4px;
  font-weight: bold;
}

a,
a.router-link-active {
  margin: 0 10px;
  color: #fff;
  text-decoration: none;
}

a.router-link-active:hover {
  color: #fb0404;
  text-decoration: none;
  border-bottom: 2px solid #fff;
  padding-bottom: 4px;
  font-weight: bold;
}

.text-1xl {
  font-size: 1.4rem;
}

.bg-modal {
  background: rgba(0, 0, 0, 0.4);
}

.modal-content.rounded-2,
.rounded-2 {
  border-radius: 20px;
  overflow: hidden;
}

.cursor-pointer {
  cursor: pointer;
}

.dropdown-s {
  position: absolute;
  margin-top: 18px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
}

a.dropdown-item:hover {
  cursor: pointer;
  background-color: #ccc;
}
</style>
