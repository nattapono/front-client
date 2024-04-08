<template>
  <div class="slide-show p-0 d-flex align-items-center justify-content-center" v-if="visibleCourses.length == 0 || !dataCourse">
    
  </div>
  <div class="slide-show p-0 d-flex align-items-center justify-content-center" v-else>
      <div class="controls me-2 mobile" v-if="visibleCourses.length > 0">
          <div class="arrow" @click="slideLeft">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pb-1" viewBox="0 0 16 16" style="transform: rotate(180deg);margin-top: -4px;margin-left: -4px;">
              <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
      <div class="controls me-2 desktop" v-if="visibleCourses.length > 3">
          <div class="arrow" @click="slideLeft">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pb-1" viewBox="0 0 16 16" style="transform: rotate(180deg);margin-top: -4px;margin-left: -4px;">
              <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
      <div class="slide-container desktop p-0 my-4">
          <div class="slide p-0 mx-1 box-shadow border-0 rounded" style="overflow:hidden;" 
            v-for="course in visibleCourses" :key="course.id">

              <img :src="course.imagUrl" alt="Course Image" class="course-image me-0 " height="300">
              <!-- <div class="course-details px-4">
                <div class="instructor bg-white">
                    <h6 class="course-name text-center">{{ course.course_name }}</h6>
                    <p class="instructor-description" v-html="course.description"></p>
                </div>
              </div>                 -->

          </div>
      </div>
     
      <div class="slide-container mobile">
          <div class="slide mx-0 p-0" v-if="visibleCourses[currentIndex]">

              <img :src="visibleCourses[currentIndex].imagUrl" alt="Course Image" class="course-image me-0 " style="height:375px;">
              <!-- <div class="course-details">
                  <div class="instructor bg-white">
                      <h4 class="course-name" v-if="visibleCourses" v-html="visibleCourses[currentIndex].course_name"></h4>
                      <p class="instructor-description" v-if="visibleCourses">{{ visibleCourses[currentIndex].description }}</p>
                  </div>
              </div> -->

          </div>
      </div>
      <div class="controls ms-2 mobile" v-if="visibleCourses.length > 0">
          <div class="arrow" @click="slideRight" ref="arrow-d">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pt-1" viewBox="0 0 16 16" style="margin-top: -4px;margin-left: 3px;">
                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
      <div class="controls ms-4 ps-3 desktop" v-if="dataCourse.length > 4">
          <div class="arrow" @click="slideRight"  ref="arrow-m">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pt-1" viewBox="0 0 16 16"  style="margin-top: -4px;margin-left: 3px;">
                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
</div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
        dataCourse:'',
        visibleCourses: [], 
        currentIndex: 0,
        itemsPerPage: 4,
        base_api:import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  computed: {
    containerStyle() {
      const numVisible = Math.min(this.itemsPerPage, this.visibleCourses.length);
      return `width: ${numVisible * 25}%;`; // กำหนดความกว้างของ slide container
    },
  },
  mounted(){
    this.getCourse();
    setInterval(() => {
      this.$refs['arrow-d'].click();
    }, 3600);
  },
  methods: {
    
    updateVisibleCourses() {
      const start = this.currentIndex;
      const end = (start + this.itemsPerPage) % this.dataCourse.length;
      if(this.dataCourse.length<4){
        this.visibleCourses = this.dataCourse;
      }else if (start <= end) {
        this.visibleCourses = this.dataCourse.slice(start, end);
      } else {
        this.visibleCourses = [...this.dataCourse.slice(start), ...this.dataCourse.slice(0, end)];
      }
    },
    slideLeft() {
      this.currentIndex = (this.currentIndex - 1 + this.visibleCourses.length) % this.visibleCourses.length;
      console.log(this.currentIndex);
    },
    slideRight() {
      this.$refs['arrow-d'].classList.add('fade-out');

    // เพิ่ม setTimeout เพื่อลบคลาส fade-out หลังจากภาพเสียงหายไป
    setTimeout(() => {
      this.$refs['arrow-d'].classList.remove('fade-out');
    }, 500);
      this.currentIndex = (this.currentIndex + 1) % this.visibleCourses.length;

    },
    async getCourse() {
        let config = {
            method: 'get',
            url:this.base_api+'/showcase',
            headers: {
            'Content-Type': 'application/json',
            },
            data: '',
        };

        try {
            const response = await axios.request(config);
            if (response) {
            this.dataCourse = response.data;
            }
        } catch (error) {
            console.log(error);
        }
    },
  },
  watch: {
    dataCourse: {
      immediate: true,
      handler() {
        this.updateVisibleCourses();
      },
    },
    currentIndex() {
      this.updateVisibleCourses();
    },
  },
};
</script>

<style scoped>
.slide-show {
  position: relative;
  margin-bottom: 20px;
}

.slide-container {
  display: flex;
  /* overflow: hidden; */
}

.slide {
  flex-shrink: 0;
  padding: 10px;
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  margin-right: 20px;
}

.course-image {
  width: 100%;
  max-height: 200px;
  object-fit: cover;
  border-radius: 5px;
}

.course-details {
  padding: 10px;
}

.course-name {
  font-weight: bold;
  margin-bottom: 10px;
  text-align: left;
}

.instructor {
  margin-top: 10px;
}

.instructor-image {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 50%;
  margin-bottom: 5px;
}

.instructor-name {
  font-weight: bold;
}

.instructor-description {
  font-size: 12px;
  color: #666;
}

.controls {
  display: flex;
  justify-content: space-between;
  margin-top: 10px;
}

.arrow {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  color: #fff;
  background-color: #7C9070;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.desktop{
    overflow: hidden;
  }
.arrow svg {
  fill: currentColor;
}
@media (min-width: 768px) {
    /* desktop */
  .slide {
    /* max-width: 25%; */
    min-width: 25%;
    margin-right: 20px;
  }

  .desktop{
    display: flex;
  }
  .mobile{
    display: none;
  }
}

@media (max-width: 767px) {
    /* mobile */
  .slide {
    max-width: 100%;
    margin-bottom: 20px;
  }
  .desktop{
    display: none;
  }
  .mobile{
    display: block;
  }
}
.transition-opacity {
  transition-property: opacity;
  transition-duration: 0.5s;
  transition-timing-function: ease;
}

/* ใช้ from เพื่อกำหนดสถานะเริ่มต้น */
.from-0 {
  opacity: 0;
}

.from-100 {
  opacity: 1;
}

/* ใช้ to เพื่อกำหนดสถานะที่ต้องการให้องค์ประกอบเข้าสู่หลังจาก transition */
.to-0 {
  opacity: 0;
}

.to-100 {
  opacity: 1;
}
</style>