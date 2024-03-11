<template>
    <div class="row d-flex align-items-center justify-content-center py-4 bg-body-tertiary vh-100">
        <div class="col-12 col-md-6">
            <div class="form-signin w-100 m-auto">
                <form>
                    <div class="text-center">
                        <img class="mb-4" src="/assets/images/maid.png" alt=""
                            style="width:186px;height:186px;margin:0 auto;" />
                    </div>
                    <h1 class="h3 mb-3 fw-normal">Admin sign in</h1>

                    <div class="form-floating">
                        <input type="username" ref="username" v-model="username" class="form-control"
                            placeholder="Username" />
                        <label for="floatingInput">ชื่อเข้าใช้งาน <small class="text-danger">{{ userErr
                                }}</small></label>
                    </div>
                    <div class="form-floating">
                        <input type="password" ref="password" v-model="password" class="form-control"
                            placeholder="Password" />
                        <label for="floatingPassword">รหัสผ่าน <small class="text-danger">{{ passErr }}</small></label>
                    </div>

                    <div class="form-check text-start my-3 px-0">
                        <div class="progress px-0 h-10" v-if="proGress > 0">
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated px-0"
                                role="progressbar" :aria-valuenow="proGress" aria-valuemin="0" aria-valuemax="100"
                                :style="'width:' +proGress+'%'">
                            </div>
                        </div>
                        <!-- <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault" />
                        <label class="form-check-label" for="flexCheckDefault">
                            Remember me
                        </label> -->
                    </div>
                    <button class="btn btn-danger w-100 py-2" type="button" @click="getLogin">เข้าสู่ระบบ</button>
                    <p class="mt-5 mb-3 text-body-secondary">© 2024 Version 0.0.1</p>
                </form>
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
            isLogin: true,
            dateNow: new Date().toISOString().substr(0, 10),
            username: '',
            password: '',
            userErr: '',
            passErr: '',
            proGress: 0,
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
    },
    methods: {
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
                        url: this.apiBase + "/admin-login",
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
                                localStorage.setItem("Admin-mdc", JSON.stringify(response.data.member));
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