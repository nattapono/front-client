import Vue from 'vue'
import VueRouter from 'vue-router'
import BookingComponent from '../pages/booking/index.vue'

Vue.use(VueRouter)

const routes = [{
    path: '/booking/:id',
    name: 'Booking',
    component: BookingComponent
}]

const router = new VueRouter({
    mode: 'booking',
    base: process.env.BASE_URL,
    routes
})

export default router