<template>
  <div class="vh-100"></div>
</template>
<script>
export default {
  data() {
    return {
      
    }
  },
  computed: {

  },
  mounted() {
    localStorage.setItem("frist", 2);
    window.location=window.location.origin+'/booking?_t='+Date.now();
  }
}
</script>

<style scope>
.vuejs-datepicker {
  font-family: 'Tahoma', sans-serif;
}

.text-right {
  text-align: right;
}

.text-muted {
  color: #ccc;
}

.font-weight-bold {
  font-weight: bold;
}


@media (max-width: 768px) {
  .calendar{
    position: absolute;margin-top: 150px;width:450px;z-index:2;
  }
  .table.table-condensed.table-bordered.table-striped.small{
    font-size: 14px;
  }
}

@media (max-width: 480px) {
  .table.table-condensed.table-bordered.table-striped.small{
    font-size: 10px;
  }
  .calendar{
    position: absolute;margin-top: 150px;width:332px;z-index:2;
  }
  .span12 table.table.table-condensed{
    font-size: 12px;
  }
}
.d-calendar:hover {
  background-color: #ff0202;
  color: #fff;

}

.text-danger.text-small{
  color: #fff;
}
.d-calendar.d-calendar-active {
  background-color: #ff0202;
  color: #fff;
}

table.border {
  border-collapse: collapse;
  width: 100%;
}

table.border th,
table.border td {
  border: 1px solid #dee2e6;
  padding: 8px 0px;
  text-align: center;
  font-size: 0.8rem;
}

.btn-closes {
  position: absolute;
  right: 0;
  width: 50px;
}

.div-time {
  padding: 4px;
}

.div-time:hover {
  border-bottom: 2px solid #7b7e80;
  background-color: #dee2e6;
  padding: 4px;
}

td .bg-gray{
  background-color: #dee2e6;
}
.vh-60 {
    height: 60vh;
}
</style>