<template>
    <div class="container">
        <AppSidebar />
        <AppHeader />
            <div class="container">
                <slot />
            </div>
        <AppFooter />
    </div>
</template>
<script setup>
    import AppHeader from "./header";
    import AppSidebar from "./sidebar";
    import AppFooter from "./footer";
</script>
<style>
 @import "../public/assets/css/style.css";

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
