var class_select = '';
var date_select = '';

var dateListDiv = document.getElementById('date-list');
function showHiddenInfo(event, maLopp) {
    document.getElementById('modal-bg').style.display = 'block';

    dateListDiv.innerHTML = '';

    for (var key in diemDanhGrouped) {
        if (diemDanhGrouped.hasOwnProperty(key)) {
            var diemDanhArray = diemDanhGrouped[key];
            var maLop = diemDanhArray[0].MaLop;

            if (maLop === maLopp) {
                createAttendanceDateDiv(diemDanhArray);
            }
        }
    }
    class_select = maLopp;
}

function createAttendanceDateDiv(diemDanhArray) {
    var thoiGian = diemDanhArray[0].ThoiGian;

    var dateDiv = document.createElement('div');
    dateDiv.className = 'date';
    dateDiv.addEventListener('click', function () {
        showAttendanceInterface(thoiGian, diemDanhArray);
    });

    var timeP = document.createElement('p');
    timeP.style.marginLeft = '50px';
    timeP.id = 'time';
    timeP.textContent = 'Ngày: ' + formatDate(thoiGian);

    var numberP = document.createElement('p');
    numberP.id = 'number';
    var diHocCount = 0;
    var nghiHocCount = 0;

    for (var i = 0; i < diemDanhArray.length; i++) {
        var dd = diemDanhArray[i].dd;
        if (dd === 1) {
            diHocCount++;
        } else if (dd === 0) {
            nghiHocCount++;
        }
    }

    numberP.textContent = 'Sĩ số: ' + diHocCount + '/' + (diHocCount + nghiHocCount);

    var absentP = document.createElement('p');
    absentP.style.marginRight = '30px';
    absentP.id = 'absent';
    absentP.textContent = 'Vắng: ' + nghiHocCount;

    dateDiv.appendChild(timeP);
    dateDiv.appendChild(numberP);
    dateDiv.appendChild(absentP);

    dateListDiv.appendChild(dateDiv);
}


function showAttendanceInterface(thoiGian, diemDanhArray) {


    date_select = thoiGian;
    document.getElementById('modal-bg-update').style.display = 'block';

    // Hiển thị thông tin thời gian
    var timeHeader = document.getElementById('time-header');
    timeHeader.textContent = 'Thời gian: ' + formatDate(thoiGian);

    // Lấy tbody của bảng điểm danh
    var tbody = document.getElementById('tbody-listStudent');
    tbody.innerHTML = '';

    // Hiển thị danh sách học sinh
    for (var i = 0; i < diemDanhArray.length; i++) {
        var diemDanh = diemDanhArray[i];
        var stt = i + 1;
        var maHS = diemDanh.MaHS;
        var tenHS = diemDanh.TenHS;
        var dd = diemDanh.dd;


        var row = document.createElement('tr');

        var sttCell = document.createElement('td');
        sttCell.textContent = stt;
        row.appendChild(sttCell);

        var maHSCell = document.createElement('td');
        maHSCell.textContent = maHS;
        row.appendChild(maHSCell);

        var tenHSCell = document.createElement('td');
        tenHSCell.textContent = tenHS;
        row.appendChild(tenHSCell);

        var ddCell = document.createElement('td');
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = dd === 1;
        ddCell.appendChild(checkbox);
        row.appendChild(ddCell);

        tbody.appendChild(row);


    }
    document.getElementById('time-update').value = thoiGian;
    document.getElementById('class-update').value = diemDanhArray[0].MaLop;


}

var diemDanhGrouped = {};

for (var i = 0; i < ds_diemdanh.length; i++) {
    var diemDanh = ds_diemdanh[i];
    var maLop = diemDanh.MaLop;
    var thoiGian = diemDanh.ThoiGian;
    var key = maLop + '-' + thoiGian;

    if (!diemDanhGrouped.hasOwnProperty(key)) {
        diemDanhGrouped[key] = [];
    }

    diemDanhGrouped[key].push(diemDanh);
}
console.log(diemDanhGrouped);

document.getElementById('close').addEventListener('click', function () {
    document.getElementById('modal-bg').style.display = 'none';
    document.getElementById('date-list').innerHTML = '';
});

document.getElementById('close-update').addEventListener('click', function () {
    document.getElementById('modal-bg-update').style.display = 'none';
});


// function diemDanh() {
//     // Lấy danh sách checkbox trong bảng điểm danh
//     var checkboxes = document.querySelectorAll('#attendance input[type="checkbox"]');

//     // Lặp qua danh sách checkbox và cập nhật điểm danh
//     checkboxes.forEach(function(checkbox, index) {
//         var diemDanh = diemDanhArray[index];
//         diemDanh.dd = checkbox.checked ? 1 : 0;
//     });

//     // Đóng giao diện cập nhật điểm danh
//     document.getElementById('modal-bg-update').style.display = 'none';
// }\

