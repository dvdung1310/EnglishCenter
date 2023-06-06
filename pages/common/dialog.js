//init setting
var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)
const dialogHTML = `<div class="page-dialog-wrap">
<div class="page-dialog-inner">
    <div class="page-dialog-title">Chi tiết lớp học</div>
    <div class="class-menu-table">
        <table class="table dialog-menu-table">
            <thead>
              <tr>
                <th scope="col">Mã lớp</th>
                <th scope="col">Tên lớp</th>
                <th scope="col">Giáo viên</th>
                <th scope="col">Thời gian học </th>
                <th scope="col">Số buổi học </th>
                <th scope="col">Buổi học </th>
                <th scope="col">Chi tiết </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <!-- giá trị các cột -->
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
                <td>@mdo</td>
                
                <td>chi tiet</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
                
                <td>@mdo</td>
                <td>chi tiet</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
                <td>@mdo</td>
                
                <td>@mdo</td>
                <td>chi tiet</td>
              </tr>
            </tbody>
          </table>

    </div>
    <div class="btn-dialog-wrap">
        <button class="close-dialog-btn">Đóng</button>
    </div>
</div>
</div>`

//setup
$("#dialog-wrap").innerHTML = dialogHTML
$(".open-dialog-btn").onclick = ()=>{
    $(".page-dialog-wrap").classList.add("open-dialog")
}
$(".close-dialog-btn").onclick = ()=>{
    $(".page-dialog-wrap").classList.remove("open-dialog")
}