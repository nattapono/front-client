<template>
    <div class="">
        <AppHeader v-if="$route.name !== 'maid' || 
        $route.name !=='maid-sign-in' || 
        $route.name !=='maid-register' ||
        $route.name !=='maid-profile'" />
        <Sidebar v-if="$route.name === 'maid' || $route.name == 'maid-sign-in'|| $route.name =='maid-profile'" />
            <div class="pt-5">
                <slot />
            </div>
        <AppFooter />
    </div>
</template>
<script setup>
    import AppHeader from "./header";
    import AppFooter from "./footer";
    import Sidebar from "./sidebar";
</script>
<style>
@import "../public/assets/css/style.0.0.1.css";
@import "@/public/assets/css/bootstrap.0.0.1.min.css";


 @media (max-width: 768px) {
    .body-top{
        margin-top: 66px;
    }
}

@media (min-width: 769px) {
    .body-top{
        margin-top: 100px;
    }
}
</style>
