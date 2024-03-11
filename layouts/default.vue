<template>
    <div class="">
        <Sidebar />
        <div class="main-content">
            <AppHeader />
            <slot />
        </div>
    </div>
</template>
<script setup>
import AppHeader from "./header";
import Sidebar from "./sidebar";
</script>
<style>
@import "../public/assets/css/style.css";


@media (max-width: 768px) {
    .body-top {
        margin-top: 66px;
    }
}

@media (min-width: 769px) {
    .body-top {
        margin-top: 100px;
    }
}
</style>
