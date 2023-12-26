<template>
    
</template>
<script>
export default {
    data(){
        return{
            isSelect:false
        }
    },
    methods:{
        getToggle(){
            if(this.isSelect==false){
                this.isSelect = true;
            }else{
                this.isSelect = false;
            }
            
        }
    }
}
</script>
<style>
.text-small{
    font-size:12px;
}
.bg-footer{
    background: #F8F8F8 0% 0% no-repeat padding-box;
}
.text-policy{
    border-top:2px #ccc dashed ;border-bottom:2px #ccc dashed ;width: 92%;
}
.arrow.fa.fa-down{
    background-image: url(/images/chevron-down.svg);
    width: 16px;
    background-position: center;
    background-size: 100%;
    height: 23px;
    float: right;
}
.arrow.fa.fa-up{
    background-image: url(/images/chevron-up.svg);
    width: 16px;
    background-position: center;
    background-size: 100%;
    height: 23px;
    float: right;
}

</style>