document.getElementById('btn-update').addEventListener('click', function (event) {


    //   var check = true;

    event.preventDefault();


    for(var i= 0;i<ds_lopDong.length ;i++){
        if(class_select == ds_lopDong[i].MaLop){
            document.querySelector('.add-cant').style.display = 'block';
            return;
        }
    }
    var checkboxes = document.querySelectorAll('#attendance tbody input[type="checkbox"]');

    // Tạo một mảng để lưu trữ dữ liệu điểm danh
    var danhSachDiemDanh = [];

    // Lặp qua từng checkbox và lấy dữ liệu tương ứng
    checkboxes.forEach(function (checkbox) {
        var stt = checkbox.parentElement.parentElement.cells[0].textContent;
        var maHS = checkbox.parentElement.parentElement.cells[1].textContent;
        var tenHS = checkbox.parentElement.parentElement.cells[2].textContent;
        var diemDanh = checkbox.checked ? 1 : 0;

        // Tạo một đối tượng để lưu trữ dữ liệu điểm danh
        var diemDanhObj = {
            maHS: maHS,
            tenHS: tenHS,
            diemDanh: diemDanh
        };

        // Thêm đối tượng vào mảng danhSachDiemDanh
        danhSachDiemDanh.push(diemDanhObj);
    });




    var form = document.getElementById('form-update');
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'danhSachDiemDanh');
    input.setAttribute('value', JSON.stringify(danhSachDiemDanh));
    form.appendChild(input);

    
   



    document.getElementById('tb1').innerHTML = "Đã cập nhật điểm danh ngày  thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);
});


function formatDate(dateString) {
    var dateParts = dateString.split('-');
    var year = dateParts[0];
    var month = dateParts[1];
    var day = dateParts[2];

    var formattedDate = day + '-' + month + '-' + year;
    return formattedDate;
}


document.getElementById('close-add').addEventListener('click', function () {
   
    document.getElementById('modal-bg-add').style.display = 'none';
    document.getElementById('error-time').innerHTML =  "";

});

document.getElementById('close-err').addEventListener('click', function () {
    document.querySelector('.add-cant').style.display = 'none';
});

document.getElementById('btn-add').addEventListener('click', function () {

    var html = '';
    var k=1;
    for (var i = 0; i < ds_hocsinh.length; i++) {
        if(ds_hocsinh[i].MaLop == class_select){
            html += '<tr>'
            html += '<td>' + (k++) + '</td>';
            html += '<td>' + ds_hocsinh[i].MaHS + '</td>';
            html += '<td>' + ds_hocsinh[i].TenHS + '</td>';
            html += '<td>  <input type="checkbox">  </td>';
            html += '</tr>';
        }

       
    }
    document.getElementById('tbody-listStudent-add').innerHTML = html

    document.getElementById('modal-bg-add').style.display = 'block';
});

document.getElementById('btn-add-submit').addEventListener('click', function (event) {


    event.preventDefault();


    for(var i= 0;i<ds_lopDong.length ;i++){
        if(class_select == ds_lopDong[i].MaLop){
            document.querySelector('.add-cant').style.display = 'block';
            
            return;
            

        }
    }

    var time =  document.getElementById('time-add').value ;
    if(!time){
        document.getElementById('error-time').innerHTML =  "Chưa nhập ngày tháng";
        return;
    }
    else
    document.getElementById('error-time').innerHTML =  "";


    var checkboxes = document.querySelectorAll('#attendance-add tbody input[type="checkbox"]');

    // Tạo một mảng để lưu trữ dữ liệu điểm danh
    var danhSachDiemDanh = [];

    // Lặp qua từng checkbox và lấy dữ liệu tương ứng
    checkboxes.forEach(function (checkbox) {
        var stt = checkbox.parentElement.parentElement.cells[0].textContent;
        var maHS = checkbox.parentElement.parentElement.cells[1].textContent;
        var tenHS = checkbox.parentElement.parentElement.cells[2].textContent;
        var diemDanh = checkbox.checked ? 1 : 0;

        // Tạo một đối tượng để lưu trữ dữ liệu điểm danh
        var diemDanhObj = {
            maHS: maHS,
            tenHS: tenHS,
            diemDanh: diemDanh
        };

        // Thêm đối tượng vào mảng danhSachDiemDanh
        danhSachDiemDanh.push(diemDanhObj);
    });


    document.getElementById('class-add').value = class_select;

    var form = document.getElementById('form-add');
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'danhSachDiemDanh');
    input.setAttribute('value', JSON.stringify(danhSachDiemDanh));
    form.appendChild(input);

    


    document.getElementById('tb1').innerHTML = "Đã thêm  điểm danh thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);
});


document.getElementById('btn-delete').addEventListener('click', () => {
    document.querySelector('.delete-ques').style.display = 'block';
});
document.getElementById('delete-cancle').addEventListener('click', () => {
    document.querySelector('.delete-ques').style.display = 'none';
});
document.getElementById('delete').addEventListener('click', function(event) {

    const form = document.getElementById('form-delete');

    event.preventDefault();
    document.querySelector('.delete-ques').style.display = 'none';
    
    document.getElementById('date-delete').value = date_select;
    document.getElementById('class-delete').value = class_select;
   

    document.getElementById('tb1').innerHTML = "Đã xóa điểm danh thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});



////
// document.getElementById("link-wageTeacher").addEventListener("click", function(event) {
//     event.preventDefault(); 
  
   
//     var data = {
//       key1: MaGV,
     
//     };
  
//     // Tạo một form ẩn
//     var form = document.createElement("form");
//     form.method = "POST";
//     form.action = "./userTeacher_wage.php";
  
//     // Thêm các input chứa dữ liệu vào form
//     for (var key in data) {
//       if (data.hasOwnProperty(key)) {
//         var input = document.createElement("input");
//         input.type = "hidden";
//         input.name = key;
//         input.value = data[key];
//         form.appendChild(input);
//       }
//     }
  
//     // Gắn form vào body và tự động submit
//     document.body.appendChild(form);
//     form.submit();
//   });
  