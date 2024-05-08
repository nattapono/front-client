<template>
    <div class="row d-flex justify-content-center">
        <div class="col-12 my-2 py-2 bg-warning d-flex align-items-center justify-content-center"
            v-if="loading && maidProfile.status == 2" style="position: fixed;top: 52px;z-index: 2;">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-exclamation-circle text-danger me-2" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path
                    d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
            </svg>
            ลงเวลาเพื่อเปิดรับคิวงาน
            <button class="btn btn-sm  bg-white ms-2" @click="checkIn()">

                ลงเวลา</button>
        </div>
        <div class="col-12 col-md-10" :class="{ 'mt-5': maidProfile.status == 2 }">
            <div class="cardBox mt-2">
                <div class="card bg-warning" v-if="newQCount > 0">
                    <div>
                        <div class="numbers text-white">{{ newQCount }}</div>
                        <div class="cardName text-white">คิวงานใหม่</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers">{{ hasQCount }}<span class="cardName"> งาน</span></div>
                        <div class="cardName">คิวงาน</div>
                    </div>
                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card" v-if="newQCount == 0">
                    <div>
                        <div class="numbers text-success">{{ sumQCount }} <span class="cardName"> งาน</span></div>
                        <div class="cardName text-success">เสร็จแล้ว</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers ">{{ hourSum }} <span class="cardName"> ชม.</span></div>
                        <div class="cardName ">ชั่วโมงการทำงาน</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card ">
                    <div>
                        <div class="numbers">{{ parseFloat(amountSum).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g,
                "$1,") }} <span class="cardName text-mall">฿</span></div>
                        <div class="cardName">รายได้</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
            </div>
            <div class="px-0 mx-4">
                <div class="bg-warning rounded w-50 px-4">
                    <!-- {{ dataSetting.vat }} -->
                </div>
            </div>
            <div class="details">
                <div class="recentOrders px-2 px-md-4">
                    <div class="cardHeader">
                        <h2>ตารางงานทั้งหมด</h2>
                        <button class="btn border d-none" @click="openStatusFilter()">
                            {{ textStatus }}
                        </button>
                        <div v-if="openStatus" class="border rounded bg-white py-2 px-0"
                            style="position:absolute;right:0;margin-top:45px; width:200px">
                            <div class="hover" @click="filterStatus(0, 'ทั้งหมด')">ทั้งหมด</div>
                            <div class="hover" @click="filterStatus(3, 'รอยืนยัน')">รอยืนยัน</div>
                            <div class="hover" @click="filterStatus(4, 'ปฏิเสธ')">ปฏิเสธ</div>
                            <div class="hover" @click="filterStatus(5, 'สำเร็จ')">สำเร็จ</div>
                            <div class="hover" @click="filterStatus(5, 'กำลังทำ')">กำลังทำ</div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td class="px-0">ชื่อลูกค้า</td>
                                <td style="text-align:center; max-width: 222px;">บริการ</td>
                                <td>แผนที่</td>
                                <td class="d-none d-md-block d-lg-block">สถานะ</td>
                            </tr>
                        </thead>
                        <tbody v-if="!dataWork.data || dataWork.data == null || dataWork.data.length < 1">
                            <tr>
                                <td colspan="4" class="text-center p-3 border-top"> - ไม่มีรายการ -</td>
                            </tr>
                        </tbody>
                        <tbody v-for="(item, i) in dataWork.data" :key="i"> <!-- รอรับงาน -->
                            <tr v-if="item.isActive == 3" class="border-bottom bg-gray-300">
                                <td class="px-0 px-md-2">
                                    <div class="pin-map">
                                        {{ item.mfname }} {{ item.mlname }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-small" style="text-align: left;">{{ item.hasClean }}
                                        <b class="text-primary text-xl"> เริ่มงาน {{ formatDateThai(item.dateSelect) }}
                                            {{ item.startTime }}น.</b><br />
                                        <span v-if="item.hasTool == '1'"><u>สถานที่ไม่มีอุปกรณ์ทำความสะอาด</u></span>
                                        <span v-if="item.has_pet"> {{ item.has_pet }}</span>
                                    </div>
                                    <div
                                        class="d-md-none d-lg-none d-flex align-content-center justify-content-between w-100 border-top mt-2 pt-2">
                                        <div class="d-flex align-content-center justify-content-start">
                                            <div v-if="item.imgWorkStart && item.isActive != 3" class="avatar">
                                                <img width="60" :src="item.imgWorkStart" class="avatar-sm rounded"
                                                    alt="">
                                            </div>
                                            <div v-else-if="item.isActive != 3">
                                                <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                            </div>
                                            <div v-if="item.imgWorkEnd && item.isActive != 3" class="avatar">
                                                <img width="60" :src="item.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                    alt="">
                                            </div>
                                            <div v-else-if="item.isActive != 3">
                                                <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                            </div>
                                        </div>

                                        <div class="mt-2 mt-md-0 text-nowrap ms-4">
                                            <span class="status delivered px-2" v-if="item.isActive == 1">เสร็จแล้ว {{0.00}}</span>
                                            <span class="status pending px-2" v-if="item.isActive == 3"
                                                @click="cfWork(item)">งานใหม่</span>
                                            <span class="status inProgress px-2 text-nowrap"
                                                v-if="item.isActive == 5 && !item.imgWorkStart"
                                                @click="startWork(item)">รอดำเนินการ</span>
                                            <span class="status pending px-2 text-nowrap"
                                                v-else-if="item.isActive == 5 && item.imgWorkStart && !item.imgWorkEnd"
                                                @click="startWork(item)">
                                                <img src="@/public/assets/images/work-loading.webp" width="25" alt="">
                                                กำลังทำ..
                                            </span>
                                            <span class="status delivered px-2 pt-2"
                                                v-if="item.imgWorkEnd && item.imgWorkStart">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                                </svg>
                                                สำเร็จ
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-top pin-map">
                                        <button class="btn btn-sm btn-outline-danger border"
                                            @click="openLLocation(item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                                <td class="d-none d-md-flex d-lg-flex align-content-center justify-content-between">
                                    <div class="d-flex align-content-center justify-content-start">
                                        <div v-if="item.imgWorkStart && item.isActive != 3" class="avatar">
                                            <img width="40" :src="item.imgWorkStart" class="avatar-sm rounded" alt="">
                                        </div>
                                        <div v-else-if="item.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                        </div>
                                        <div v-if="item.imgWorkEnd && item.isActive != 3" class="avatar">
                                            <img width="40" :src="item.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                alt="">
                                        </div>
                                        <div v-else-if="item.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 mt-md-0 text-nowrap d-flex align-content-center justify-content-end">
                                        <span class="status delivered px-2" v-if="item.isActive == 1">เสร็จแล้ว {{ 0.00
                                            }}</span>
                                        <span class="status pending px-2" v-if="item.isActive == 3"
                                            @click="cfWork(item)">งานใหม่</span>
                                        <span class="status inProgress px-2 text-nowrap"
                                            v-if="item.isActive == 5 && !item.imgWorkStart"
                                            @click="startWork(item)">รอดำเนินการ</span>
                                        <span class="status pending px-2 text-nowrap"
                                            v-else-if="item.isActive == 5 && item.imgWorkStart && !item.imgWorkEnd"
                                            @click="startWork(item)">
                                            <img src="@/public/assets/images/work-loading.webp" width="25" alt="">
                                            กำลังทำ..
                                        </span>

                                        <span class="status delivered px-2 pt-2"
                                            v-if="item.imgWorkEnd && item.imgWorkStart && item.asActive==4" @click="cfWork(item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                            </svg>
                                            สำเร็จ
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-for="(items, i) in dataWork.data" :key="i"> <!-- รับแล้ว กำลังทำ -->
                            <tr v-if="items.isActive === 5 && items.imgWorkStart && !items.imgWorkEnd"
                                class="border-bottom">
                                <td class="px-0">
                                    <div class="pin-map">
                                        {{ items.mfname }} {{ items.mlname }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-small" style="text-align: left;">{{ items.hasClean }}
                                        <b class="text-primary text-xl"> เริ่มงาน {{ formatDateThai(items.dateSelect) }}
                                            {{ items.startTime }}น.</b><br />
                                        <span v-if="items.hasTool == '1'"><u>สถานที่ไม่มีอุปกรณ์ทำความสะอาด</u></span>
                                        <span v-if="items.has_pet"> {{ items.has_pet }}</span>
                                    </div>
                                    <div
                                        class="d-md-none d-lg-none d-flex align-content-center justify-content-between w-100 border-top mt-2 pt-2">
                                        <div class="d-flex align-content-center justify-content-start">
                                            <div v-if="items.imgWorkStart && items.isActive != 3" class="avatar">
                                                <img width="60" :src="items.imgWorkStart" class="avatar-sm rounded"
                                                    alt="">
                                            </div>
                                            <div v-else-if="items.isActive != 3">
                                                <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                            </div>
                                            <div v-if="items.imgWorkEnd && items.isActive != 3" class="avatar">
                                                <img width="60" :src="items.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                    alt="">
                                            </div>
                                            <div v-else-if="items.isActive != 3">
                                                <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                            </div>
                                        </div>

                                        <div class="mt-2 mt-md-0 text-nowrap ms-4">
                                            <span class="status delivered px-2" v-if="items.isActive == 1">เสร็จแล้ว
                                                {{ 0.00 }}</span>
                                            <span class="status pending px-2" v-if="items.isActive == 3"
                                                @click="cfWork(items)">งานใหม่</span>
                                            <span class="status inProgress px-2 text-nowrap"
                                                v-if="items.isActive == 5 && !items.imgWorkStart"
                                                @click="startWork(items)">รอดำเนินการ</span>
                                            <span class="status pending px-2 text-nowrap"
                                                v-else-if="items.isActive == 5 && items.imgWorkStart && !items.imgWorkEnd"
                                                @click="startWork(items)">
                                                <img src="@/public/assets/images/work-loading.webp" width="25" alt="">
                                                กำลังทำ..
                                            </span>

                                            <span class="status delivered px-2 pt-2"
                                                v-if="items.imgWorkEnd && items.imgWorkStart">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                                </svg>
                                                สำเร็จ
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-top pin-map">
                                        <button class="btn btn-sm btn-outline-danger border"
                                            @click="openLLocation(items)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </button>
                                    </div>

                                </td>
                                <td class="d-none d-md-flex d-lg-flex align-content-center justify-content-between">
                                    <div class="d-flex align-content-center justify-content-start">
                                        <div v-if="items.imgWorkStart && items.isActive != 3" class="avatar">
                                            <img width="40" :src="items.imgWorkStart" class="avatar-sm rounded" alt="">
                                        </div>
                                        <div v-else-if="items.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                        </div>
                                        <div v-if="items.imgWorkEnd && items.isActive != 3" class="avatar">
                                            <img width="40" :src="items.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                alt="">
                                        </div>
                                        <div v-else-if="items.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 mt-md-0 text-nowrap d-flex align-content-center justify-content-end">
                                        <span class="status delivered px-2" v-if="items.isActive == 1">เสร็จแล้ว {{ 0.00
                                            }}</span>
                                        <span class="status pending px-2" v-if="items.isActive == 3"
                                            @click="cfWork(items)">งานใหม่</span>
                                        <span class="status inProgress px-2 text-nowrap"
                                            v-if="items.isActive == 5 && !items.imgWorkStart"
                                            @click="startWork(items)">รอดำเนินการ</span>
                                        <span class="status pending px-2 text-nowrap"
                                            v-else-if="items.isActive == 5 && items.imgWorkStart && !items.imgWorkEnd"
                                            @click="startWork(items)">
                                            <img src="@/public/assets/images/work-loading.webp" width="25" alt="">
                                            กำลังทำ..
                                        </span>

                                        <span class="status delivered px-2 pt-2"
                                            v-if="items.imgWorkEnd && items.imgWorkStart" @click="cfWork(items)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                            </svg>
                                            สำเร็จ
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-for="(item, i) in dataWork.data" :key="i"> <!-- กำลังทำ -->
                            <tr v-if="item.isActive == 5 && !item.imgWorkStart && !item.imgWorkEnd"
                                class="border-bottom">
                                <td class="px-0">
                                    <div class="pin-map">
                                        {{ item.mfname }} {{ item.mlname }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-small" style="text-align: left;">{{ item.hasClean }}
                                        <b class="text-primary text-xl"> เริ่มงาน {{ formatDateThai(item.dateSelect) }}
                                            {{ item.startTime }}น.</b><br />
                                        <span v-if="item.hasTool == '1'"><u>สถานที่ไม่มีอุปกรณ์ทำความสะอาด</u></span>
                                        <span v-if="item.has_pet"> {{ item.has_pet }}</span>
                                    </div>
                                    <div
                                        class="d-md-none d-lg-none d-flex align-content-center justify-content-between w-100 border-top mt-2 pt-2">
                                        <div class="d-flex align-content-center justify-content-start">
                                            <div v-if="item.imgWorkStart && item.isActive != 3" class="avatar">
                                                <img width="60" :src="item.imgWorkStart" class="avatar-sm rounded"
                                                    alt="">
                                            </div>
                                            <div v-else-if="item.isActive != 3">
                                                <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                            </div>
                                            <div v-if="item.imgWorkEnd && item.isActive != 3" class="avatar">
                                                <img width="60" :src="item.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                    alt="">
                                            </div>
                                            <div v-else-if="item.isActive != 3">
                                                <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                            </div>
                                        </div>

                                        <div class="mt-2 mt-md-0 text-nowrap ms-4">
                                            <span class="status delivered px-2" v-if="item.isActive == 1">เสร็จแล้ว {{0.00}}</span>
                                            <span class="status pending px-2" v-if="item.isActive == 3"
                                                @click="cfWork(item)">งานใหม่</span>
                                            <span class="status inProgress px-2 text-nowrap"
                                                v-if="item.isActive == 5 && !item.imgWorkStart"
                                                @click="startWork(item)">รอดำเนินการ</span>
                                            <span class="status pending px-2 text-nowrap"
                                                v-else-if="item.isActive == 5 && item.imgWorkStart && !item.imgWorkEnd"
                                                @click="startWork(item)">
                                                <img src="@/public/assets/images/work-loading.webp" width="25" alt="">
                                                กำลังทำ..
                                            </span>

                                            <span class="status delivered px-2 pt-2"
                                                v-if="item.isActive == 4 && item.imgWorkEnd && item.imgWorkStart">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                                </svg>
                                                สำเร็จ
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-top pin-map">
                                        <button class="btn btn-sm btn-outline-danger border"
                                            @click="openLLocation(item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </button>
                                    </div>

                                </td>
                                <td class="d-none d-md-flex d-lg-flex align-content-center justify-content-between">
                                    <div class="d-flex align-content-center justify-content-start">
                                        <div v-if="item.imgWorkStart && item.isActive != 3" class="avatar">
                                            <img width="40" :src="item.imgWorkStart" class="avatar-sm rounded" alt="">
                                        </div>
                                        <div v-else-if="item.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                        </div>
                                        <div v-if="item.imgWorkEnd && item.isActive != 3" class="avatar">
                                            <img width="40" :src="item.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                alt="">
                                        </div>
                                        <div v-else-if="item.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 mt-md-0 text-nowrap d-flex align-content-center justify-content-end">
                                        <span class="status delivered px-2" v-if="item.isActive == 1">เสร็จแล้ว {{ 0.00
                                            }}</span>
                                        <span class="status pending px-2" v-if="item.isActive == 3"
                                            @click="cfWork(item)">งานใหม่</span>
                                        <span class="status inProgress px-2 text-nowrap"
                                            v-if="item.isActive == 5 && !item.imgWorkStart"
                                            @click="startWork(item)">รอดำเนินการ</span>
                                        <span class="status pending px-2 text-nowrap"
                                            v-else-if="item.isActive == 5 && item.imgWorkStart && !item.imgWorkEnd"
                                            @click="startWork(item)">
                                            <img src="@/public/assets/images/work-loading.webp" width="25" alt="">
                                            กำลังทำ..
                                        </span>

                                        <span class="status delivered px-2 pt-2"
                                            v-if="item.imgWorkEnd && item.imgWorkStart" @click="cfWork(item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                            </svg>
                                            สำเร็จ
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-for="(item, i) in dataWork.data" :key="i"> <!-- ทำเส็จแล้ว -->
                            <tr v-if="item.isActive == 4" class="border-bottom">
                                <td class="px-0">
                                    <div class="pin-map">
                                        {{ item.mfname }} {{ item.mlname }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-small" style="text-align: left;">{{ item.hasClean }} <br />
                                        <b class="text-primary text-xl"> เริ่มงาน {{ formatDateThai(item.dateSelect) }}
                                            {{ item.startTime }}น.</b> <b>{{ item.unitHour }}</b>ชม.<br />
                                    </div>

                                    <div
                                        class="d-md-none d-lg-none d-flex align-content-center justify-content-between w-100 border-top mt-2 pt-2">
                                        <div class="d-flex align-content-center justify-content-start">
                                            <div v-if="item.imgWorkStart" class="avatar">
                                                <img width="60" :src="item.imgWorkStart" class="avatar-sm rounded"
                                                    alt="">
                                            </div>
                                            <div v-if="item.imgWorkEnd" class="avatar">
                                                <img width="60" :src="item.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                    alt="">
                                            </div>
                                        </div>

                                        <div class="mt-2 mt-md-0 text-nowrap ms-4">
                                            <span class="status delivered px-2 pt-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                    <path
                                                        d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                    <path
                                                        d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                                </svg>
                                                สำเร็จ
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-top pin-map">
                                        <button class="btn btn-sm btn-outline-danger border"
                                            @click="openLLocation(item)">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg>
                                        </button>
                                    </div>

                                </td>
                                <td class="d-none d-md-flex d-lg-flex align-content-center justify-content-between">
                                    <div class="d-flex align-content-center justify-content-start">
                                        <div v-if="item.imgWorkStart && item.isActive != 3" class="avatar">
                                            <img width="40" :src="item.imgWorkStart" class="avatar-sm rounded" alt="">
                                        </div>
                                        <div v-else-if="item.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2"></div>
                                        </div>
                                        <div v-if="item.imgWorkEnd && item.isActive != 3" class="avatar">
                                            <img width="40" :src="item.imgWorkEnd" class="avatar-sm rounded mx-1"
                                                alt="">
                                        </div>
                                        <div v-else-if="item.isActive != 3">
                                            <div class="avatar-sm rounded bg-gray-300 p-2 mx-1"></div>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-2 mt-md-0 text-nowrap d-flex align-content-center justify-content-end">
                                        <span class="status delivered px-2 pt-2"
                                            v-if="item.imgWorkEnd && item.imgWorkStart">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                <path
                                                    d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                            </svg>
                                            สำเร็จ
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>คะแนนจากลูกค้า</h2>
                    </div>
                    <table>
                        <tr v-for="(item, i) in dataWork.comment" :key="i">
                            <td class="px-0" width="60px">
                                <div
                                    class="imgBx bg-danger d-flex align-content-center justify-content-center text-white">
                                    <h3>{{ cutName(item.mfname) }}</h3>
                                </div>
                            </td>
                            <td class="px-0">
                                <span>{{ item.mfname }}{{ item.mlname }}</span>
                            </td>
                            <td class="px-0 d-flex align-content-center justify-content-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    v-for="index in item.stars" :key="index" class="bi bi-star-fill text-warning ms-1"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                </svg>
                            </td>
                        </tr>
                    </table>
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
                                <GoogleMap api-key="AIzaSyAms-_Xd7G-79itu4w1DX9FusgvJOJiArc"
                                    style="width: 100%; height: 500px" :center="mapCenter" :zoom="15"
                                    @click="onMapClick">

                                    <InfoWindow :options="{ position: markerPosition, visible: infoWindowOpened }">
                                        <template #default>
                                            <div>
                                                <p id="show-address">{{ showAddress }}</p>
                                            </div>
                                        </template>
                                    </InfoWindow>
                                    <Marker ref="markerRef" :options="{ position: markerPosition, draggable: false }" />
                                </GoogleMap>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary w-100"
                                @click="openLocation = false">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- modal -->
            <div v-if="openStartWork" class="modal fade show d-block bg-modal">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content rounded-2">
                        <div class="modal-header text-white bg-danger py-2 ">
                            <h6 class="modal-title" id="exampleModalLongTitle">{{ textTitle }} <span
                                    class="text-info border px-2 rounded">{{ workData.startTime }}</span></h6>
                            <button type="button" class="close text-white btn text-xl" @click="openStartWork = false"
                                style="font-size: 33px;line-height: 0;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <div class="w-50" v-if="workData.imgWorkStart === null">
                                    <b>ก่อน</b>
                                    <div class="w-100 border rounded" v-if="imgWorkStart">
                                        <img :src="imgWorkStart" class="w-100" alt="maid">
                                    </div>
                                    <div class="w-100 text-center bg-gray-300 text-muted py-5 border rounded py-2"
                                        v-else>
                                        รูปภาพ
                                    </div>
                                    <input type="file" ref="upImg" class="d-none" @change="handleFileUpload">
                                    <button class="btn btn-danger my-2 w-100" @click="uploadImage"
                                        v-if="workData.imgWorkStart === null">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            <path
                                                d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z" />
                                        </svg>
                                        อัพรูปก่อนเริ่มงาน
                                    </button>
                                    <span class="text-success text-center" v-if="uploadStatus == true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path
                                                d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                        </svg>
                                        เพิ่มรูปภาพสำเร็จ</span>
                                </div>
                                <div class="w-50" v-else>
                                    <div>
                                        <div class="w-100  rounded mb-2" v-if="workData.imgWorkStart">
                                            <b>ก่อน</b>
                                            <img :src="workData.imgWorkStart" class="w-100 bg-warning p-1 rounded"
                                                alt="maid">
                                        </div>
                                        <div class="w-100 rounded" v-if="imgWorkEnd">
                                            <b>หลัง</b>
                                            <img :src="imgWorkEnd" class="w-100 bg-warning p-1 rounded" alt="maid">
                                        </div>
                                        <div v-if="workData.imgWorkStart != '' && imgWorkEnd == ''">
                                            <b>หลัง</b>
                                            <div
                                                class="w-100 text-center bg-gray-300 text-muted py-5 border rounded py-2">
                                                รูปภาพ
                                            </div>
                                        </div>
                                    </div>
                                    <input type="file" ref="upImgEnd" class="d-none" @change="handleFileUploadEnd">
                                    <button class="btn btn-danger my-2 w-100" @click="uploadImageEnd">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                                            <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                            <path
                                                d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z" />
                                        </svg>
                                        อัพรูปหลังเสร็จงาน
                                    </button>
                                    <span class="text-success text-center" v-if="uploadStatus == true">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                                            <path
                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                            <path
                                                d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                                        </svg>
                                        เพิ่มรูปภาพสำเร็จ</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary w-100"
                                @click="openStartWork = false">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { format } from 'date-fns';
import { th } from 'date-fns/locale';
import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
useHead({
    title: "[แม่บ้านออนไลน์]",
    meta: [
        {
            name: "description",
            content: "บริการแม่บ้านออนไลน์ ง่ายๆ สำหรับคุณ"
        }
    ]
})
export default {
    components: { GoogleMap, Marker, InfoWindow },
    data() {
        return {
            newQCount: 0,
            hasQCount: 0,
            sumQCount: 0,
            hourSum: 0,
            amountSum: 0,
            dataMaid: [],
            dataWork: [],
            dataWorkForSearch: [],
            textStatus: 'ทั้งหมด',
            uploadStatus: false,
            openStatus: false,
            openLocation: false,
            openStartWork: false,
            apiBase: import.meta.env.VITE_AGENT_BASE_URL,
            infoWindowOpened: ref(true),
            showAddress: ref(null),
            markerRef: ref(null),
            markerPosition: ref(null),
            imgWorkStart: '',
            imgWorkEnd: '',
            bookId: '',
            workData: '',
            authMaid: '',
            maidProfile: '',
            dataSetting: '',
            timeStatus: 2,
            loading: false
        };
    },
    mounted() {
        this.workList();
        setInterval(() => {
            this.workList();
        }, 4800);

        this.getSetting();
        this.authMaid = JSON.parse(sessionStorage.getItem("X-Maid"));
        if (this.authMaid === undefined) {
            sessionStorage.removeItem('X-Maid');
        }
        if (!this.authMaid) {
            sessionStorage.removeItem('X-Maid');
            this.timeStatus = 2;
            this.loading = true;
        }else{
            this.getProfile();
        }
        let chkIn = JSON.parse(localStorage.getItem("checkIn"));
       
        if (!chkIn) {
            this.timeStatus = 2;
            this.loading = true;
        } else {
            // const dateObject = new Date(chkIn.time_in);
            // const hours = dateObject.getHours();
            this.timeStatus = 1;
            this.loading = true;
        }
    },
    methods: {

        openLLocation: async function (data) {
            this.infoWindowOpened = true;
            this.openLocation = true;
            this.showAddress = data.showAddress;
            this.markerPosition = { lat: parseFloat(data.lat), lng: parseFloat(data.lng) };
            console.log('-', this.markerPosition);
        },
        checkIn: async function () {

            try {
                let config = {
                    method: "post",
                    url: this.apiBase + "/check-in/",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data: {
                        maid_id: this.authMaid.maid_id
                    }
                };

                await axios
                    .request(config)
                    .then((response) => {
                        localStorage.setItem("checkIn", JSON.stringify(response.data));
                        this.timeStatus = 1;
                        this.getProfile();
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        openStatusFilter() {
            this.openStatus = true;
        },
        filterStatus(data, text) {
            this.textStatus = text;
            this.openStatus = false;
            if (data!==0) {
                this.dataWork = this.dataWorkForSearch.filter(maid => maid.isActive == data);
            } else {
                this.workList(); // กรณีที่ไม่มีการค้นหา
            }
        },
        cutName(name) {
            let nn = name.charAt(0);
            let cname = '';
            if (name) {
                if (nn == 'เ' || nn == 'โ' || nn == 'ไ' || nn == 'ใ') {
                    cname = name.charAt(1);
                } else {
                    cname = name.charAt(0);
                }
            }
            return cname;
        },
        startWork(data) {
            this.workData = data;
            this.openStartWork = true;
            this.textTitle = 'เริ่มงาน';
            this.bookId = data.bookId;
            this.uploadStatus = false;
        },
        cfWork: async function (data) {
            this.dataMaid = JSON.parse(sessionStorage.getItem("X-Maid"));
            
            Swal.fire({
                position: "top-center",
                icon: 'question',
                title: 'ยืนยันรับคิวงาน หรือไม่',
                showCancelButton: true,
                showConfirmButton: true,
            }).then(async (result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    try {
                        let config = {
                            method: "put",
                            url: this.apiBase + "/book-status/" + data.bookId,
                            data: { 
                                isActive: 6,
                                isNotYet:this.dataMaid.maid_id
                            },
                            headers: {
                                "Content-Type": "application/json",
                            },
                        };

                        await axios
                            .request(config)
                            .then((response) => {
                                Swal.fire({
                                    position: "top-center",
                                    icon: 'success',
                                    title: 'ปฏิเสธงานแล้ว',
                                    showConfirmButton: true,
                                }).then(async (result) => {
                                    this.workList();
                                });
                            })
                            .catch((error) => {
                                console.log(error);
                            });

                    } catch (error) {
                        console.error(error);
                    }
                } else {
                    // กระทำเมื่อผู้ใช้กดปุ่ม "ยืนยัน"
                    try {
                        let config = {
                            method: "put",
                            url: this.apiBase + "/book-status/" + data.bookId,
                            data: { isActive: 5,isNotYet:this.dataMaid.maid_id },
                            headers: {
                                "Content-Type": "application/json",
                            },
                        };

                        await axios
                            .request(config)
                            .then((response) => {
                                Swal.fire({
                                    position: "top-center",
                                    icon: 'success',
                                    title: 'รับคิวงานเรียบร้อย',
                                    showConfirmButton: true,
                                }).then(async (result) => {
                                    this.workList();
                                });
                            })
                            .catch((error) => {
                                console.log(error);
                            });

                    } catch (error) {
                        console.error(error);
                    }
                }
            });
        },
        workList: async function () {
            this.dataMaid = JSON.parse(sessionStorage.getItem("X-Maid"));
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/maid/" + this.dataMaid.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                };
                await axios
                    .request(config)
                    .then((response) => {
                        response;
                        this.dataWorkForSearch = Object.assign({}, response.data);
                        this.dataWork = Object.assign({}, response.data);
                        this.newQCount = response.data.newQCount;
                        this.hasQCount = response.data.hasQCount;
                        this.sumQCount = response.data.sumQCount;
                        this.hourSum = response.data.hourSum;
                        this.amountSum = response.data.amountSum;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        formatDateThai(date) {
            return format(new Date(date), 'd MMM yy', { locale: th });
        },
        getSetting: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/vat-for-maid",
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.dataSetting = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        getProfile: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/maid-profile/" + this.authMaid.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {

                        // localStorage.setItem("Maid", JSON.stringify(response.data.dataMaid));
                        this.maidProfile = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        upImgWorkStart: async function () {
            try {
                let config = {
                    method: "post",
                    url: this.apiBase + "/maid-start-working/",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data: {
                        imgWorkStart: this.imgWorkStart,
                        maid_id: this.authMaid.maid_id,
                        bookId: this.bookId
                    }
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.uploadStatus = true;
                        this.workList();
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
        uploadImage() {
            this.$refs.upImg.click();
        },
        uploadImageEnd() {
            this.$refs.upImgEnd.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            // this.imageData = URL.createObjectURL(file);

            const reader = new FileReader();
            let base64Image = ''; // เริ่มต้นด้วยค่าว่าง
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;

                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    const MAX_WIDTH = 300; // กำหนดความกว้างสูงสุด
                    const MAX_HEIGHT = MAX_WIDTH * (img.height / img.width);

                    canvas.width = MAX_WIDTH;
                    canvas.height = MAX_HEIGHT;

                    // ปรับขนาดรูปภาพ
                    ctx.drawImage(img, 0, 0, MAX_WIDTH, MAX_HEIGHT);

                    // สร้าง base64 URL จาก Canvas
                    const base64Image = canvas.toDataURL('image/jpeg');

                    // กำหนดค่าให้กับ imageData และ imageUrl
                    this.imgWorkStart = base64Image;
                    if (base64Image) {
                        this.upImgWorkStart();
                    }
                };
            };

            reader.readAsDataURL(file);
        },
        handleFileUploadEnd(event) {
            const file = event.target.files[0];
            // this.imageData = URL.createObjectURL(file);

            const reader = new FileReader();
            let base64Image = ''; // เริ่มต้นด้วยค่าว่าง
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;

                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    const MAX_WIDTH = 300; // กำหนดความกว้างสูงสุด
                    const MAX_HEIGHT = MAX_WIDTH * (img.height / img.width);

                    canvas.width = MAX_WIDTH;
                    canvas.height = MAX_HEIGHT;

                    // ปรับขนาดรูปภาพ
                    ctx.drawImage(img, 0, 0, MAX_WIDTH, MAX_HEIGHT);

                    // สร้าง base64 URL จาก Canvas
                    const base64Image = canvas.toDataURL('image/jpeg');

                    // กำหนดค่าให้กับ imageData และ imageUrl
                    this.imgWorkEnd = base64Image;
                    if (base64Image) {
                        this.upImgWorkEnd();
                    }
                };
            };
            reader.readAsDataURL(file);
        },
        upImgWorkEnd: async function () {
            try {
                let config = {
                    method: "put",
                    url: this.apiBase + "/maid-end-working/" + this.bookId,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data: {
                        imgWorkEnd: this.imgWorkEnd,
                        maid_id: this.authMaid.maid_id,
                    }
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.uploadStatus = true;
                        this.workList();
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        },
    }
};

</script>
<style>
.bg-gray-300 {
    background-color: #dee2e6;
}

.bg-gray-300:hover {
    background-color: #2a2185;
}

@media (max-width: 768px) {
    .pin-map {
        position: relative;
        margin-top: 0px;
    }
}

@media (max-width: 480px) {
    .pin-map {
        position: relative;
        margin-top: -50px;
    }
}

.hover {
    padding: 2px 16px;
}

.hover:hover {
    background-color: #dee2e6;
}
</style>