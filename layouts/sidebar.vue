<template>
  <nav class="navbar-vertical fixed-start navbar navbar-expand-md bg-danger text-white"
    v-if="$route.name != 'maid-register' && $route.name != 'sign-in'">
    <div class="container-fluid">
      <button type="button" aria-label="Toggle navigation" class="navbar-toggler collapsed">
        <span class="navbar-toggler-icon"></span></button>
      <a class="navbar-brand text-white mt-4" href="/">
        <img class="navbar-brand-img me-2" src="/assets/images/logomdc.png" alt="...">MadamClean
      </a>

      <div class="d-md-none dropdown">
        <div class="avatar avatar-sm avatar-online dropdown-toggle" id="react-aria-1" aria-expanded="false"
          role="button">

        </div>
      </div>
      <div class="navbar-collapse collapse">
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group-merge input-group-reverse input-group-rounded input-group"><input placeholder="Search"
              aria-label="Search" type="search" class="form-control"><span class="input-group-text"><svg width="15"
                height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-search ">
                <g>
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </g>
              </svg></span></div>
        </form>
        <div>
          <div class="navbar-nav">
            <div class="nav-item">
              <a role="button" class="nav-link text-white" :class="{ 'active': $route.name === '/' }" href="/"><svg
                  width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" class="feather feather-home ">
                  <g>
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                  </g>
                </svg>ภาพวม
              </a>

            </div>
            <div class="nav-item">
              <a role="button" :class="{ 'active': $route.name === '/package' }" class="nav-link text-white"
                tabindex="0" href="package"><svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-file ">
                  <g>
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                  </g>
                </svg>แพ็คเกจ</a>
            </div>
            <div class="nav-item">
              <a role="button" :class="{ 'active': $route.name === '/promotion' }" class="nav-link text-white"
                tabindex="0" href="promotion"><svg width="17" height="17" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-file ">
                  <g>
                    <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                    <polyline points="13 2 13 9 20 9"></polyline>
                  </g>
                </svg>โปรโมชั่น</a>
            </div>
            <div class="nav-item">
              <a :class="{ 'active': $route.name === 'maid' }" class="nav-link text-white" href="/maid">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
                  class="bi bi-stars text-white me-3" viewBox="0 0 16 16">
                  <path
                    d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z" />
                </svg>แม่บ้าน</a>
            </div>
            <div class="nav-item">
              <a role="button" class="nav-link text-white" tabindex="0" href="/booking">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check me-3" viewBox="0 0 16 16">
  <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
</svg>ข้อมลการจอง</a>
            </div>
            <div class="nav-item">
              <a role="button" class="nav-link text-white" tabindex="0" href="/customer"><svg width="17" height="17"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="feather feather-user ">
                  <g>
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                  </g>
                </svg>ลูกค้า</a>
            </div>
            <div class="nav-item">
              <a role="button" class="nav-link text-white" tabindex="0" href="/setting">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
                  class="bi bi-wrench-adjustable-circle  me-3" viewBox="0 0 16 16">
                  <path d="M12.496 8a4.5 4.5 0 0 1-1.703 3.526L9.497 8.5l2.959-1.11q.04.3.04.61" />
                  <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-1 0a7 7 0 1 0-13.202 3.249l1.988-1.657a4.5 4.5 0 0 1 7.537-4.623L7.497 6.5l1 2.5 1.333 3.11c-.56.251-1.18.39-1.833.39a4.5 4.5 0 0 1-1.592-.29L4.747 14.2A7 7 0 0 0 15 8m-8.295.139a.25.25 0 0 0-.288-.376l-1.5.5.159.474.808-.27-.595.894a.25.25 0 0 0 .287.376l.808-.27-.595.894a.25.25 0 0 0 .287.376l1.5-.5-.159-.474-.808.27.596-.894a.25.25 0 0 0-.288-.376l-.808.27z" />
                </svg> ตั้งค่า</a>
            </div>
          </div>
        </div>
        <div>
          <hr class="navbar-divider">
          <h6 class="navbar-heading">Documentation</h6>
          <div class="navbar-nav d-none">
            <div class="nav-item"><a role="button" class="nav-link" tabindex="0" href="#"><svg width="17" height="17"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="feather feather-clipboard ">
                  <g>
                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                  </g>
                </svg>Basics<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-chevron-down ms-auto nav-chevron false">
                  <g>
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </g>
                </svg></a>
              <div class="collapse">
                <div class="nav nav-sm flex-column">
                  <div class="nav-item"><a data-rr-ui-event-key="/getting-started" class="nav-link"
                      href="/getting-started">Getting Started</a></div>
                  <div class="nav-item"><a data-rr-ui-event-key="/design-file" class="nav-link"
                      href="/design-file">Design
                      File</a></div>
                </div>
              </div>
            </div>
            <div class="nav-item"><a role="button" class="nav-link" tabindex="0" href="#"><svg width="17" height="17"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" class="feather feather-book-open ">
                  <g>
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                  </g>
                </svg>Components<svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-chevron-down ms-auto nav-chevron false">
                  <g>
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </g>
                </svg></a>

            </div>
            <div class="nav-item"><a data-rr-ui-event-key="/changelog" class="nav-link" href="/changelog"><svg
                  width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round" class="feather feather-git-branch ">
                  <g>
                    <line x1="6" y1="3" x2="6" y2="15"></line>
                    <circle cx="18" cy="6" r="3"></circle>
                    <circle cx="6" cy="18" r="3"></circle>
                    <path d="M18 9a9 9 0 0 1-9 9"></path>
                  </g>
                </svg>Changelog</a></div>
          </div>
        </div>
        <div class="mt-auto mb-md-4"></div>
        <div class="navbar-user d-none d-md-flex"><a class="navbar-user-link" role="button">
            <div class="icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell ">
                <g>
                  <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                  <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </g>
              </svg></div>
          </a>
          <div class="dropup">
            <div class="avatar avatar-sm avatar-online dropdown-toggle" id="react-aria-2" aria-expanded="false"
              role="button">
            </div>
          </div><a class="navbar-user-link" role="button">
            <div class="icon"><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search ">
                <g>
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </g>
              </svg></div>
          </a>
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      authAdmin: "",
      brandName: "OMG5",
      currentMenu: 'slot',

    };
  },
  mounted() {

  },

  methods: {
    swichMenu(name) {
      console.log(name);
      this.currentMenu = name;
      window.location = `../games/${name}`;
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

.active.card.menu {
  border: 2px solid #a08a0f;
  border-radius: 6px;
  display: flex;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  color: red;
  font-size: 20px;
  padding: 18px;
}

.card.menu {
  width: 100%;
  color: gold;
}

span.title {
  font-weight: bold;
  text-transform: uppercase;
}

.d-flex {
  display: flex;
}
</style>