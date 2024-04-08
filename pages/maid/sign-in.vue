<template>
    <div class="row d-flex align-items-center justify-content-center py-4 bg-body-tertiary ">
        <div class="col-12 col-md-6">
            <div class="form-signin w-100 m-auto">
                <div>
                    <div class="text-center">
                        <img class="mb-4" src="/assets/images/maid.png" alt=""
                            style="width:186px;height:186px;margin:0 auto;" />
                    </div>
                    <h1 class="h3 mb-3 fw-normal">Maid sign in</h1>
                    <div v-if="isRepass">
                        <div class="border rounded px-4 mt-2">
                           
                            <div class="form-group my-3 text-muted">
                            <label for="registerInputEmail1">กรอกอีเมล์ใช้เข้าระบบ</label>
                            <input type="email" v-model="email" class="form-control text-muted"
                                ref="email" aria-describedby="emailHelp" placeholder="อีเมล์">
                            <small id="emailHelp" class="form-text text-danger">{{ emailError }}</small>
                            </div>
                            <div class="form-group my-3 text-muted">
                            <label for="registerInputPassword">รหัสผ่าน</label>
                            <input type="password" v-model="pass" class="form-control text-muted"
                                ref="pass" placeholder="รหัสผ่าน" v-if="!dooPass">
                                <input type="text" v-model="pass" class="form-control text-muted"
                                id="registerInputPassword" placeholder="รหัสผ่าน" v-else>
                            <small id="emailHelp" class="form-text text-danger">{{ passError }}</small>
                            <button class="btn btn-sm"  style="position: absolute;margin-left: 210px;margin-top: -34px;" @click="seePass">
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
                            <input type="password" v-model="cfpass" class="form-control text-muted"
                                ref="cfpass" placeholder="รหัสผ่าน" v-if="!dooPass2">
                                <input type="text" v-model="cfpass" class="form-control text-muted"
                                ref="cfpass" placeholder="รหัสผ่าน" v-else>
                            <small id="emailHelp" class="form-text text-danger">{{ cfpassError }}</small>
                            <button class="btn btn-sm" style="position: absolute;margin-left: 210px;margin-top: -34px;" @click="seePass2">
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
                        <div class="form-check text-start mt-3 px-0">
                            <div class="progress px-0 h-10" v-if="proGress > 0">
                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated px-0"
                                    role="progressbar" :aria-valuenow="proGress" aria-valuemin="0" aria-valuemax="100"
                                    :style="'width:' +proGress+'%'">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button @click="isRepass=false" class="btn text-primary btn-sm px-2 py-2 mb-3 mx-0" type="button" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                </svg>
                                เข้าสู่ระบบ
                            </button> 

                            <nuxt-link to="/" class="btn text-primary btn-sm px-2 py-2 mb-3 mx-0" type="button" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                                </svg>
                                กลับไปหน้าหลัก
                            </nuxt-link>
                        </div> 
                       
                        <button class="btn btn-danger w-100 my-4" type="button" @click="getRepass">บันทุกและ เข้าสู่ระบบ</button>
                    </div>
                    <div v-else>
                        <div class="form-floating">
                            <input type="username" ref="username" v-model="username" class="form-control"
                                placeholder="Username" />
                            <label for="floatingInput">อีเมล์เข้าใช้งาน <small class="text-danger">{{ userErr
                                    }}</small></label>
                        </div>
                        <div class="form-floating">
                            <input type="password" ref="password" v-model="password" class="form-control"
                                placeholder="Password" v-if="!dooPassword" />
                                <input type="text" ref="password" v-model="password" class="form-control"
                                placeholder="Password" v-else />
                            <label for="floatingPassword">รหัสผ่าน <small class="text-danger">{{ passErr }}</small></label>

                            <button class="btn btn-sm" style="position: absolute;right: 10px; margin-top: -45px;" @click="seePassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash text-muted" viewBox="0 0 16 16"  v-if="!dooPassword">
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

                        <div class="form-check text-start mt-3 px-0">
                            <div class="progress px-0 h-10" v-if="proGress > 0">
                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated px-0"
                                    role="progressbar" :aria-valuenow="proGress" aria-valuemin="0" aria-valuemax="100"
                                    :style="'width:' +proGress+'%'">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button @click="isRepass=true" class="btn text-primary btn-sm px-2 py-2 mb-3 mx-0" type="button" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16">
                                    <path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2M2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                </svg>
                                ลืมรหัสผ่าน
                            </button> 

                            <nuxt-link to="/" class="btn text-primary btn-sm px-2 py-2 mb-3 mx-0" type="button" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door" viewBox="0 0 16 16">
                                    <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4z"/>
                                </svg>
                                กลับไปหน้าหลัก
                            </nuxt-link>
                        </div> 
                        <button class="btn btn-danger w-100 py-2" type="button" @click="getLogin">เข้าสู่ระบบ</button>
                        
                    </div>
                    <p class="mt-2 mb-3 text-body-secondary">© 2024 Version 0.0.1</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import swal from 'sweetalert';

