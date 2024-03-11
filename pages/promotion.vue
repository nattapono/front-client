<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">

      <div class="col-12 co-md-10">
        <div class="card">
          <h6 class="header-pretitle">Overview</h6>
          <div class="card-header">
            <h1 class="card-header-title">ข้อมูลโปรมชั่น</h1>
            <nuxt-link to="add-promotion" class="btn btn-sm btn btn-primary">เพิ่มโปรมชั่น</nuxt-link>

          </div>
          <div class="table-responsive">
            <table class="table-nowrap card-table table table-sm">
              <thead>
                <tr>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px" class="is-sortable">ชื่อโปรมชั่น
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px" class="is-sortable">Status</th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer" class="is-sortable"></th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer" class="is-sortable"></th>
                  <th colspan="1" class="text-end"></th>
                  <th colspan="1" class="text-end">&nbsp;</th>
                </tr>
              </thead>

              <tbody v-for="(rows, index) in dataPackages" :key="index">
                <tr>
                  <th>{{ rows.name }} {{ rows.amount }}
                    <span v-if="rows.unit == 'percent'">%</span>
                    <span v-else>{{ rows.unit }} </span>
                  </th>
                  <td>
                    <img :src="rows.imageUrl" alt="" height="80" class="border p-1">
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="text-success" v-if="rows.isActive === 1">● ใช้งาน</span>
                    <span class="text-danger" v-if="rows.isActive === 2">● ปิด</span>
                  </td>
                  <td>
                    <time datetime="2018-07-24">
                      {{ formatDateThai(rows.create_at) }}
                    </time>
                  </td>
                  <td class="text-end">
                    <div class="form-switch" @change="updateStatus(rows)">
                      <input type="checkbox" v-if="rows.isActive==1" checked id="cardToggle" class="form-check-input">
                      <input type="checkbox" v-else id="cardToggle" class="form-check-input">
                    </div>

                  </td>
                  <td class="text-end">
                    <button class="btn btn-sm" @click="dataSet(rows)">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-eye" viewBox="0 0 16 16">
                        <path
                          d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                        <path
                          d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                      </svg>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- modal -->
    <div v-if="openData" class="modal fade show d-block bg-modal">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded-2">
          <div class="modal-header text-white bg-danger py-2 ">
            <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h6>
            <button type="button" class="close text-white btn text-xl" @click="closeModal"
              style="font-size: 33px;line-height: 0;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>
              <table class="table">
                <tbody>
                  <tr v-if="!dataItem || dataItem.length < 1">
                    <td colspan="7" class="text-center bg-gray text-muted"> ไม่มีข้อมูล </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>

                    </td>
                    <td colspan="5" class="bg-gray text-muted">
                      <div v-if="edit">
                        <label for="">ชื่อโปรมชั่น</label>
                        <input type="text" class="form-control" v-model="dataItem.name">
                        <div class="d-flex align-content-center mb-2">
                          <div class="w-50 me-2">
                            <label for="">ส่วนลด</label>
                            <input type="text" class="form-control" v-model="dataItem.amount">
                          </div>
                          <div class="w-50">
                            <label for="">หน่วยนับ</label>
                            <select name="" id="" v-model="dataItem.unit" class="form-control w-100">
                              <option value="บาท">บาท</option>
                              <option value="percent">%</option>
                            </select>
                          </div>

                        </div>
                        <input type="file" @change="handleFileUpload">
                          <div v-if="imageData" class="my-2">
                            <img :src="imageData" alt="Uploaded Image" width="200">
                          </div>
                          <div class="form-group w-100">
                            <label for="">รายละเอียด</label>
                            <textarea name="" id="" cols="30" rows="4" class="form-control" placeholder="รายละเอียด"
                              v-model="dataItem.description"></textarea>
                          </div>
                      </div>
                      <div v-else>
                        <p>
                          <img :src="dataItem.imageUrl" alt="" height="100" class="border p-1">
                        </p>
                        <p class="text-dark">{{ dataItem.name }} </p>
                        ลด {{ dataItem.amount }}
                        <span v-if="dataItem.unit == 'percent'">%</span>
                        <span v-else>{{ dataItem.unit }} </span>
                        <p>{{ dataItem.description }}</p>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" @click="closeModal">ปิด</button>
            <button type="button" class="btn btn-primary" @click="handleEdit(dataItem.items)" v-if="!edit">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path
                  d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                <path fill-rule="evenodd"
                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
              </svg>
              แก้ไข </button>
            <button type="button" class="btn btn-primary" @click="handleSaveEdit(dataItem)" v-else>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path
                  d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                <path fill-rule="evenodd"
                  d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
              </svg>
              บันทึก </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';
