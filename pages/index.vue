<template>
    <div>
        <Branner />
        <Package />
        <slideCourse />
        <Madam />
    </div>
</template>
<script>
    import Branner from "../components/branner.vue";
    import Package from "../components/package.vue";
    import Madam from "../components/madam.vue";
    import slideCourse from "../components/slideCourse.vue";
    import axios from 'axios';
    import swal from 'sweetalert';
    useHead({
        title:"[แม่บ้านออนไลน์]",
        meta:[
            {
                name:"description",
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
            this.getGameList();
        },
        methods:{
            getGameList: async function () {}
                
        }
        
    };

</script>

<style>
.white-space {
    white-space: nowrap;
}
</style>
