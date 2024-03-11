<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">
        <div class="col-12 my-4 pb-2"></div>
        <div class="col-12 col-lg-6 col-sm-6 ">
          <h4>เกี่ยวกับเรา</h4>      
          <div class="row  mt-2">
            
          </div>
        </div>
    </div>

      <!-- modal -->
      <div v-if="openLocation" class="modal fade show d-block bg-modal">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content rounded-2">
            <div class="modal-header text-white bg-danger py-2 ">
              <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }}</h6>
              <button type="button" class="close text-white btn text-xl" @click="openLocation =false" style="font-size: 33px;line-height: 0;">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="openLocation =false">ปิด</button>
              <button type="button" class="btn btn-primary" v-if="isRegister" @click="handleRegister()">{{ textTitle }}</button>
              <button type="button" class="btn btn-primary" v-else @click="handleLogin()">{{ textTitle }}</button>
            </div>
          </div>
        </div>
      </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      isLogin:true,
      dateNow: new Date().toISOString().substr(0, 10) ,
      dataMount:[
        {"name":"ม.ค."},
        {"name":"ก.พ."},
        {"name":"มี.ค."},
        {"name":"เม.ย."},
        {"name":"พ.ค."},
        {"name":"มิ.ย."},
        {"name":"ก.ค."},
        {"name":"ส.ค."},
        {"name":"ก.ย."},
        {"name":"ต.ค."},
        {"name":"พ.ย."},
        {"name":"ธ.ค."},
      ],
      selectedDate: new Date(),
      formattedDate: '',
      openLocation:false
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
    pinLocation() {
      this.openLocation = true;
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
</style>