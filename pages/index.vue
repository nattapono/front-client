<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center row">
                            <div class="col">
                                <h2 class="text-uppercase text-muted mb-2">ทำเสร็จแล้ว</h2>
                                <span class="h2 mb-0 px-2 text-success bg-success-soft">{{ sumSuccess }}</span>
                            </div>
                            <div class="col-auto text-right">
                                <!-- <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-dollar-sign text-muted">
                                    <g>
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </g>
                                </svg> -->
                                {{ sumService }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center row">
                            <div class="col">
                                <h3 class="text-uppercase text-muted mb-2">จำนวนการจอง</h3><span class="h2 mb-0">{{
                                    sumBooking }}</span>
                            </div>
                            <div class="col-auto">
                                <!-- <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-briefcase text-muted">
                                <g>
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </g>
                            </svg> -->
                                {{ sumBooking }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center row">
                            <div class="col">
                                <h3 class="text-uppercase text-muted mb-2">ชำระเงินแล้ว</h3><span class="h2 mb-0">{{
                                    sumPayAmount }}</span>
                            </div>
                            <div class="col-auto">
                                <!-- <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-briefcase text-muted">
                                <g>
                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                </g>
                            </svg> -->
                                {{ sumPay }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="align-items-center row">
                            <div class="col">
                                <h3 class="text-uppercase text-muted mb-2">รอชำระเงิน</h3><span class="h2 mb-0">{{
                                    waitPayAmount }}</span>
                            </div>
                            <div class="col-auto">
                                <!-- <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-clock text-muted">
                                <g>
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </g>
                            </svg> -->
                                {{ waitPay }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="row">
            <div class="col-xl-4 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">แม่บ้าน</h4><a class="small" href="/project-overview">View all</a>
                    </div>
                    <div class="card-body">
                        <div class="list-group-flush my-n3 list-group">
                            <div class="list-group-item" v-for="(rows, i) in dataMaids" :key="i">
                                <div class="row align-items-center d-flex">
                                    <div class="col-auto">
                                        <a class="avatar avatar-4by3" href="/project-overview">
                                            <img class="avatar-img rounded" src="@/public/assets/images/maid.png"
                                                alt="...">

                                        </a>
                                    </div>
                                    <div class="ms-n2 col align-items-center d-flex">
                                        <h4 class="mb-1 white-space"><a href="/project-overview">{{ rows.fname }} {{ rows.lname }}</a></h4>
                                        <span class="small text-muted card-text"><time datetime="2018-05-24">{{
                                                formatDateThai(rows.create_at) }}</time></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <span class="dropdown-ellipses dropdown-toggle" id="react-aria-3"
                                                aria-expanded="false" role="button">
                                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-more-vertical ">
                                                    <g>
                                                        <circle cx="12" cy="12" r="1"></circle>
                                                        <circle cx="12" cy="5" r="1"></circle>
                                                        <circle cx="12" cy="19" r="1"></circle>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-header-title">รายการวันนี้</h4>
                        <div class="nav-tabs-sm nav card-header-tabs nav-tabs">
                            <div class="nav-item"><a role="button" class="nav-link active" tabindex="0" href="#">All</a>
                            </div>
                            <div class="nav-item"><a role="button" class="nav-link" tabindex="0" href="#">ชำระแล้ว</a>
                            </div>
                            <div class="nav-item"><a role="button" class="nav-link" tabindex="0" href="#">รอชำระ</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart"><canvas role="img" height="600" width="1366"
                                style="display: block; box-sizing: border-box; height: 300px; width: 683px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>

useHead({
    title: "[แม่บ้านออนไลน์]",
    meta: [
        {
            name: "description",
            content: "บริการแม่บ้านออนไลน์ ง่ายๆ สำหรับคุณ"
        }
    ]
})
import axios from 'axios';
import { format } from 'date-fns';
import { th } from 'date-fns/locale';
export default {
    data() {
        return {
            sumSuccess: 0.00,
            sumService: 0,
            sumBooking: 0,
            sumPayAmount: 0.00,
            sumPay: 0,
            waitPayAmount: 0.00,
            waitPay: 0,
            dataMaids: [],
            apiBase: import.meta.env.VITE_AGENT_BASE_URL
        };
    },
    mounted() {
        this.getMaid();
    },
    methods: {
        formatDateThai(date) {
            return format(new Date(date), 'MMM d, yyyy', { locale: th });
        },
        getMaid: async function () {
            try {
                let config = {
                    method: "get",
                    url: this.apiBase + "/maids",
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.dataMaids = response.data;
                        this.dataMaidsForSearch = response.data;
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
.white-space {
    white-space: nowrap;
}
</style>
