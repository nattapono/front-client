<template>
  <div class="header" v-if="$route.name != 'maid-register' && $route.name != 'sign-in'">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row align-items-end row">
          <div class="col">
            <h1 class="header-title"></h1>
          </div>
          <div class="col-auto">
            <button type="button" class="lift btn btn-white">ผู้ดูแล <span class="text-danger text-uppercase">{{admin.user }}</span></button>
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
      admin: '',
      auth: '',
      isModalOpen: false,
      isLogin: true,
      toggle: false,
      
      routers: '',
      loading: false,
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  mounted() {

    this.routers =  this.$route.name;
   
    this.admin = JSON.parse(localStorage.getItem("Admin-mdc"));
    if (this.admin) {
      this.auth = this.admin.token;
      if (this.admin.user) {
        this.shotName = this.admin.user.charAt(0);
        this.loading = true;
        if(this.routers=='sign-in'){
          window.location = '/';
          this.loading = true;
        }
      }
    } else {
      this.loading = true;
      if(this.routers!='sign-in'){
        window.location = 'sign-in';
      }
    }
  
    document.body.addEventListener('click', this.handleClick);
  },
  beforeDestroy() {
    document.body.removeEventListener('click', this.handleClick);
  },

  methods: {
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
      this.textTitle = 'เข้าสู่ระบบ';
    },
    logOut() {
      this.toggle = false;
      this.isModalOpen = false;
      this.isLogin = false;
      this.isRegister = false;
      this.textTitle = 'เข้าสู่ระบบ';

      localStorage.removeItem('Admin-mdc');
      this.auth = '';
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
    },
    handleRegister: async function () {
      if (this.dataRegister.fname == '') {
        this.fnameError = '-';
        setTimeout(() => {
          this.fnameError = 'กรุณากรอกชื่อ';
        }, 20);
        return false;
      }
      if (this.dataRegister.lname == '') {
        this.lnameError = '-';
        setTimeout(() => {
          this.lnameError = 'กรุณากรอกนามสกุล';
        }, 20);
        this.fnameError = '';
        return false;
      }
      if (this.dataRegister.email == '') {
        this.emailError = '-';
        setTimeout(() => {
          this.emailError = 'กรุณากรอกนามอีเมล์';
        }, 20);
        this.fnameError = '';
        this.lnameError = '';
        return false;
      }
      if (this.dataRegister.pass == '') {
        this.passError = '-';
        setTimeout(() => {
          this.passError = 'กรุณาตั้งรหัสผ่าน';
        }, 20);
        this.fnameError = '';
        this.lnameError = '';
        this.emailError = '';
        return false;
      } else {
        this.fnameError = '';
        this.lnameError = '';
        this.emailError = '';
        this.passError = '';
        try {
          let config = {
            method: "post",
            url: this.apiBase + "/members",
            headers: {
              "Content-Type": "application/json",
            },
            data: this.dataRegister, // ข้อมูลที่ต้องการส่งไปยังเซิร์ฟเวอร์
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
.card-admin {
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
}</style>