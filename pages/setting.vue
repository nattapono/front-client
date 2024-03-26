<template>
    <div class="row mb-5 d-flex align-items-center justify-content-center">

        <div class="col-12 col-md-10">
            <div class="card">
                <div class="card-title d-flex justify-content-start">
                    <h3>ตั้งค่าธนาคาร
                        <button class="btn btn-outline-danger mx-3 my-0" @click="addBank">+ เพิ่มธนาคาร</button>
                    </h3>
                </div>
                <hr>
                <div class="row border">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ธนาคาร</th>
                                    <th>ชื่อธนาคาร</th>
                                    <th>เลขที่บัญชี</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                            </thead>
                            <tbody v-for="(row, index) in myBankData" :key="index">
                                <tr>
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        <div v-for="(item, i) in bankData" :key="i">
                                            <div v-if="row.bank_type == item.id">
                                                <img :src="item.img" :alt="item.shortname" class="around" width="35">
                                                {{ item.name }}
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        {{ row.bank_name }} {{ row.bank_surname }}
                                    </td>
                                    <td>
                                        {{ row.bank_number }}
                                    </td>
                                    <td class="d-flex justify-content-between">
                                        <div class="form-switch" @change="updateStatus(row)">
                                            <input type="checkbox" v-if="row.bank_status == 1" checked id="cardToggle" class="form-check-input">
                                            <input type="checkbox" v-else id="cardToggle" class="form-check-input">
                                        </div>
                                        <button class="btn btn-sm btn-outline-info" @click="dataSet(row)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path
                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                <path
                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="!myBankData || myBankData == ''">
                                    <td colspan="5">ไม่มีข้อมูลธนาคาร</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-10">
            <div class="card">
                <h4>ตั้งค่า</h4>
                <div class="col-6 border p-3 text-muted" v-if="!editData">
                    <label for="">เบอรโทร</label>
                    <input readonly="readonly" type="text" class="form-control" v-model="dataSetting.phone"
                        placeholder="เบอรโทร">
                    <label for="">ที่อยู่</label>
                    <input readonly="readonly" type="text" class="form-control" v-model="dataSetting.address"
                        placeholder="ที่อยู่">
                    <label for="">ลิ้งค์ไลน์</label>
                    <input readonly="readonly" type="text" class="form-control" v-model="dataSetting.linkLine"
                        placeholder="ลิ้งค์ไลน์">
                    <label for="">ภาษีมูลค่าเพิ่ม % (e-tax invoice)</label>
                    <input readonly="readonly" type="text" class="form-control" v-model="dataSetting.eTax"
                        placeholder="ภาษีมูลค่าเพิ่ม">
                    <label for="">ภาษีมูลค่าเพิ่ม % (e-receipt)</label>
                    <input readonly="readonly" type="text" class="form-control" v-model="dataSetting.eReceipt"
                        placeholder="กำหนดลิตร">
                    <button class="btn btn-outline-danger mt-3" @click="getEditData"> <i class="fa fa-pencil"></i>
                        แก้ไข</button>
                </div>

                <div class="col-6 border p-3 text-muted" v-else>
                    <label for="">เบอรโทร</label>
                    <input type="text" class="form-control" v-model="dataSetting.phone" name="phoneNumber"
                        placeholder="เบอรโทร">
                    <label for="">ที่อยู่</label>
                    <input type="text" class="form-control" v-model="dataSetting.address" name="address"
                        placeholder="ที่อยู่">
                    <label for="">ลิ้งค์ไลน์</label>
                    <input type="text" class="form-control" v-model="dataSetting.linkLine" name="linkline"
                        placeholder="ลิ้งค์ไลน์">
                    <label for="">ภาษีมูลค่าเพิ่ม % (e-tax invoice)</label>
                    <input type="text" class="form-control" v-model="dataSetting.eTax" name="vat"
                        placeholder="ภาษีมูลค่าเพิ่ม">
                    <label for="">ภาษีมูลค่าเพิ่ม % (e-receipt)</label>
                    <input type="text" class="form-control" v-model="dataSetting.eReceipt" name="low"
                        placeholder="กำหนดลิตร">
                    <button class="btn btn-danger mt-3" @click="closeEditData"> <i class="fa fa-close"></i> ปิด</button>
                    <button class="btn btn-outline-success mt-3" @click="saveDataCompany"> <i class="fa fa-save"></i>
                        บันทึก</button>
                </div>
                <!-- socail -->
                
            </div>
        </div>

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
                                                <div v-for="(item, i) in bankData" :key="i">
                                                        <div v-if="dataItem.bank_type == item.id">
                                                            <img :src="item.img" :alt="item.shortname" class="around" width="85">
                                                            <p class="text-dark">ธนาคาร: {{ item.name }}</p>
                                                        </div>
                                                    </div>
                                                <label for="">ชื่อธนาคาร</label>
                                                <input type="text" class="form-control" v-model="dataItem.bank_name">
                                                <div class="d-flex align-content-center mb-2">
                                                    <div class="w-50 me-2">
                                                        <label for="">ชื่อบัญชี</label>
                                                        <input type="text" class="form-control"
                                                            v-model="dataItem.bank_name">
                                                    </div>
                                                    <div class="w-50">
                                                        <label for="">เลขที่บัญชี</label>
                                                        <input type="text" class="form-control"
                                                            v-model="dataItem.bank_number">
                                                    </div>

                                                </div>
                                            
                                            </div>
                                            <div v-else>
                                               
                                                    <div v-for="(item, i) in bankData" :key="i">
                                                        <div v-if="dataItem.bank_type == item.id">
                                                            <img :src="item.img" :alt="item.shortname" class="around" width="85">
                                                            <p class="text-dark">ธนาคาร: {{ item.name }}</p>
                                                        </div>
                                                    </div>
                                     
                                                
                                                ชื่อบัญชี: {{ dataItem.bank_name }} {{ dataItem.bank_surname }}
                                               
                                                <p>เลขที่บัญชี: {{ dataItem.bank_number }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" @click="closeModal">ปิด</button>
                        <button type="button" class="btn btn-primary" @click="handleEdit(dataItem.items)" v-if="!edit" disabled>
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
            myBankData: '',
            bankName: '',
            bankSurname: '',
            bankNumber: '',
            bankType: '',
            bankStatus: '',
            textStatus: '',
            textDelete: '',
            dataSetting: '',
            editId: '',
            selectBank: '',
            auth: '',
            editData: false,
            bankData: [
                { "img": "https://www.logolynx.com/images/logolynx/ac/acc6db2f0532b74dff3f2525adbc56a3.jpeg", "id": "1", "shortname": "kbank", "name": "กสิกรไทย" },
                { "img": "https://media-exp1.licdn.com/dms/image/C510BAQElNZUFumis3Q/company-logo_200_200/0/1519912092504?e=2159024400&v=beta&t=UXn2iHDhq4cwYLoRjYxo3FgGkjJR3ekhlnDo-dw5KB4", "id": "2", "shortname": "scb", "name": "ไทยพาณิชย์" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXMiwU15ngT63kAECxWfVQUvzjkOsbB_ujb3VAlr1VZYThd1EQ_JxFNCTVC7TwuREYBb8&usqp=CAU", "id": "3", "shortname": "bbl", "name": "กรุงเทพ" },
                { "img": "https://upload.wikimedia.org/wikipedia/en/thumb/f/f0/Krung_Thai_Bank_logo.svg/220px-Krung_Thai_Bank_logo.svg.png", "id": "4", "shortname": "ktb", "name": "กรุงไทย" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGqrt4IpIhN4sOmI3du7EJiFmB50Z5sTHzd7TxmSDjLn1KF0pL38fjOZPa7vn3NJJqIkU&usqp=CAU", "id": "5", "shortname": "bay", "name": "กรุงศรีอยุธยา" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJ0qwsNsBRVA1r0DkIg3DoYNfpRGrua_FQkIVSkM09LBJJOwKMT7NSIQugWZtHGq_hd_s&usqp=CAU", "id": "6", "shortname": "gsb", "name": "ออมสิน" },
                { "img": "https://media.glassdoor.com/sqll/11462/united-overseas-bank-squarelogo-1464075746597.png", "id": "7", "shortname": "uob", "name": "ยูโอบี" },
                { "img": "https://res.cloudinary.com/crunchbase-production/image/upload/c_lpad,h_170,w_170,f_auto,b_white,q_auto:eco,dpr_1/p8x01c4i9u0hmierixpe", "id": "8", "shortname": "lhb", "name": "แลนด์&เฮ้าส์" },
                { "img": "https://marketsavvy.co/wp-content/uploads/2020/04/GHlogo-300x300.jpg", "id": "9", "shortname": "ghb", "name": "อาคารสงเคราะห์" },
                { "img": "https://i.pinimg.com/originals/06/70/69/067069fcbe69567ec81b0240996c0632.png", "id": "11", "shortname": "ibank", "name": "อิสลามแห่งประเทศไทย" },
                { "img": "https://upload.wikimedia.org/wikipedia/en/f/f8/Tisco_logo.png", "id": "12", "shortname": "tisco", "name": "ทิสโก้" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTJZHdAC3gRb5lGbO8Op2Qqui2LRh1mMRtgOk9SGkMigvTHDYyNZjl70oGDxN_IddXSpXM&usqp=CAU", "id": "13", "shortname": "kk", "name": "เกียรตินาคิน" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrs-WPHU6UjzNTDQILwK1x0WvRP0Un5eATlEaUb-llTIbrFUXEXGeO-HxooJoyhyKdE2A&usqp=CAU", "id": "14", "shortname": "baac", "name": "ธกส." },
                { "img": "http://www.logotaglines.com/wp-content/uploads/2016/11/JPMorgan-Chase-Co-Logo-487x365.jpg", "id": "15", "shortname": "jpm", "name": "เจพีมอร์แกนเชส " },
                { "img": "https://www.jobtopgun.com/content/filejobtopgun/logo_com_job/j3651.gif?_=13", "id": "16", "shortname": "ttb", "name": "ทหารไทยธนชาต" },
                { "img": "https://i.pinimg.com/originals/f0/52/4a/f0524a1937ff5b1e03c6c92ad014d821.png", "id": "17", "shortname": "tcrb", "name": "ไทยเครดิต" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRPIvcD_NGgZzOu6QDrP_yFwaa1-GOuNtfwLLTLL9D3b40CveggydAII0ZudwhZqxwbdSc&usqp=CAU", "id": "18", "shortname": "citi", "name": "ซิตี้แบ้งค์" },
                { "img": "https://www.1213.or.th/App/MCPD/Resources/Images/fi/449176.png", "id": "19", "shortname": "smbc", "name": "ซูมิโตโมมิตซุย แบงกิ้ง" },
                { "img": "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRveApa65w_dnKgmRo2HrkL0lwLAxzQC5b9vYsNf3K8zmb8Pjq6rebYMOtCdqL8FKqP--U&usqp=CAU", "id": "20", "shortname": "cimb", "name": "ซีไอเอ็มบีไทย" },
                { "img": "https://1.bp.blogspot.com/-22UW_ctLnWo/XBzuZkP0RXI/AAAAAAAAAd0/rzpg3S5XQtswJoJ3cTWDYdHnqpQlOzYbgCK4BGAYYCw/s1600/Bank%2BMEGA%2B%255Bsiklogo.blogspot.com%255D.png", "id": "21", "shortname": "mega", "name": "เมกะสากลพาณิชย์" },
            ],
            apiBase: import.meta.env.VITE_AGENT_BASE_URL,
            openData: '',
            dataItem: '',
            edit: false
        }
    },
    mounted() {
        this.fetchBank();
    },
    methods: {
        dataSet(item) {
            console.log(item);
            this.openData = true;
            this.dataItem = item;
        },
        closeModal(item) {
            this.openData = false;
            this.edit = false;
        },
        fetchBank: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/bank",
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": localStorage.getItem("Admin-mdc").token
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.myBankData = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }

        },
        addBank() {
            this.textStatus = "เพิ่มธนาคาร";
            this.bankNumber = '';
            this.bankName = '';
            this.bankSurname = '';
            this.selectBank = '';
            this.editId = '';
            $("#addModalBank").addClass('show d-flex align-items-center');
        },
        updateStatus: async function (row) {

            try {
                let config = {
                    method: "put",
                    url: this.apiBase + "/bank-status/" + row.id,
                    headers: {
                        "Content-Type": "application/json",
                        "Authorization": localStorage.getItem("Admin-mdc").token
                    },
                    data: {
                        isActive: row.bank_status
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

<style></style>