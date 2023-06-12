function openTab(evt, tabName) {
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function openTab_2(event, tabId) {
    var tabpanes = document.getElementsByClassName("tabpane");
    for (var i = 0; i < tabpanes.length; i++) {
        tabpanes[i].classList.remove("active");
    }

    var tabs = document.getElementsByClassName("tablinks-2");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove("active");
    }

    document.getElementById(tabId).classList.add("active");
    event.target.classList.add("active");
}

document.getElementById('tab3').classList.add("active");

document.getElementById('btn-class-active').classList.add("active");



// Mở tab đầu tiên mặc định
document.getElementById("tabpane1").style.display = "block";
document.getElementsByClassName("tablinks")[0].className += " active";

var nameChildElements = document.getElementsByClassName('name-child');
for (var i = 0; i < nameChildElements.length; i++) {
    nameChildElements[i].addEventListener('click', function () {

        for (var j = 0; j < nameChildElements.length; j++) {
            nameChildElements[j].classList.remove('active');
        }
        this.classList.add('active');

        var childName = this.textContent;
        var child_select = null;
        for (var i = 0; i < ds_con.length; i++) {
            if (ds_con[i].TenHS === childName) {
                child_select = ds_con[i];
                break;
            }
        }

        var html = '';

        html += '<tr><td>Mã học viên:</td>' + '<td>' + child_select.MaHS + '</td></tr>';
        html += '<tr><td>Tên học viên:</td>' + '<td>' + child_select.TenHS + '</td></tr>';
        html += '<tr><td>Giới tính:</td>' + '<td>' + child_select.GioiTinh + '</td></tr>';
        html += '<tr><td>Ngày sinh:</td>' + '<td>' + convertDateFormat(child_select.NgaySinh) + '</td></tr>';
        html += '<tr><td>Tuổi:</td>' + '<td>' + child_select.Tuoi + '</td></tr>';
        html += '<tr><td>Địa chỉ:</td>' + '<td>' + child_select.DiaChi + '</td></tr>';
        html += '<tr><td>Số điện thoại:</td>' + '<td>' + child_select.SDT + '</td></tr>';
        html += '<tr><td>Email:</td>' + '<td>' + child_select.Email + '</td></tr>';
        document.getElementById('tbody-infor').innerHTML = html;

        var html_class = '';
        var check_2 = true;
        for (var i = 0; i < ds_classOpen.length; i++) {
            if (ds_classOpen[i].MaHS == child_select.MaHS) {
                check_2 =false;
                console.log(ds_classOpen[i].MaLop);


                html_class += ' <div class="class"><table style="width: 100%;"> <tbody id="tbody-class"><tr style="width: 100%;">';
                html_class += '<td style="width:30%">Mã lớp: <span style="font-weight: bold;">' + ds_classOpen[i].MaLop + '</span></td>';

                html_class += '<td style="width:40%">Tên lớp: <span style="font-weight: bold;">' + ds_classOpen[i].TenLop + '</span></td>';
                html_class += '<td>Lứa tuổi: <span style="font-weight: bold;">' + ds_classOpen[i].LuaTuoi + '</span></td> </tr>';
                html_class += '<tr style="width: 100%;"> <td style="width:30%">Số lượng học viên : <span style="font-weight: bold;">' + ds_classOpen[i].SLHS + '</span></td> ';
                html_class += '<td style="width:40%">Học phí: <span style="font-weight: bold;">' + numberWithCommas(ds_classOpen[i].HocPhi) + ' VND/ buổi' + '</span></td>';
                html_class += '<td>Số buổi đã tổ chức: <span style="font-weight: bold;">' + ds_classOpen[i].SoBuoiDaToChuc + '/' + ds_classOpen[i].SoBuoi + ' buổi' + '</span></td> </tr>';
                html_class += '<tr style="width: 100%;"> <td style="width:10%">Số buổi nghỉ : <span style="font-weight: bold;">' + ds_classOpen[i].SoBuoiNghi + '</span>  <br>';
                // html_class += '<td style="width:40%">';
                for (var j = 0; j < ds_absent.length; j++) {
                    if (ds_absent[j].MaHS == child_select.MaHS && ds_absent[j].MaLop == ds_classOpen[i].MaLop) {

                        html_class += convertDateFormat(ds_absent[j].ThoiGian) + '<br>' + '        ';
                    }
                }
                html_class += '</td>';
                
                html_class += '<td style="width:40%">Lịch học:<br> <span style="font-weight: bold;">';

                for (var j = 0; j < ds_schedule.length; j++) {
                    if( ds_schedule[j].MaLop == ds_classOpen[i].MaLop) {
                        html_class +=   ds_schedule[j]['day_of_week'] + ', ' + ds_schedule[j]['start_time'] + ' - ' + ds_schedule[j]['end_time'] + '<br>'+ '                 ';
                }}
                html_class += '</span></td>' 
                html_class += '<td>Giảm học phí: <span style="font-weight: bold;">' + ds_classOpen[i].GiamHocPhi + '%' + '</span></td> </tr>';       
                html_class += ' </tbody></table></div> ';
            }
        }
        if(check_2){
            html_class += 'Học viên đang không tham gia lớp học nào';
        }
        document.getElementById('container-class').innerHTML = html_class;

        var html_class_close = '';
        var check_1 = true;
        for (var i = 0; i < ds_classClose.length; i++) {
            if (ds_classClose[i].MaHS == child_select.MaHS) {
                check_1 =false;
                console.log(ds_classClose[i].MaLop);


                html_class_close += ' <div class="class"><table style="width: 100%;"> <tbody id="tbody-class"><tr style="width: 100%;">';
                html_class_close += '<td style="width:30%">Mã lớp: <span style="font-weight: bold;">' + ds_classOpen[i].MaLop + '</span></td>';

                html_class_close += '<td style="width:40%">Tên lớp: <span style="font-weight: bold;">' + ds_classOpen[i].TenLop + '</span></td>';
                html_class_close += '<td>Lứa tuổi: <span style="font-weight: bold;">' + ds_classOpen[i].LuaTuoi + '</span></td> </tr>';
                html_class_close += '<tr style="width: 100%;"> <td style="width:30%">Số lượng học viên : <span style="font-weight: bold;">' + ds_classOpen[i].SLHS + '</span></td> ';
                html_class_close += '<td style="width:40%">Học phí: <span style="font-weight: bold;">' + numberWithCommas(ds_classOpen[i].HocPhi) + ' VND/ buổi' + '</span></td>';
                html_class_close += '<td>Số buổi đã tổ chức: <span style="font-weight: bold;">' + ds_classOpen[i].SoBuoiDaToChuc + '/' + ds_classOpen[i].SoBuoi + ' buổi' + '</span></td> </tr>';
                html_class_close += '<tr style="width: 100%;"> <td style="width:10%">Số buổi nghỉ : <span style="font-weight: bold;">' + ds_classOpen[i].SoBuoiNghi + '</span>  <br>';

                for (var j = 0; j < ds_absent.length; j++) {
                    if (ds_absent[j].MaHS == child_select.MaHS && ds_absent[j].MaLop == ds_classOpen[i].MaLop) {

                        html_class_close += convertDateFormat(ds_absent[j].ThoiGian) + '<br>' + '        ';
                    }
                }
                html_class_close += '</td>';
                html_class_close += '<td style="width:40%">Lịch học:<br> <span style="font-weight: bold;">';

                for (var j = 0; j < ds_schedule.length; j++) {
                    if( ds_schedule[j].MaLop == ds_classClose[i].MaLop) {
                        html_class_close +=   ds_schedule[j]['day_of_week'] + ', ' + ds_schedule[j]['start_time'] + ' - ' + ds_schedule[j]['end_time'] + '<br>'+ '                 ';
                }}
                html_class_close += '</span></td>' 
                html_class_close += '<td>Giảm học phí: <span style="font-weight: bold;">' + ds_classClose[i].GiamHocPhi + '%' + '</span></td> </tr>';       
                html_class_close += ' </tbody></table></div> ';
            }
        }
        if(check_1){
            html_class_close += 'Học viên chưa hoàn thành lớp học nào';
        }
        document.getElementById('container-class-close').innerHTML = html_class_close;


    });




}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function convertDateFormat(dateString) {
    var dateParts = dateString.split("-");
    var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    return formattedDate;
}

