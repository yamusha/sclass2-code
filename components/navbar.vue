<template>
  <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-transaparent">
    <div class="container">
      <a class="navbar-brand" href="./">
        <img src="assets/images/text_logo.png" height="50px" alt="" />
      </a>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarContent"
        aria-controls="navbarContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="ms-auto navbar-nav float-end ul-navbar">
          <li class="px-3 nav-item active">
            <a class="nav-link" href="./">Enjoy's Blog </a>
          </li>
          <li class="px-3 nav-item" v-if="!auth.data">
            <a class="nav-link" href="register.html">สมัครสมาชิก</a>
          </li>
          <li class="px-3 nav-item" v-if="!auth.data">
            <a class="nav-link" href="login.html">เข้าสู่ระบบ</a>
          </li>
          <li class="px-3 ms-auto text-end nav-item dropdown">
            <a
              class="text-end nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <img
                class="profile-img"
                width="40px"
                height="40px"
                src="assets/images/uploads/avatar.png"
                alt=""
              />
              <strong class="text-capitalize">FirstName</strong>
            </a>
            <ul
              class="mb-3 rounded-lg dropdown-menu dropdown-menu-end text-capitalize"
            >
              <li>
                <a class="dropdown-item" href="profile.html">
                  <div class="d-flex align-items-center">
                    <img
                      class="profile-img"
                      width="60px"
                      height="60px"
                      src="assets/images/uploads/avatar.png"
                    />
                    <div class="p-3 lh-sm">
                      <span class="font-weight-bold">FirstName LastName</span>
                      <br />
                      <small>ดูโปรไฟล์ของคุณ </small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="#" @click="logout">
                  <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

    <div class="progressContainer">
      <div class="progressBar"></div>
    </div>
  </nav>
</template>

<script>
module.exports = {
  props: ['auth'],
  methods: {
    logout() {
      localStorage.clear()
      location.assign('./')
    }
  },
  mounted() {
    window.addEventListener("scroll", function () {
      let wintop = this.scrollY;
      let navbar = document.querySelector(".navbar");

      let winheight = this.innerHeight;
      let docheight = document.querySelector("body").offsetHeight;
      let totalScroll = (wintop / (docheight - winheight)) * 100;
      let bar = document.querySelector(".progressBar");
      bar.style.width = `${totalScroll}%`;

      if (wintop > 150) {
        // console.log('Change To White')
        navbar.classList.remove("navbar-dark", "bg-transaparent");
        navbar.classList.add("navbar-light", "bg-light");
      } else {
        // console.log('Change To Transpate')
        navbar.classList.remove("navbar-light", "bg-light");
        navbar.classList.add("navbar-dark", "bg-transaparent");
      }
    });
  },
};
</script>

<style>
</style>