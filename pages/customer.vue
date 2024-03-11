<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">

      <div class="col-12">
        <div class="card">
          <h6 class="header-pretitle">Overview</h6>
          <div class="card-header">
            <h1 class="card-header-title">ข้อมูลลูกค้า</h1>
            <div  class="d-flex justify-content-between">
              <input type="text" class="form-control me-2"  placeholder="ค้นหาด้วยชื่อ" v-model="nameSearch" @change="filteredCustomer()">
              <input type="text" class="form-control me-2" placeholder="ค้นหาด้วยเบอร์โทร" v-model="searchPhone" @change="filteredCustomer()">
            </div>
            <button type="button"
              class="btn btn-md btn-primary">เพิ่มลูกค้า</button>
          </div>
          <div class="table-responsive">
            <table class="table-nowrap card-table table table-sm">
              <thead>
                <tr>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer" class="is-sortable">ชื่อ - สกุล
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer" class="is-sortable">เบอร์โทรศัพท์
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer" class="is-sortable">จำนวนครั้งการใช้บริการ
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer" class="is-sortable">วันที่ใช้บริการล่าสุด
                  </th>
                  <th colspan="1" class="text-end">จัดการ</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in dataCustomers" :key="index">
                  <td>{{ item.fname + ' ' + item.lname }}</td>
                  <td>{{ item.phone }}</td>
                  <td class="text-center">55</td>
                  <td class="text-center">550</td>
                  <td><time datetime="2018-07-24">{{ formatDateThai(item.create_at) }}</time></td>
                  <td class="text-end">
                    <div class="avatar-group">
                      <button class="btn btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-eye" viewBox="0 0 16 16">
                          <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                          <path
                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                        </svg>
                      </button>
                      <button class="btn btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-pencil-square" viewBox="0 0 16 16">
                          <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                          <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
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

            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="openLocation = false">ปิด</button>
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
import { format } from 'date-fns';
import { th } from 'date-fns/locale';

export default {
  data() {
    return {
      isLogin: true,
      dateNow: new Date().toISOString().substr(0, 10),
      dataCustomers: [],
      dataCustomerForSearch:'',
      searchPhone:'',
      selectedDate: new Date(),
      formattedDate: '',
      openLocation: false,
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    }
  },

  watch: {

  },
  mounted() {
    this.getCustomer();
    const currentDate = new Date();

    // ดึงค่าเดือนปัจจุบัน
    const currentMonth = currentDate.getMonth();

    // เก็บค่าเดือนปัจจุบันลงในข้อมูลของ Vue
    this.currentMonth = currentMonth;
  },
  methods: {
    formatDateThai(date) {
      return format(new Date(date), 'MMM d, yyyy', { locale: th });
    },
    getCustomer: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/customer",
          headers: {
            "Content-Type": "application/json",
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataCustomers = response.data;
            this.dataCustomerForSearch = response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    filteredCustomer() {
      if (this.nameSearch && this.searchPhone) {
        this.dataCustomers = this.dataCustomerForSearch.filter(maid => maid.fname == this.nameSearch && maid.phone == this.searchPhone);
      } else if (this.nameSearch && !this.searchPhone) {
        this.dataCustomers = this.dataCustomerForSearch.filter(maid => maid.fname == this.nameSearch);
      } else if (!this.nameSearch && this.searchPhone) {
        this.dataCustomers = this.dataCustomerForSearch.filter(maid => maid.phone == this.searchPhone);
      } else {
        this.getCustomer(); // กรณีที่ไม่มีการกรอง
      }
      console.log(this.dataMaids);
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
</style>