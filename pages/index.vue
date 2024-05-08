<template>
    <div>
        <Branner />
        <imageMenu />
        <slideShowcase />
        <Madam />
    </div>
</template>
<script>
    import Branner from "../components/branner.vue";
    import Package from "../components/package.vue";
    import Madam from "../components/madam.vue";
    import slideShowcase from "../components/slideShowcase.vue";
    import imageMenu from "../components/image-menu.vue";
    import axios from 'axios';
    import swal from 'sweetalert';
    useHead({
        title:"[แม่บ้านออนไลน์]",
        meta:[
            {
                name:"บริการแม่บ้านออนไลน์ ง่ายๆ สำหรับคุณ",
                content:"บริการแม่บ้านออนไลน์ ง่ายๆ สำหรับคุณ"
            }
        ]
    })
    export default {
        data() {
            return {
                dataGame: [],
                apiBase : import.meta.env.VITE_AGENT_BASE_URL
            };
        },
        mounted(){
          
        },
        methods:{
           
        }
    };

</script>

<style>
.white-space {
    white-space: nowrap;
}
</style>
