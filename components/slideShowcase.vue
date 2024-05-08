<template>
  <div class="d-flex align-items-center justify-content-center">
    <div class="slide-show p-0 d-flex align-items-center justify-content-center" v-if="dataShowcase.length == 0 "></div>
    <div class="slide-show p-0 d-flex align-items-center justify-content-center" v-else>
      <div class="controls me-2 mobile" v-if="visibleShowcase.length > 0">
          <div class="arrow" @click="slideLeft">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pb-1" viewBox="0 0 16 16" style="transform: rotate(180deg);margin-top: -4px;margin-left: -4px;">
              <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
      <div class="controls me-2 desktop" v-if="visibleShowcase.length > 3">
          <div class="arrow" @click="slideLeft">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pb-1" viewBox="0 0 16 16" style="transform: rotate(180deg);margin-top: -4px;margin-left: -4px;">
              <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>

      <div class="slide-container desktop p-0 my-4" ref="slide" v-if="dataShowcase.length > 4">
          <div class="slide p-0 mx-1 box-shadow border-0 rounded" style="overflow:hidden;height:310px;"   
            v-for="course in visibleShowcase" :key="course.id">
              <img :src="course.imagUrl" alt="Course Image" class="course-image me-0 " style="height:300px;">
          </div>
        </div>
        <div class="slide-container desktop p-0 my-4" ref="slide" v-else>
          <div class="slide p-0 mx-1 box-shadow border-0 rounded" style="overflow:hidden;"
            v-for="course in dataShowcase" :key="course.id">
              <img :src="course.imagUrl" alt="Course Image" class="course-image me-0 " style="height:300px;" >
          </div>
      </div>
     
      <div class="slide-container mobile">
          <div class="slide mx-0 p-0" v-if="visibleShowcase[currentIndex]">

              <img :src="visibleShowcase[currentIndex].imagUrl" alt="Course Image" class="course-image me-0 " style="height:375px;">
              <!-- <div class="course-details">
                  <div class="instructor bg-white">
                      <h4 class="course-name" v-if="visibleShowcase" v-html="visibleShowcase[currentIndex].course_name"></h4>
                      <p class="instructor-description" v-if="visibleShowcase">{{ visibleShowcase[currentIndex].description }}</p>
                  </div>
              </div> -->

          </div>
      </div>
      <div class="controls ms-2 mobile" v-if="visibleShowcase.length > 0">
          <div class="arrow" @click="slideRight" ref="arrow-d">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pt-1" viewBox="0 0 16 16" style="margin-top: -4px;margin-left: 3px;">
                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
      <div class="controls ms-4 ps-3 desktop" v-if="dataShowcase.length > 4">
          <div class="arrow" @click="slideRight"  ref="arrow-m">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-play-fill pt-1" viewBox="0 0 16 16"  style="margin-top: -4px;margin-left: 3px;">
                <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
              </svg>
          </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
        dataShowcase:'',
        visibleShowcase: [], 
        currentIndex: 0,
        itemsPerPage: 4,
        base_api:import.meta.env.VITE_AGENT_BASE_URL
    };
  },
  computed: {
    containerStyle() {
      const numVisible = Math.min(this.itemsPerPage, this.visibleShowcase.length);
      return `width: ${numVisible * 25}%;`; // กำหนดความกว้างของ slide container
    },
  },
  mounted(){
    this.getCourse();
    setInterval(() => {
      if(this.dataShowcase.length > 3){
        this.$refs['arrow-d'].click();
      }
    }, 3600);
  },
  methods: {
    
    updateVisibleShowcase() {
      const start = this.currentIndex;
      const end = (start + this.itemsPerPage) % this.dataShowcase.length;
      if(this.dataShowcase.length<4){
        this.visibleShowcase = this.dataShowcase;
      }else if (start <= end) {
        this.visibleShowcase = this.dataShowcase.slice(start, end);
      } else {
        this.visibleShowcase = [...this.dataShowcase.slice(start), ...this.dataShowcase.slice(0, end)];
      }
    },
    slideLeft() {
      this.currentIndex = (this.currentIndex - 1 + this.visibleShowcase.length) % this.visibleShowcase.length;
      console.log(this.currentIndex);
    },
    slideRight() {
      this.$refs['arrow-d'].classList.add('fade-out');
      this.$refs['slide'].classList.remove('slide');
      setTimeout(() => {
         this.$refs['slide'].classList.add('slide');
      }, 20);
     

    // เพิ่ม setTimeout เพื่อลบคลาส fade-out หลังจากภาพเสียงหายไป
    setTimeout(() => {
      this.$refs['arrow-d'].classList.remove('fade-out');
    }, 500);
      this.currentIndex = (this.currentIndex + 1) % this.visibleShowcase.length;

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
            this.dataShowcase = response.data;
            }
        } catch (error) {
            console.log(error);
        }
    },
  },
  watch: {
    dataShowcase: {
      immediate: true,
      handler() {
        this.updateVisibleShowcase();
      },
    },
    currentIndex() {
      this.updateVisibleShowcase();
    },
  },
};
</script>

<style scoped>
.w-80 {
    width: 80% !important;
}
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
.wrap {
    transition: 1s;
    left: 300px;
}
.slide {
    transition: 1s;
    margin-left: 0;
}

</style>