export default {
    data() {
        return {
            isLogin: true,
            dateNow: new Date().toISOString().substr(0, 10),
            username: '',
            password: '',
            email: '',
            pass: '',
            cfpass: '',
            emailError: '',
            passError: '',
            cfpassError: '',
            userErr: '',
            passErr: '',
            proGress: 0,
            selectedDate: new Date(),
            formattedDate: '',
            openLocation: false,
            isRepass: false,
            dooPassword: false,
            dooPass2: false,
            dooPass: false,
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
        getRepass: async function(){
            if (this.email == '') {
                this.emailError = '';
                setTimeout(() => {
                    this.emailError = 'กรุณากรอกอีเมลเข้าใช้งาน';
                }, 20);
                this.$refs.email.focus();
                return false;
            } else if (this.pass == '') {
                this.passError = '';
                setTimeout(() => {
                    this.passError = 'กรุณากรอกชรหัสผ่าน';
                }, 20);
                
                this.emailError = '';
                this.$refs.pass.focus();
                return false;
            } else if (this.cfpass == '') {
                this.cfpassError = '';
                setTimeout(() => {
                    this.cfpassError = 'กรุณากรอกรหัสผ่าน';
                }, 20);
                
                this.passError = '';
                this.emailError = '';
                this.$refs.cfpass.focus();
            } else if (this.cfpass != this.pass) {
                this.cfpassError = '';
                setTimeout(() => {
                    this.cfpassError = 'ยืนยันรหัสผ่านไม่ถูกต้อง';
                }, 20);
                
                this.passError = '';
                this.emailError = '';
                this.$refs.cfpass.focus();
            } else {
                this.userError = '';
                this.passError = '';
                this.cfpassError = '';
                this.proGress = 10;
                setTimeout(() => {
                    this.proGress = 100;
                }, 1000);
                try {
                    let config = {
                        method: "post",
                        url: this.apiBase + "/maid-repass",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        data: {
                            email: this.email,
                            pass: this.cfpass
                        }
                    };

                    await axios
                        .request(config)
                        .then((response) => {
                            if (response.data.success) {
                                localStorage.setItem("Maid", JSON.stringify(response.data.dataMaid));
                                Swal.fire({
                                    position: "top-center",
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                }).then(() => {
                                    this.$router.push('/maid');
                                    window.location = '/maid';
                                });
                                setTimeout(() => {
                                    window.location = '/maid';
                                }, 1500);
                            } else {
                                swal({
                                    position: "top-center",
                                    icon: "error",
                                    title: response.data.message,
                                    showConfirmButton: true,
                                });
                                
                                this.passError = '-';
                                setTimeout(() => {
                                    this.passError = response.data.message;
                                }, 20);
                                setTimeout(() => {
                                    this.proGress= 0;
                                }, 1400);
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
        },
        getLogin: async function(){
            if (this.username == '') {
                this.userErr = 'กรุณากรอกชื่อเข้าใช้งาน';
                this.passErr = '';
                this.$refs.username.focus();
                return false;
            } else if (this.password == '') {
                this.passErr = 'กรุณากรอกชรหัสผ่าน';
                this.userErr = '';
                this.$refs.password.focus();
                return false;
            } else {
                this.userErr = '';
                this.passErr = '';
                this.proGress = 10;
                setTimeout(() => {
                    this.proGress = 100;
                }, 1200);

                try {
                    let config = {
                        method: "post",
                        url: this.apiBase + "/maid-login",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        data: {
                            username: this.username,
                            password: this.password
                        }
                    };

                    await axios
                        .request(config)
                        .then((response) => {
                            if (response.data.success) {
                                localStorage.setItem("Maid", JSON.stringify(response.data.dataMaid));
                                Swal.fire({
                                    position: "top-center",
                                    icon: "success",
                                    title: response.data.message,
                                    showConfirmButton: false,
                                }).then(() => {
                                    this.$router.push('/maid');
                                    window.location = '/maid';
                                });
                                setTimeout(() => {
                                    window.location = '/maid';
                                }, 1500);
                            } else {
                                swal({
                                    position: "top-center",
                                    icon: "error",
                                    title: response.data.message,
                                    showConfirmButton: true,
                                });
                                
                                this.passError = '-';
                                setTimeout(() => {
                                    this.passError = 'รหัสผ่านไม่ถูกต้อง กรณาลองใหม่';
                                }, 20);
                                setTimeout(() => {
                                    this.proGress= 0;
                                }, 1400);
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
}
</script>

<style>
.vuejs-datepicker {
    font-family: 'Tahoma', sans-serif;
}

.text-right {
    text-align: right;
}

.form-signin {
    max-width: 330px;
    padding: 1rem;
}

.m-auto {
    margin: auto !important;
}

.vh-100 {
    height: 100vh;
}
</style>