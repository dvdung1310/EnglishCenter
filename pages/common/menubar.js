//menuBar khi chưa đăng nhập 
const menuBarHTML  = `<div class="PageMenuBar">
<a class="PageLogoWrap">
    <img class="PageLogoImg" src="../../assets/images/logo-web.png"/>
</a>
<div class="menubar-btnwrap">

  <a href="/pages/home/home.html" class="PageLogoBtn">Login LoDuHi</a>
</div>
</div>`
//isAuthentication === false
document.querySelector("#menu-bar").innerHTML = menuBarHTML
//menuBar khi đã đăng nhập 
const authMenuBarHTMl = ` <div class="PageMenuBar">
<a class="PageLogoWrap">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="dropdown">
    <button class="menubar-avt-wrap" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
      <li><a class="dropdown-item" href="#">Chi tiết lớp học</a></li>
      <li><a class="dropdown-item" href="#">Đăng xuất</a></li>
    </ul>
  </div>
  
</div>`
//isAuthentication === true
// document.querySelector("#menu-bar").innerHTML = authMenuBarHTMl
var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)