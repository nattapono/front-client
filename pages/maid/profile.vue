<template>
    <div class="row d-flex align-items-top justify-content-center  vh-100">
        <div class="col-12 col-md-10 my-4">
            <div class="card ">
                <div class="row d-flex align-items-center justify-content-start">
                    <div class="col-4 col-md-2 p-2 text-center">
                        <div class="w-100 border rounded" v-if="maidProfile.img">
                            <img :src="maidProfile.img" width="100" alt="maid">
                        </div>
                        <div class="w-100 text-center  border rounded py-2" v-else>
                            <img src="@/public/assets/images/maid.png" width="100" alt="maid">
                        </div>
                        <input type="file" ref="upImg" class="d-none" @change="handleFileUpload">
                        <button class="btn btn-outline-danger btn-sm my-2 w-100" @click="uploadImage">อัพรูปโปรไฟล์</button>
                        <span class="text-success" v-if="uploadStatus">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
</svg>
                            อัพโหลดสำเร็จ
                        </span>
                    </div>
                    <div class="col-8 col-md-10">
                        ชื่อ : {{ maidProfile.fname }} {{ maidProfile.lname }}
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
// import { GoogleMap, Marker, InfoWindow } from "vue3-google-map";
export default {
    data() {
        return {
            profile: '',
            maidProfile: '',
            imageData: '',
            uploadStatus:false,
            apiBase: import.meta.env.VITE_AGENT_BASE_URL,
        }
    },
    mounted() {
        this.profile = JSON.parse(localStorage.getItem("Maid"));
        if (this.profile) {
            this.getProfile();
        } else {
            this.$route.push('/maid-sign-in');
        }

    },
    methods: {
        uploadImage() {
            this.$refs.upImg.click();
        },
        handleFileUpload(event) {
            const file = event.target.files[0];
            this.imageData = URL.createObjectURL(file);

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
            this.maidProfile.img = base64Image; 
                if(base64Image){
                        this.upImgProfile();
                    }
            };
        };
            
            reader.readAsDataURL(file);

        },
        upImgProfile: async function () {
            try {
                let config = {
                    method: "put",
                    url: this.apiBase + "/maid-img/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                    data:{img:this.maidProfile.img}
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.uploadStatus=true;
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
                    url: this.apiBase + "/maid-profile/" + this.profile.maid_id,
                    headers: {
                        "Content-Type": "application/json",
                    },
                };

                await axios
                    .request(config)
                    .then((response) => {
                        this.maidProfile = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            } catch (error) {
                console.error(error);
            }
        }
    },
}
</script>

<style></style>