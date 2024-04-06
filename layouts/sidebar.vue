<template>
  <div>
    <div class="topbar px-md-5 bg-danger d-flex justify-content-between">
      <div class="text-white text-1xl align-items-center d-flex justify-content-between">
        <img src="@/public/assets/images/logomdc.png" width="45" alt="">
        <span class="d-none d-md-block">MadamClean</span>
      </div>
      <div class="align-items-center d-flex">
        <div v-if="token">
        <nuxt-link to="/maid/" class="text-white" :class="{ 'active': $route.name === 'maid' }">หน้าหลัก</nuxt-link>
        <nuxt-link to="/maid/profile" class="text-white mx-0"
          :class="{ 'active': $route.name === 'maid-profile' }">ข้อมูลของฉัน</nuxt-link>
        </div>
        <div class="d-flex align-items-center justify-content-between btn btn-sm px-3 text-white ms-2"
          style="background:rgba(0,0,0,0.2); border-radius:10px;" @click="openToggle" v-if="token">
          <div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" class="d-none d-md-block">{{ authMaid.fullname }}</div>
          <div class="user ms-2 border text-center text-white bg-danger text-uppercase" style="width:38px; height:38px;" v-if="authMaid.img">
            <img :src="authMaid.img" alt="">
          </div>
          <div class="user ms-2 border text-center text-white bg-danger text-uppercase" v-else>{{ shotName }}</div>
        </div>
        
        <div class="" v-else>
          <button class="btn btn-sm text-muted bg-white ms-3" @click="logIn">เข้าสู่ระบบ</button>
        </div>
        <button class="btn text-white ms-2" @click="lockOut" v-if="token">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
            class="bi bi-box-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
              d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
            <path fill-rule="evenodd"
              d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
          </svg>
        </button>
      </div>
    </div>

  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      authMaid: "",
      token: "",
      shotName: "",
      loading: false,
      brandName: "madam-clean",
      currentMenu: 'slot',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL,
    };
  },
  mounted() {
    this.authMaid = JSON.parse(localStorage.getItem("Maid"));

    if (this.authMaid) {
      this.updateAuth();
      this.token = this.authMaid.token;
      let nn = this.authMaid.fullname.charAt(0);
      if (this.authMaid.fullname) {
        if (nn == 'เ' || nn == 'โ' || nn == 'ไ' || nn == 'ใ') {
          this.shotName = this.authMaid.fullname.charAt(1);
        } else {
          this.shotName = this.authMaid.fullname.charAt(0);
        }

        this.loading = true;
      }
    } else {
      this.$router.push('/maid/sign-in');
      this.loading = true;
    }
  },

  methods: {
    updateAuth: async function () {
      try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/maid-auth/"+this.authMaid.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                };
                await axios
                    .request(config)
                    .then((response) => {
                        localStorage.setItem("Maid", JSON.stringify(response.data.dataMaid));
                    })
                    .catch((error) => {
                        console.log('error',error)
                    });

            } catch (error) {
                console.error(error);
            }
    },
    swichMenu(name) {
      console.log(name);
      this.currentMenu = name;
      window.location = `../games/${name}`;
    },
    lockOut(){
      this.authMaid  = '';
      this.token  = '';
      localStorage.removeItem('Maid');
      this.$router.push('/maid/sign-in');
    }

  }
};
</script>

<style scope>
.sidebar {
  width: 250px;
  background-color: #333;
  color: #fff;
  padding: 20px;
}

.card {
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  padding: 10px;
}

.card h2 {
  color: #333;
  margin-bottom: 10px;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  margin-bottom: 10px;
}

a {
  text-decoration: none;
  color: #333;
  font-weight: bold;
}

a:hover {
  color: #007BFF;
}

.content {
  flex: 1;
  padding: 20px;
  background-color: #f4f4f4;
}

.active.card.menu {
  border: 2px solid #a08a0f;
  border-radius: 6px;
  display: flex;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  color: red;
  font-size: 20px;
  padding: 18px;
}

.card.menu {
  width: 100%;
  color: gold;
}

span.title {
  font-weight: bold;
  text-transform: uppercase;
}

.d-flex {
  display: flex;
}
</style>