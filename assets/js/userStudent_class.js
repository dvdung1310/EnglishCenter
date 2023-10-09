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
document.getElementById("tabpane1").style.display = "block";
document.getElementById('btn-1').classList.add("active");


var html_class = '';
for (var i = 0; i < ds_classOpen.length; i++) {

        html_class += ' <div class="class"><table style="width: 100%;"> <tbody id="tbody-class"><tr style="width: 100%;">';
        html_class += '<td style="width:30%">Mã lớp: <span style="font-weight: bold;">' + ds_classOpen[i].MaLop + '</span></td>';

        html_class += '<td style="width:40%">Tên lớp: <span style="font-weight: bold;">' + ds_classOpen[i].TenLop + '</span></td>';
        html_class += '<td>Lứa tuổi: <span style="font-weight: bold;">' + ds_classOpen[i].LuaTuoi + '</span></td> </tr>';
        html_class += '<tr style="width: 100%;"> <td style="width:30%">Số lượng học viên : <span style="font-weight: bold;">' + ds_classOpen[i].SLHS + '</span></td> ';
        html_class += '<td style="width:40%">Học phí: <span style="font-weight: bold;">' + numberWithCommas(ds_classOpen[i].HocPhi) + ' VND/ buổi' + '</span></td>';
        html_class += '<td>Số buổi đã tổ chức: <span style="font-weight: bold;">' + ds_classOpen[i].SoBuoiDaToChuc + '/' + ds_classOpen[i].SoBuoi + ' buổi' + '</span></td> </tr>';
        html_class += '<tr style="width: 100%;"> <td style="width:10%; line-height: 20px; ">Số buổi nghỉ : <span style="font-weight: bold;">' + ds_classOpen[i].SoBuoiNghi + '</span>  <br>';
        // html_class += '<td style="width:40%">';
        for (var j = 0; j < ds_absent.length; j++) {
            if( ds_absent[j].MaLop == ds_classOpen[i].MaLop) {
                html_class += convertDateFormat(ds_absent[j].ThoiGian) + '<br>' + '                 ';
        }}
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

document.getElementById('container-class').innerHTML = html_class;

var html_class_close = '';
for (var i = 0; i < ds_classClose.length; i++) {
  
        html_class_close += ' <div class="class"><table style="width: 100%;"> <tbody id="tbody-class"><tr style="width: 100%;">';
        html_class_close += '<td style="width:30%">Mã lớp: <span style="font-weight: bold;">' + ds_classClose[i].MaLop + '</span></td>';

        html_class_close += '<td style="width:40%">Tên lớp: <span style="font-weight: bold;">' + ds_classClose[i].TenLop + '</span></td>';
        html_class_close += '<td>Lứa tuổi: <span style="font-weight: bold;">' + ds_classClose[i].LuaTuoi + '</span></td> </tr>';
        html_class_close += '<tr style="width: 100%;"> <td style="width:30%">Số lượng học viên : <span style="font-weight: bold;">' + ds_classClose[i].SLHS + '</span></td> ';
        html_class_close += '<td style="width:40%">Học phí: <span style="font-weight: bold;">' + numberWithCommas(ds_classClose[i].HocPhi) + ' VND/ buổi' + '</span></td>';
        html_class_close += '<td>Số buổi đã tổ chức: <span style="font-weight: bold;">' + ds_classClose[i].SoBuoiDaToChuc + '/' + ds_classClose[i].SoBuoi + ' buổi' + '</span></td> </tr>';
        html_class_close += '<tr style="width: 100%;"> <td style="width:10%">Số buổi nghỉ : <span style="font-weight: bold;">' + ds_classClose[i].SoBuoiNghi + '</span>  <br>';
        for (var j = 0; j < ds_absent.length; j++) {
            if( ds_absent[j].MaLop == ds_classClose[i].MaLop) {
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

document.getElementById('container-class-close').innerHTML = html_class_close;


function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
function convertDateFormat(dateString) {
    var dateParts = dateString.split("-");
    var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    return formattedDate;
}