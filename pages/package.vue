<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">

      <div class="col-8">
        <div class="card">
          <h6 class="header-pretitle">Overview</h6>
          <div class="card-header">
            <h1 class="card-header-title">ข้อมูลราคา / ค่าบริการ</h1>
            <nuxt-link to="addpackage" class="btn btn-sm btn btn-primary">เพิ่มราคา</nuxt-link>

          </div>
          <div class="table-responsive">
            <table class="table-nowrap card-table table table-sm">
              <thead>
                <tr>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px" class="is-sortable">ชื่อแพ็คเกจ
                  </th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px" class="is-sortable">Status</th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px" class="is-sortable"></th>
                  <th colspan="1" title="Toggle SortBy" style="cursor:pointer; font-size:18px" class="is-sortable"></th>
                  <th colspan="1" class="text-end"></th>
                  <th colspan="1" class="text-end">&nbsp;</th>
                </tr>
              </thead>

              <tbody v-for="(rows, index) in dataPackages" :key="index">
                <tr>
                  <th>{{ rows.name }}</th>
                  <td>
                    <span class="text-success" v-if="rows.status === 1">● ใช้งาน</span>
                    <span class="text-danger" v-if="rows.status === 2">● ปิด</span>
                  </td>
                  <td> </td>
                  <td>
                    <time datetime="2018-07-24">
                      {{ formatDateThai(rows.create_at) }}
                    </time>
                  </td>
                  <td class="text-end">
                    <div class="avatar-group"></div>
                  </td>
                  <td class="text-end">
                    <button class="btn btn-sm" @click="dataSet(rows)">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                        viewBox="0 0 16 16">
                        <path
                          d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
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
                    <td></td>
                    <td colspan="5" class="bg-gray text-muted">
                      <div v-if="edit">
                        <label for="">ชื่อแพ็คเกจ</label>
                        <input type="text" class="form-control" v-model="dataItem.name">
                      </div>
                      <div v-else> {{ dataItem.name }}</div>
                    </td>
                  </tr>
                  <tr v-for="(item, i) in dataItem.items" :key="i">
                    <td></td>
                    <td></td>
                    <td>
                      <div v-if="edit">
                        <label for="">ชั่วโมง</label>
                        <input type="text" class="form-control" v-model="item.hour">
                      </div>
                      <div v-else> {{ item.hour }} ชม.</div>

                    </td>
                    <td>
                      <div v-if="edit">
                        <label for="">ราคา</label>
                        <input type="text" class="form-control" v-model="item.amount">
                      </div>
                      <div v-else> {{ item.amount }} บาท</div>
                    </td>
                    <td v-if="edit">
                      <button class="btn btn-danger btn-sm py-2 px-3 ms-2 mt-4" @click="delItemPk(i)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-trash-fill" viewBox="0 0 16 16">
                          <path
                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                      </button>
                    </td>
                  </tr>
                  <tr v-for="(row, i) in pkItem" :key="i">
                    <td></td>
                    <td></td>
                    <td>

                      <label for="">ชั่วโมง</label>
                      <input type="text" name="" id="" oninput="this.value = this.value.replace(/[^0-9_ ]/g, '');"
                        v-model="row.hour" class="form-control" placeholder="จำนวนชัวโมง">


                    </td>
                    <td>

                      <label for="">ราคา</label>
                      <input type="text" name="" id="" oninput="this.value = this.value.replace(/[^0-9_]/g, '');"
                        v-model="row.amount" class="form-control" placeholder="จำนวนราคา">

                    </td>
                    <td>
                      <button class="btn btn-danger btn-sm py-2 px-3 ms-2 mt-4" @click="delItemPk(i)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                          class="bi bi-trash-fill" viewBox="0 0 16 16">
                          <path
                            d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                      </button>
                    </td>
                  </tr>
                  <tr v-if="edit">
                    <td></td>
                    <td></td>
                    <td>
                      <button class="btn btn-outline-danger btn-sm py-2 px-3 ms-2"
                        @click="addItemPk">เพิ่มชั่วโมง</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeModal">ปิด</button>
            <button type="button" class="btn btn-primary" @click="handleEdit(dataItem.items)"  v-if="!edit">
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
      apiBase: import.meta.env.VITE_AGENT_BASE_URL
    }
  },
  mounted() {
    this.getPackage();
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
    dataSet(item) {
      this.openData = true;
      this.dataItem = item;
    },
    addItemPk() {
      // this.pkItem.push({ "hour": 1, "amount": 0 });
      this.dataItem.items.push({ "hour": 1, "amount": 0 ,"package_id":this.dataItem.id});
    },
    delItemPk(index) {
      if (this.dataItem.items.length > 1) {
        this.dataItem.items.splice(index, 1);
      }else{
          this.dataItem.items=[];
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
    handleSaveEdit: async function(data) {
      try {
          let config = {
            method: "put",
            url: this.apiBase + "/packages/"+this.dataItem.id,
            headers: {
              "Content-Type": "application/json",
              "Authorization":localStorage.getItem("Admin-mdc").token
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
    getPackage: async function () {
      try {
        let config = {
          method: "get",
          url: this.apiBase + "/packages",
          headers: {
            "Content-Type": "application/json",
            "Authorization":localStorage.getItem("Admin-mdc").token
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