import { format } from 'date-fns';
import { th } from 'date-fns/locale';
export default {
  data() {
    return {
      isLogin: true,
      edit: false,
      openData: false,
      pkItem: [],
      dataItem: [],
      dateNow: new Date().toISOString().substr(0, 10),
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
      dataPackages: [],
      imageUrl: '',
      imageData: '',
      dataPromotion:'',
      dataPromotionForSearch:'',
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    }
  },

  watch: {

  },
  mounted() {
    this.getPromotion();
    const currentDate = new Date();

    // ดึงค่าเดือนปัจจุบัน
    const currentMonth = currentDate.getMonth();

    // เก็บค่าเดือนปัจจุบันลงในข้อมูลของ Vue
    this.currentMonth = currentMonth;
  },
  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.imageData = URL.createObjectURL(file);

      const reader = new FileReader();
            let base64Image = ''; // เริ่มต้นด้วยค่าว่าง
            reader.onload = (e) => {
                base64Image = e.target.result;
                this.dataItem.imageUrl = base64Image; // กำหนดค่า this.imageData ภายใน onload
            };
            reader.readAsDataURL(file);

    },
    formatDateThai(date) {
      return format(new Date(date), 'MMM d, yyyy', { locale: th });
    },
    dataSet(item) {
      this.openData = true;
      this.dataItem = item;
    },
    addItemPk() {
      // this.pkItem.push({ "hour": 1, "amount": 0 });
      this.dataItem.items.push({ "hour": 1, "amount": 0, "package_id": this.dataItem.id });
    },
    delItemPk(index) {
      if (this.dataItem.items.length > 1) {
        this.dataItem.items.splice(index, 1);
      } else {
        this.dataItem.items = [];
      }
    },
    closeModal(item) {
      this.openData = false;
      this.edit = false;
      this.pkItem = [];
    },
    handleEdit(data) {
      this.edit = true;
      this.hour = data.hour;
      this.amount = data.amount;
    },
    
    handleSaveEdit: async function (data) {
      try {
        let config = {
          method: "put",
          url: this.apiBase + "/promotion/" + this.dataItem.id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Admin-mdc").token
          },
          data: this.dataItem, // ข้อมูลที่ต้องการส่งไปยังเซิร์ฟเวอร์
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
    getPromotion: async function () {
      let token = localStorage.getItem("Admin-mdc");
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/promotion",
          headers: {
            "Content-Type": "application/json",
            "Authorization": token.token
          },
        };

        await axios
          .request(config)
          .then((response) => {
            this.dataPackages = response.data;
          })
          .catch((error) => {
            console.log(error);
          });

      } catch (error) {
        console.error(error);
      }
    },
    updateStatus:  async function(row) {

      try {
        let config = {
          method: "put",
          url: this.apiBase + "/promotion-status/"+row.id,
          headers: {
            "Content-Type": "application/json",
            "Authorization": localStorage.getItem("Admin-mdc").token
          },
          data:{
            isActive:row.isActive
          }
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
              });
              this.getPromotion();
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

.bg-gray {
  background-color: #ccc;
}
</style>