function toggleDivLink() {
    var divLink = document.getElementById('div-link');
    divLink.style.display = divLink.style.display === 'block' ? 'none' : 'block';
}


document.getElementById('btn-link').addEventListener('click', function (event) {
    var check = true;
    var check_value = false;
    var check_has = false;
    event.preventDefault();

    const form = document.getElementById('form-link');

    var mahs = document.getElementById('input-child').value;

    for (var i = 0; i < ds_con.length; i++) {
        if (ds_con[i].MaHS == mahs) {
            var check_has = true;
        }
    }

    for (var i = 0; i < ds_maHS.length; i++) {
        if (ds_maHS[i].MaHS == mahs) {
            check_value = true;
            document.getElementById('name-child').value = ds_maHS[i].TenHS;
        }
    }
    if (!mahs) {
        document.getElementById('err-mahs').textContent = "Chưa nhập mã học viên";
        check = false;
    } else if (check_has) {
        document.getElementById('err-mahs').textContent = "Học viên này đã liên kết";
        check = false;
    } else if (!check_value) {
        document.getElementById('err-mahs').textContent = "Mã học viên không chính xác";
        check = false;
    } else
        document.getElementById('err-mahs').textContent = "";

    if (!check)
        return;

    document.getElementById('tb1').innerHTML = "Đã gửi yêu cầu liên kết !";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});


