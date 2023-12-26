<template>
    <div class="navigation list">
      <ul>
        <li>
          <a href="#">
            <span class="icon">
              <ion-icon name="logo-apple"></ion-icon>
            </span>
            <span class="title">{{ brandName }}</span>
          </a>
        </li>
  
        <li v-for="(item, index) in listMenu" :key="index" class="cardBoxMenu">
          <div :class="{'active':item.name==currentMenu}" @click="swichMenu(item.name )" class="card menu text-left d-flex" >
            <span class="icon">
              <ion-icon name="home-outline"></ion-icon>
              <img :src="item.img" alt="item.name" height="50">
            </span>
            <div>
                <span class="title">{{ item.name }}</span>
                <p class="text-white">{{ item.subthai }}</p>
            </div>
          </div>
        </li>
  
        <li>
          <a href="#">
            <span class="icon">
              <ion-icon name="log-out-outline"></ion-icon>
            </span>
            <span class="title">Sign Out</span>
          </a>
        </li>
      </ul>
    </div>
  </template>
  <script>
  import axios from "axios";
  export default {
    data() {
      return {
        authAdmin: "",
        brandName: "OMG5",
        currentMenu:'slot',
        listMenu:[
            {name:'hotgame',subthai:'เกมฮอต', img:'data:image/png;base64,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'},
            {name:'slot',subthai:'สล๊อต', img:'https://dr277ea24g9fk.cloudfront.net/_bubblebee/icon_1/icon_g_slot.webp'},
            {name:'casino',subthai:'คาสิโน', img:'https://dr277ea24g9fk.cloudfront.net/_bubblebee/icon_1/icon_g_hilo.webp'},
            {name:'sport',subthai:'กีฬา', img:'https://dr277ea24g9fk.cloudfront.net/_bubblebee/icon_1/icon_g_sport.webp'},
            {name:'fishing',subthai:'ยิงปลา', img:'https://dr277ea24g9fk.cloudfront.net/_bubblebee/icon_1/icon_g_fish.webp'},
            {name:'pokdeng',subthai:'ป๊อกเด้ง "ไฮโล', img:'https://dr277ea24g9fk.cloudfront.net/_bubblebee/icon_1/icon_g_casino.webp'},
            {name:'graph',subthai:'กราฟ', img:'https://dr277ea24g9fk.cloudfront.net/_bubblebee/icon_1/icon_g_graph.webp'},
        ]
      };
    },
    mounted() {
        
    },
  
    methods: {
        swichMenu(name){
            console.log(name);
            this.currentMenu = name;
        }
    }
  
  };
  </script>
  
  <style scope>
    .navigation.list {
        background: linear-gradient(to bottom, #000000, #333333, #666666, #999999, #cccccc);
    }

    .sidebar {
        width: 250px;
        background-color: #333;
        color: #fff;
        padding: 20px;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        padding: 20px;
    }

    .card h2 {
        color: #333;
        margin-bottom: 10px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
    }

    a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    a:hover {
        color: #007BFF;
    }

    .content {
        flex: 1;
        padding: 20px;
        background-color: #f4f4f4;
    }

    .active.card.menu{
        border: 2px solid #a08a0f;
        border-radius: 6px; 
        display: flex;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
        color: red;
        font-size:20px;
        padding: 18px;
    }
    .card.menu{
        width: 100%;
        color: gold;
    }
    span.title{
        font-weight: bold;
        text-transform: uppercase;
    }
    .d-flex{
        display: flex;
    }
  </style>