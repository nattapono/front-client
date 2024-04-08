<template>
  <div>
    <div class="row mb-5 d-flex align-items-center justify-content-center">

        <div class="col-12 col-lg-10 col-sm-10 my-4 pb-2">
          <h4 class="mx-4 mx-md-0">บริการ</h4>      
          <div class="row  mt-2">
            <div class="col-12">
              <Package />
            </div>
          </div>
        </div>
    </div>
  </div>
</template>

<script>
    import Package from "../components/package.vue";
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