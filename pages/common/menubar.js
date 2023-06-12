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
//document.querySelector("#menu-bar").innerHTML = menuBarHTML
//menuBar khi đã đăng nhập 
const authMenuBarHTMl = ` <div class="PageMenuBar">
<a class="PageLogoWrap">
    <img src="../../assets/images/logo-web.png" class="PageLogoImg"/>
</a>
<div class="menubar-left">
  <a class="menubar-nav">Tab1</a>
  <a class="menubar-nav">Tab2</a>
  <a class="menubar-nav">Tab3</a>
  <a class="menubar-nav last-nav">Tab4</a>
  <div class="menubar-info-wrap">
    <div class="menubar-info">
      <div class="menubar-name">Hieu lo.n</div>
      <div class="menubar-dropdown">
          <button class="menubar-avt-wrap menubar-drop-btn">
            <img src="../../assets/images/Student-male-icon.png" alt="" class="menubar-avt">
          </button>
          <ul class="menubar-dropdown-menu">
              <li class="menubar-dropdown-item"><a  href="#">Thông tin cá nhân</a></li>
            <li class="menubar-dropdown-item"><a  href="#">Chi tiết lớp học</a></li>
            <li class="menubar-dropdown-item"><a  href="#">Đăng xuất</a></li>
          </ul>
        </div>
    </div>
  </div>
</div>
  
</div>`
//isAuthentication === true
// document.querySelector("#menu-bar").innerHTML = authMenuBarHTMl
// var $ = document.querySelector.bind(document)
// var $$ = document.querySelectorAll.bind(document)

$(".menubar-drop-btn").onclick = ()=>{
  $(".menubar-dropdown-menu").classList.toggle("menubar-show")
}