////////////

var button = document.getElementById('btn-nofi');
var hiddenDiv = document.getElementById('div-nofi');

button.addEventListener('click', function() {
    hiddenDiv.style.display = hiddenDiv.style.display === 'block' ? 'none' : 'block';
 
});

var divNofiContainer = document.getElementById('div-nofi');

ds_yeuCau.forEach(function(yeuCau) {

  var nofiDiv = document.createElement('div');
  nofiDiv.id = 'nofi';
  nofiDiv.innerHTML = '<p>Học viên ' + yeuCau.TenHS + ' đã gửi yêu cầu liên kết với bạn</p>' +
                      '<button onclick="tuChoi(' + yeuCau.MaHS + ',' + yeuCau.MaPH + ')">Từ chối</button>' +
                      '<button onclick="chapNhan(' + yeuCau.MaHS + ',' + yeuCau.MaPH + ')">Chấp nhận</button>';

  divNofiContainer.appendChild(nofiDiv);


});

dsHoaDon_CD.forEach(function(yeuCau) {yeuCau

    var nofiDiv = document.createElement('div');
    nofiDiv.id = 'nofi';
    nofiDiv.innerHTML = '<p> Hóa đơn '+ yeuCau.TenHD + ' (' + numberWithCommas(yeuCau.SoTienPhaiDong) +  ' VND) của  Học viên ' +yeuCau.TenHS +  '  chưa được thanh toán</p>'
    divNofiContainer.appendChild(nofiDiv);
  });



  dsHoaDon_CN.forEach(function(yeuCau) {

    var nofiDiv = document.createElement('div');
    nofiDiv.id = 'nofi';
    nofiDiv.innerHTML = '<p> Hóa đơn '+ yeuCau.TenHD + ' còn nợ (' + numberWithCommas(yeuCau.NoPhiConLai) +  ' VND) của  Học viên ' +yeuCau.TenHS +  '  chưa được thanh toán</p>'
    divNofiContainer.appendChild(nofiDiv);
  });



function tuChoi(maHS, maPH) {
    var form = document.createElement('form');

    form.method = 'POST';
      form.name = 'refuse-form'
   
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'refuse-maHS';
    input.value = maHS;
    form.appendChild(input);
  
    document.body.appendChild(form);
    form.submit();
  
}

function chapNhan(maHS, maPH) {


  var form = document.createElement('form');

  form.method = 'POST';
    form.name = 'accept-form'
 
  var input = document.createElement('input');
  input.type = 'hidden';
  input.name = 'accept-maHS';
  input.value = maHS;
  form.appendChild(input);

  document.body.appendChild(form);
  form.submit();
}

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
