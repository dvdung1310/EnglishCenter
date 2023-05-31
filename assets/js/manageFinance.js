function convertDateFormat(dateString) {
    var dateParts = dateString.split("-");
    var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    return formattedDate;
}

// Mặc định hiển thị tab đầu tiên
document.getElementById("Tab1").style.display = "block";
document.getElementById("btn-tab1").classList.add("active");

document.getElementById("Tab1-add").style.display = "block";
document.getElementById("btn-tab1-add").classList.add("active");



// var a = Math.round(203000/100*24.123);

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
//Hiẹn thị bảng
var filteredData = dsHoaDon;
hienthids('');
function hienthids(status) {
    // var filteredData = dsHoaDon;
    if (status) {
        // filteredData = dsHoaDon.filter(function (hoaDon) {
        //     return hoaDon['TrangThai'] === status;
        // });
        filteredData = dsHoaDon.filter(function (hoaDon) {
            return hoaDon['TrangThai'] === status;
        });
    }

    var html = '';
    var color = '';
    if (filteredData.length != 0) {
        for (var i = 0; i < filteredData.length; i++) {
            if (filteredData[i]['TrangThai'] === 'Hoàn thành') {
                color = "lightgreen";
            }
            else if (filteredData[i]['TrangThai'] === 'Chưa đóng') { color = "#ff9393" }
            else { color = "#bcbdff" }

            html += '<tr onclick="handleRowClick(' + i + ')">';
            html += '<td style="width:20px ;background-color:' + color + '">' + (i + 1) + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['MaHD'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TenHD'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TenHS'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['MaLop'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['ThoiGian'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + numberWithCommas(filteredData[i]['SoTien']) + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['GiamHocPhi'] + '%</td>';
            html += '<td style = "background-color:' + color + '">' + numberWithCommas(filteredData[i]['SoTienGiam']) + '</td>';
            html += '<td style = "background-color:' + color + '">' + numberWithCommas(filteredData[i]['SoTienPhaiDong']) + '</td>';
            html += '<td style = "background-color:' + color + '">' + numberWithCommas(filteredData[i]['SoTienDaDong']) + '</td>';
            html += '<td style = "background-color:' + color + '">' + numberWithCommas(filteredData[i]['NoPhiConLai']) + '</td>';

            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TrangThai'] + '</td>';

            html += '</tr>';

        }
        document.querySelector(".tbody-1").innerHTML = html;
    }
}



var selectStatus = document.getElementById('select-status');
selectStatus.addEventListener('change', function () {
    var selectedStatus = selectStatus.value;
    hienthids(selectedStatus);
});


// sap xep bang

function parseNumericValue(value) {
    return parseInt(value.replace(/,/g, ''));
}
function parseDateValue(value) {
    var parts = value.split('/');
    var month = parseInt(parts[0]);
    var year = parseInt(parts[1]);
    return new Date(year, month - 1);
}

var sortDirection = {}; // Store the current sort direction for each column

function sortTable(columnIndex) {
    var table = document.getElementById('table-1');
    var tbody = table.querySelector('.tbody-1');
    var rows = Array.from(tbody.getElementsByTagName('tr'));
    var sttValues = rows.map(function (row) {
        return parseInt(row.getElementsByTagName('td')[0].innerText.trim());
    });

    rows.sort(function (a, b) {
        var aValue = a.getElementsByTagName('td')[columnIndex].innerText.trim();
        var bValue = b.getElementsByTagName('td')[columnIndex].innerText.trim();


        if (columnIndex === 2 || columnIndex === 3 || columnIndex === 4 || columnIndex === 12) {
            if (sortDirection[columnIndex] === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        }
        else
            if (columnIndex === 0) {
                // return parseInt(aValue) - parseInt(bValue);
                return;
            } else if (columnIndex === 5) {
                var aDate = parseDateValue(aValue);
                var bDate = parseDateValue(bValue);

                if (sortDirection[columnIndex] === 'asc') {
                    return aDate - bDate;
                } else {
                    return bDate - aDate;
                }
            } else {
                aValue = parseNumericValue(aValue);
                bValue = parseNumericValue(bValue);

                if (sortDirection[columnIndex] === 'asc') {
                    return aValue - bValue;
                } else {
                    return bValue - aValue;
                }
            }


    });



    rows.forEach(function (row, index) {
        var sttCell = row.getElementsByTagName('td')[0];
        sttCell.innerText = sttValues[index];
    });

    rows.forEach(function (row) {
        tbody.appendChild(row);
    });


    // Reverse the sort direction for the clicked column
    if (sortDirection[columnIndex] === 'asc') {
        sortDirection[columnIndex] = 'desc';
    } else {
        sortDirection[columnIndex] = 'asc';
    }

    // Update the sort icon in the column header
    updateSortIcon(columnIndex);



}




function updateSortIcon(columnIndex) {
    var table = document.getElementById('table-1');
    var headers = table.querySelectorAll('th');

    headers.forEach(function (header) {
        // Remove the sort icon from all column headers
        var icon = header.querySelector('img');
        if (icon) {
            header.removeChild(icon);
        }
    });

    // Add the sort icon to the clicked column header
    var clickedHeader = headers[columnIndex];
    var sortIcon = document.createElement('img');
    sortIcon.src = '../assets/images/arrow-up-down-bold-icon.png';
    sortIcon.style.width = '20px';
    sortIcon.style.backgroundColor = 'white';
    sortIcon.style.borderRadius = '30px';
    if (sortDirection[columnIndex] === 'asc') {
        sortIcon.style.transform = 'rotate(180deg)';
    }
    clickedHeader.appendChild(sortIcon);
}





//
// function openTab(evt, tabName) {
//     var i, tabcontent, tablinks;

//     // Ẩn tất cả các nội dung của tab
//     tabcontent = document.getElementsByClassName("tabcontent");
//     for (i = 0; i < tabcontent.length; i++) {
//         tabcontent[i].style.display = "none";
//     }

//     // Loại bỏ lớp active của tất cả các button
//     tablinks = document.getElementsByClassName("tablinks");
//     for (i = 0; i < tablinks.length; i++) {
//         tablinks[i].className = tablinks[i].className.replace(" active", "");
//     }

//     // Hiển thị nội dung của tab được chọn và đánh dấu button đã chọn
//     document.getElementById(tabName).style.display = "block";
//     evt.currentTarget.className += " active";
// }


function openTab_add(evt, tabName) {
    var i, tabcontent, tablinks;

    // Ẩn tất cả các nội dung của tab
    tabcontent = document.getElementsByClassName("tabcontent-add");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Loại bỏ lớp active của tất cả các button
    tablinks = document.getElementsByClassName("tablinks-add");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Hiển thị nội dung của tab được chọn và đánh dấu button đã chọn
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function openTab_3(evt, tabName) {
    var i, tabcontent, tablinks;

    // Ẩn tất cả các nội dung của tab
    tabcontent = document.getElementsByClassName("tabcontent-3");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Loại bỏ lớp active của tất cả các button
    tablinks = document.getElementsByClassName("tablinks-3");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Hiển thị nội dung của tab được chọn và đánh dấu button đã chọn
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}









// Them hoa don

const modalBgAdd = document.querySelector('.modal-bg-add');
const modalContentAdd = document.querySelector('.modal-content-add');

document.querySelector('.add-bill-button').addEventListener('click', () => {
    modalBgAdd.style.display = 'block';
})


var monthSelect = document.getElementById("bill-month-add");
var yearSelect = document.getElementById("bill-year-add");
var classsSelect = document.getElementById("bill-class-add");

monthSelect.addEventListener("change", updateclasssOptions);
yearSelect.addEventListener("change", updateclasssOptions);
var addedClasses = [];
// Hàm cập nhật các giá trị trong select bill-classs-add
function updateclasssOptions() {
    
    var selectedMonth = monthSelect.value;
    var selectedYear = yearSelect.value;
    var check = true;
    if(inputsValue.length != 0){
        inputs.forEach(input => outputDiv.removeChild(input));
        inputs = [];
        inputsValue = [];
    }

    while (classsSelect.options.length > 0) {
        classsSelect.remove(0);
    }

        // Add default option
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Chọn lớp học';
    classsSelect.appendChild(defaultOption);

     addedClasses = [];
    for (var i = 0; i < ds_diemdanh.length; i++) {
        var diemdanh = ds_diemdanh[i];
        var diemdanhMonth = parseInt(diemdanh.ThoiGian.split("-")[1]);
        var diemdanhYear = parseInt(diemdanh.ThoiGian.split("-")[0]);
     
        if ((diemdanhMonth == selectedMonth) && (diemdanhYear == selectedYear)) {
           
            var classs = {
                MaLop: diemdanh.MaLop,
               
            };

            var isclasssAdded = addedClasses.some(function (addedclasss) {
                return addedclasss.MaLop === classs.MaLop ;
            });

            if(!isclasssAdded && check){
                var defaultOption = document.createElement('option');
                 defaultOption.value = 'Tất cả';
                 defaultOption.textContent = 'Tất cả';
                 classsSelect.appendChild(defaultOption);
                 check = false;
            }
            
            if (!isclasssAdded) {
                addedClasses.push(classs);
                var option = document.createElement("option");
                option.value = classs.MaLop;
                option.text = classs.MaLop;
                classsSelect.add(option);
            }
        }
    }
}




// class
const select = document.getElementById("bill-class-add");
const outputDiv = document.getElementById("div-bill-class-add");
const options_All = document.querySelectorAll('#bill-class-add option');

var inputs = [];
var inputsValue = [];



select.addEventListener("change", (event) => {
    // Xóa input đã chọn nếu có
    var check = true;
    const selectedOption = event.target.value;

    if (selectedOption === 'Tất cả') {
        inputs.forEach(input => outputDiv.removeChild(input));
        inputs = [];
        inputsValue = [];
        const options_All = addedClasses;
        for (var i = 0; i < options_All.length; i++) {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = options_All[i].MaLop;
            input.setAttribute('readonly', 'readonly');
            inputsValue.push(input.value);
            inputs.push(input);
            outputDiv.appendChild(input);
        }

    }
    else {
        inputsValue.forEach(i => {
            if (i == selectedOption)
                check = false;
        });
        if (selectedOption !== '' && check) {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = selectedOption;
            input.setAttribute('readonly', 'readonly');
            inputsValue.push(selectedOption);
            inputs.push(input);
            outputDiv.appendChild(input);
        }
    }


});

document.getElementById('reset-class').addEventListener('click', () => {
    inputs.forEach(input => outputDiv.removeChild(input));
    inputs = [];
    inputsValue = [];
});

document.getElementById('reset-1').addEventListener('click', () => {
    inputs.forEach(input => outputDiv.removeChild(input));
    inputs = [];
    inputsValue = [];
});

document.querySelector('.btn-close-add').addEventListener('click', () => {
    modalBgAdd.style.display = 'none';
    document.getElementById("Tab1-add").style.display = "block";
    document.getElementById("btn-tab1-add").classList.add("active");
    document.getElementById("btn-tab2-add").classList.remove("active");
    document.getElementById("Tab2-add").style.display = "none";
});

// Khi nhấn tao

document.getElementById('sumit-bill-add').addEventListener('click', function (event) {
    var check = true;
    const form1 = document.getElementById('form-add-bill')
    event.preventDefault();
    const name_bill = document.getElementById('bill-name-add').value;
    const month_bill = document.getElementById('bill-month-add').value;
    const year_bill = document.getElementById('bill-year-add').value;


    var erorr_empty = "*Dữ liệu không để trống";

    //Kiểm tra dữ liệu nhập vào

    if (!name_bill) {
        document.getElementById('lb-name-add').textContent = "*Chưa nhập tên hóa đơn";
        check = false;
    } else
        document.getElementById('lb-name-add').textContent = "";

    if (!month_bill) {
        document.getElementById('lb-time-add').textContent = "*Chưa chọn thời gian";
        check = false;
    } else {
        if (!year_bill) {
            document.getElementById('lb-time-add').textContent = "*Chưa chọn thời gian";
            check = false;
        } else
            document.getElementById('lb-time-add').textContent = "";
    }

    if (inputsValue.length === 0) {

        document.getElementById('lb-class-add').textContent = "*Chưa chọn lớp";
        check = false;
    } else
        document.getElementById('lb-class-add').textContent = "";

    document.getElementById('class-add-bill').value = inputsValue;

    if (!check)
        return;
    document.getElementById('tb1').innerHTML = "Đã thêm hóa đơn tháng " + month_bill + "/" + year_bill + " thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form1.submit();
    }, 1500);
});


// Thêm hóa đơn cá nhân
var classSelect = document.getElementById("bill-class-add-ps");
var studentSelect = document.getElementById("name-student-add-bill");



// Gán sự kiện onchange cho select "bill-class-add-ps"
classSelect.addEventListener("change", function () {
    // Xóa tất cả các option trong select "name-student-add-bill"
    studentSelect.innerHTML = '<option value="">Chọn Học viên</option>';

    // Lấy giá trị lớp được chọn
    var selectedClass = classSelect.value;
    for (var i = 0; i < dshs_lopxHS.length; i++) {
        var student = dshs_lopxHS[i];
        if (student.MaLop === selectedClass) {
            var option = document.createElement("option");
            option.value = student.MaHS;
            option.textContent = student.MaHS + '. ' + student.TenHS;
            studentSelect.appendChild(option);
        }
    }
});
var monthSelect_ps = document.getElementById("bill-month-add-ps");
var yearSelect_ps = document.getElementById("bill-year-add-ps");
var classsSelect_ps = document.getElementById("bill-class-add-ps");

// Sự kiện khi thay đổi select bill-month-add hoặc select bill-year-add
monthSelect_ps.addEventListener("change", updateclasssOptions2);
yearSelect_ps.addEventListener("change", updateclasssOptions2);
var addedClasses_ps = [];
// Hàm cập nhật các giá trị trong select bill-classs-add
function updateclasssOptions2() {
    
    var selectedMonth = monthSelect_ps.value;
    var selectedYear = yearSelect_ps.value;
    var check = true;


    while (classsSelect_ps.options.length > 0) {
        classsSelect_ps.remove(0);
    }

        // Add default option
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Chọn lớp học';
    classsSelect_ps.appendChild(defaultOption);

     addedClasses = [];
    for (var i = 0; i < ds_diemdanh.length; i++) {
        var diemdanh = ds_diemdanh[i];
        var diemdanhMonth = parseInt(diemdanh.ThoiGian.split("-")[1]);
        var diemdanhYear = parseInt(diemdanh.ThoiGian.split("-")[0]);
     
        if ((diemdanhMonth == selectedMonth) && (diemdanhYear == selectedYear)) {
           
            var classs = {
                MaLop: diemdanh.MaLop,
               
            };

            var isclasssAdded = addedClasses.some(function (addedclasss) {
                return addedclasss.MaLop === classs.MaLop ;
            });

            if(!isclasssAdded && check){
                var defaultOption = document.createElement('option');
                 defaultOption.value = 'Tất cả';
                 defaultOption.textContent = 'Tất cả';
                 classsSelect_ps.appendChild(defaultOption);
                 check = false;
            }
            
            if (!isclasssAdded) {
                addedClasses.push(classs);
                var option = document.createElement("option");
                option.value = classs.MaLop;
                option.text = classs.MaLop;
                classsSelect_ps.add(option);
            }
        }
    }
}






document.getElementById('sumit-bill-add-ps').addEventListener('click', function (event) {
    var check = true;
    const form1 = document.getElementById('form-add-bill-ps');
    event.preventDefault();
    const name_bill = document.getElementById('bill-name-add-ps').value;
    const month_bill = document.getElementById('bill-month-add-ps').value;
    const year_bill = document.getElementById('bill-year-add-ps').value;
    const name_student = document.getElementById('name-student-add-bill').value;
    const class_bill = document.getElementById('bill-class-add-ps').value;


    //Kiểm tra dữ liệu nhập vào

    if (!name_bill) {
        document.getElementById('lb-name-add-ps').textContent = "*Chưa nhập tên hóa đơn";
        check = false;
    } else
        document.getElementById('lb-name-add-ps').textContent = "";

    if (!month_bill) {
        document.getElementById('lb-time-add-ps').textContent = "*Chưa chọn thời gian";
        check = false;
    } else
        document.getElementById('lb-time-add-ps').textContent = "";

    if (!year_bill) {
        document.getElementById('lb-time-add-ps').textContent = "*Chưa chọn thời gian";
        check = false;
    } else
        document.getElementById('lb-time-add-ps').textContent = "";


    if (!class_bill) {

        document.getElementById('lb-class-add-ps').textContent = "*Chưa chọn lớp";
        check = false;
    } else
        document.getElementById('lb-class-add-ps').textContent = "";

    if (!name_student) {

        document.getElementById('lb-name-student-add-bill').textContent = "*Chưa chọn học sinh";
        check = false;
    } else
        document.getElementById('lb-name-student-add-bill').textContent = "";

    if (!check)
        return;

    var hasAttendance = false;

    for (var i = 0; i < ds_diemdanh.length; i++) {
        var attendance = ds_diemdanh[i];

        // Kiểm tra nếu mã học sinh, mã lớp và thời gian phù hợp
        if (
            attendance.MaHS === name_student &&
            attendance.MaLop === class_bill &&
            attendance.ThoiGian.includes(year_bill + '-' + month_bill)
        ) {
            
            if (attendance.dd === 1) {
                hasAttendance = true;
                break; 
            }
        }
    }

    if (!hasAttendance) {
        document.getElementById('tb2').innerHTML = "Học viên " + name_student + ' chưa tham gia buổi nào học của lớp ' + class_bill + '  trong tháng ' + month_bill + "/" + year_bill + " ! ";
        document.querySelector('.delete-cant').style.display = 'block';
    }

    else {

        document.getElementById('tb1').innerHTML = "Đã thêm hóa đơn " + month_bill + "/" + year_bill + "của học viên " + " thành công! ";

        document.querySelector('.add-success').style.display = 'block';

        setTimeout(function () {
            document.querySelector('.add-success').style.display = 'none';
            form1.submit();
        }, 1500);
    }
});

document.getElementById('close').addEventListener('click', () => {
    document.querySelector('.delete-cant').style.display = 'none';
});
//thong tin chi tiet hoa don

const rows = document.querySelectorAll('.tbody-1 tr');
const modalBg = document.querySelector('.modal-bg');
const modalContent = document.querySelector('.modal-content');


var maHD_select;
var hoaDon_select;

var lsthp = [];
function handleRowClick(index) {
    // Xử lý sự kiện khi bấm vào một dòng
    // var selectedRow = rows[index].cells[1];
    var selectedRow = filteredData[index];


    document.getElementById("btn-tab-3-1").classList.add("active");
    document.getElementById("btn-tab-3-2").classList.remove("active");
    document.getElementById("btn-tab-3-2").classList.remove("active");
    document.getElementById("tab-3-1").style.display = 'block';
    document.getElementById("tab-3-2").style.display = 'none';
    document.getElementById("tab-3-3").style.display = 'none';


    maHD_select = selectedRow.MaHD;

    for (var i = 0; i < dsHoaDon.length; i++) {
        if (maHD_select == dsHoaDon[i].MaHD)
            hoaDon_select = dsHoaDon[i];
    }

    document.getElementById('id-bill-detail').textContent = maHD_select;
    document.getElementById('name-bill-detail').textContent = hoaDon_select.TenHD;
    document.getElementById('class-bill-detail').textContent = hoaDon_select.MaLop;
    document.getElementById('id-st-detail').textContent = hoaDon_select.MaHS;
    document.getElementById('name-st-bill-detail').textContent = hoaDon_select.TenHS;
    document.getElementById('time-bill-detail').textContent = hoaDon_select.ThoiGian;
    document.getElementById('st-bill-detail').textContent = numberWithCommas(hoaDon_select.SoTien);
    document.getElementById('ghp-bill-detail').textContent = hoaDon_select.GiamHocPhi + '%';
    document.getElementById('stg-bill-detail').textContent = numberWithCommas(hoaDon_select.SoTienGiam);
    document.getElementById('stpd-bill-detail').textContent = numberWithCommas(hoaDon_select.SoTienPhaiDong);
    document.getElementById('stdd-bill-detail').textContent = numberWithCommas(hoaDon_select.SoTienDaDong);
    document.getElementById('npcl-bill-detail').textContent = numberWithCommas(hoaDon_select.NoPhiConLai);
    document.getElementById('status-bill-detail').textContent = hoaDon_select.TrangThai;
    var hp = 0;
    for (var i = 0; i < ds_hs_hocphi.length; i++) {
        if ((hoaDon_select.MaHS == ds_hs_hocphi[i].MaHS) && (hoaDon_select.MaLop == ds_hs_hocphi[i].MaLop))
            hp = ds_hs_hocphi[i].HocPhi;
    }
    document.getElementById('session-bill-detail').textContent = parseInt(hoaDon_select.SoTien / hp);
    if (hoaDon_select.TrangThai === 'Hoàn thành') {
        color = "green";
    }
    else if (hoaDon_select.TrangThai === 'Chưa đóng') { color = "red" }
    else { color = "blue" }
    document.getElementById('status-bill-detail').style.color = color;

    document.getElementById('mahd-delete').value = hoaDon_select.MaHD;
    document.getElementById('mahd-delete-2').value = hoaDon_select.MaHD;
    modalBg.style.display = 'block';


    // lich sử thu học phí

    // var lsthp = [];

    lsthp = [];
    var k = 0;
    for (var i = 0; i < ds_LS_THP.length; i++) {
        if (maHD_select == ds_LS_THP[i].MaHD)
            lsthp[k++] = ds_LS_THP[i];
    }

    document.getElementById('id-bill-lsthp').textContent = numberWithCommas(hoaDon_select.MaHD);
    document.getElementById('stpd-lsthp').textContent = numberWithCommas(hoaDon_select.SoTienPhaiDong);

    var tbody = document.getElementById('tbody-lsthp');

    // Xây dựng chuỗi HTML cho các hàng

    var rowsHTML = '';
    var tt = 0;
    if (lsthp.length != '0') {
        for (var i = 0; i < lsthp.length; i++) {
            var giaoDich = lsthp[i];
            rowsHTML += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + giaoDich.MaGD + '</td>' +
                // '<td class="thoi-gian">' + convertDateFormat(giaoDich.ThoiGian) + '</td>' +
                '<td> <input type="date" value ="' + giaoDich.ThoiGian + '" required>' + '</td>' +
                '<td  class="so-tien" pattern="[0-9,]+">' + numberWithCommas(giaoDich.SoTien) + '</td>' +
                '<td>' + '<button type ="button" id="edit-lsthp-btn" class="btn-edit-lsthp" onclick="editRow(' + i + ')" style ="background-color: rosybrown">Sửa</button>' +
                '<button type ="button" id="delete-lsthp-btn" class="btn-edit-lsthp" onclick="deleteRow(' + i + ')" style ="background-color: rebeccapurple">Xoá</button>' + '</td>' +
                '</tr>';
            tt += giaoDich.SoTien;
        }
        rowsHTML += '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
            '<td> Tổng tiền : </td>' +
            '<td id="total-amount-cell">' + numberWithCommas(tt) + '</td>' +
            '<td > <button  onclick="updateLSTHP()" class="btn-edit-lsthp"  id="btn-update-lsthp" style ="background-color: orangered">Cập nhật</button></td>' +
            '</tr>';

        rowsHTML += '<tr>' +
            '<td> </td>' +
            '<td> </td>' +
            '<td> Nợ phí còn lại : </td>' +
            '<td id="npcl-amount-cell">' + numberWithCommas(hoaDon_select.SoTienPhaiDong - tt) + '</td>' +
            '<td "></td>' +
            '</tr>'
    }
    else
        rowsHTML += '<td> <strong> Hóa đơn chưa có dữ liệu thanh toán  </strong> </td>'

    tbody.innerHTML = rowsHTML;

}


document.querySelector('.close-btn').addEventListener('click', () => {

    modalBg.style.display = 'none';

    document.getElementById('tbody-lsthp').innerHTML = '';

});

//Sua thong tin hoa don
const editButton = document.getElementById('edit-button');
const modalBgEdit = document.querySelector('.modal-bg-edit');
const modalContentEdit = document.querySelector('.modal-content-edit');

// Khi  nhấn vào nút "Sửa"

editButton.addEventListener('click', () => {

    var time = hoaDon_select.ThoiGian;
    var tt = hoaDon_select.TrangThai;
    numbers = time.split("/");

    var month = parseInt(numbers[0]);
    var year = parseInt(numbers[1]);

    var select = document.getElementById("month-bill-edit");
    for (var i = 0; i < select.options.length; i++) {
        var option = select.options[i];
        if (parseInt(option.value) === month) {
            option.selected = true;
        }
    }
    select = document.getElementById("year-bill-edit");
    for (var i = 0; i < select.options.length; i++) {
        var option = select.options[i];
        if (parseInt(option.value) === year) {
            option.selected = true;
        }
    }

    select = document.getElementById("status-bill-edit");
    for (var i = 0; i < select.options.length; i++) {
        var option = select.options[i];
        if (option.value == tt) {
            option.selected = true;
        }
    }


    document.getElementById('id-bill-edit').value = hoaDon_select.MaHD;
    document.getElementById('name-bill-edit').value = hoaDon_select.TenHD;
    document.getElementById('id-st-bill-edit').value = hoaDon_select.MaHS;
    document.getElementById('name-st-bill-edit').value = hoaDon_select.TenHS;
    document.getElementById('class-bill-edit').value = hoaDon_select.MaLop;
    document.getElementById('st-bill-edit').value = numberWithCommas(hoaDon_select.SoTien);

    document.getElementById('ghp-bill-edit').value = hoaDon_select.GiamHocPhi + '%';
    document.getElementById('stg-bill-edit').value = numberWithCommas(hoaDon_select.SoTienGiam);
    document.getElementById('stpd-bill-edit').value = numberWithCommas(hoaDon_select.SoTienPhaiDong);
    document.getElementById('stdd-bill-edit').value = numberWithCommas(hoaDon_select.SoTienDaDong);
    document.getElementById('npcl-bill-edit').value = numberWithCommas(hoaDon_select.NoPhiConLai);

    modalBgEdit.style.display = "block";

});

document.getElementById('btn-cancle-edit-bill').addEventListener('click', () => {
    modalBgEdit.style.display = 'none';

});

// Cap nhat sua hoa don
document.getElementById('update-bill-edit').addEventListener('click', function (event) {
    var check = true;
    event.preventDefault();
    const form = document.getElementById('form-edit-bill');

    var name = document.getElementById('name-bill-edit').value;


    if (!name) {
        document.getElementById('err-name-bill-edit').textContent = "*Chưa nhập tên hóa đơn";
        check = false;
    } else
        document.getElementById('err-name-bill-edit').textContent = "";


    if (!check)
        return;


    document.getElementById('tb1').innerHTML = "Cập nhật hóa đơn thành công! ";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});


// Xoa hoa don

document.getElementById('btn-delete-bill').addEventListener('click', () => {
    document.querySelector('.delete-bill-ques').style.display = 'block';
});

document.getElementById('btn-cancle-delete-bill').addEventListener('click', () => {
    document.querySelector('.delete-bill-ques').style.display = 'none';
});
document.getElementById('delete-bill').addEventListener('click', function (event) {

    const form = document.getElementById('form-delete-bill');

    event.preventDefault();

    document.querySelector('.delete-bill-ques').style.display = 'none';

    if (hoaDon_select.SoTienDaDong != 0) {
        document.querySelector('.delete-bill-ques-2').style.display = 'block';
        return;

    }

    document.querySelector('.delete-success').style.display = 'block';
    setTimeout(function () {
        document.querySelector('.delete-success').style.display = 'none';
        form.submit();
    }, 1500);

});

document.getElementById('btn-cancle-delete-bill-2').addEventListener('click', () => {
    document.querySelector('.delete-bill-ques-2').style.display = 'none';
});


document.getElementById('delete-bill-2').addEventListener('click', function (event) {

    const form = document.getElementById('form-delete-bill-2');

    event.preventDefault();

    document.querySelector('.delete-bill-ques-2').style.display = 'none';

    document.querySelector('.delete-success').style.display = 'block';
    setTimeout(function () {
        document.querySelector('.delete-success').style.display = 'none';
        form.submit();
    }, 1500);

});

// them giao dich
function checkDays() {
    var month = document.getElementById("month-add-trans").value;
    var year = document.getElementById("year-add-trans").value;
    var daySelect = document.getElementById("day-add-trans");

    while (daySelect.options.length > 0) {
        daySelect.remove(0);
    }
    var daysInMonth = new Date(year, month, 0).getDate();
    for (var i = 1; i <= daysInMonth; i++) {
        var option = document.createElement("option");
        option.text = i;
        option.value = i;
        daySelect.add(option);
    }
}

function formatNumber(input) {
    var value = input.value;
    value = value.replace(/[,\s]/g, '');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    input.value = value;
}

document.getElementById('btn-add-trans').addEventListener('click', () => {
    document.querySelector('#div-add-trans').style.display = 'block';
});

document.getElementById('form-add-trans').addEventListener('submit', function (event) {

    const form = document.getElementById('form-add-trans');
    var check = true;
    var formData = new FormData(this);
    event.preventDefault();



    const money = document.getElementById('money-add-trans').value;



    if (!money) {

        document.getElementById('lb-money-add-trans').textContent = "*Chưa nhập số tiền";
        check = false;
    } else
        document.getElementById('lb-money-add-trans').textContent = "";


    if (!check)
        return;
    document.getElementById('id-add-trans').value = hoaDon_select.MaHD;

    document.getElementById('tb1').innerHTML = "Đã thêm trạng giao dịch thành công !";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});

document.getElementById('canle-add-trans').addEventListener('click', () => {
    document.querySelector('#div-add-trans').style.display = 'none';
});

//sua lich su thu hoc phi
function editRow(index) {
    tbody = document.getElementById('tbody-lsthp');
    // var soTienCell = document.getElementsByClassName('so-tien')[index];
    var soTienCell = tbody.rows[index].querySelector(".so-tien");


    // Cho phép chỉnh sửa cột "Số tiền"
    var st = soTienCell.textContent;
    soTienCell.contentEditable = true;
    soTienCell.style.backgroundColor = '#f9f9f9';
    soTienCell.style.border = 'double';

    soTienCell.addEventListener('blur', function () {
        soTienCell.contentEditable = false;
        soTienCell.style.backgroundColor = '';
        soTienCell.style.border = '';
        var value = parseNumericValue(this.textContent);
        if (!value) {
            this.textContent = st;
        }
        else {
            this.textContent = numberWithCommas(value);
            updateTotalAmount();
        }
    });

}



//tt
function updateTotalAmount() {
    var totalAmount = 0;
    var soTienCells = document.getElementsByClassName('so-tien');

    for (var i = 0; i < soTienCells.length; i++) {
        var value = parseNumericValue(soTienCells[i].textContent);
        totalAmount += parseInt(value);
    }

    var totalAmountCell = document.getElementById('total-amount-cell');
    totalAmountCell.textContent = numberWithCommas(totalAmount);

    document.getElementById('npcl-amount-cell').textContent = numberWithCommas(parseNumericValue(document.getElementById('stpd-lsthp').textContent) - totalAmount);


}
//cap nhat lsthp
function getUpdateLSTHP() {
    var updatedData = [];

    tbody = document.getElementById('tbody-lsthp');
    var rows = tbody.querySelectorAll('tr');

    for (var i = 0; i < rows.length - 2; i++) {
        var row = rows[i];
        var inputs = row.getElementsByTagName('input');
        var maGD = row.cells[1].innerText;
        var ngay = inputs[0].value;
        var soTien = row.cells[3].innerText.replace(/,/g, '');

        updatedData.push({
            maGD: maGD,
            ngay: ngay,
            soTien: soTien
        });
    }

    return updatedData;
}

function updateLSTHP() {

    var selectedRows = Array.from(document.querySelectorAll('#tbody-lsthp input[type="checkbox"]:checked')).map(function (checkbox) {
        return checkbox.closest('tr');
    });

    // Remove the selected rows from the table
    selectedRows.forEach(function (row) {
        row.remove();
    });

    // Update the remaining rows' index
    var tbody = document.getElementById('tbody-lsthp');
    var rows = tbody.querySelectorAll('tr');
    rows.forEach(function (row, index) {
        row.cells[0].textContent = index + 1;
    });

    var updatedData = getUpdateLSTHP();


    var totalAmount = parseNumericValue(document.getElementById('total-amount-cell').textContent);
    var remainingFee = parseNumericValue(document.getElementById('npcl-amount-cell').textContent);



    // Convert the updatedData to a JSON string
    var jsonData = JSON.stringify(updatedData);

    // Create hidden input fields in the form to store the JSON data, total amount, and remaining fee
    var hiddenInputData = document.createElement('input');
    hiddenInputData.setAttribute('type', 'hidden');
    hiddenInputData.setAttribute('name', 'updatedData');
    hiddenInputData.setAttribute('value', jsonData);

    var hiddenInputTotalAmount = document.createElement('input');
    hiddenInputTotalAmount.setAttribute('type', 'hidden');
    hiddenInputTotalAmount.setAttribute('name', 'totalAmount');
    hiddenInputTotalAmount.setAttribute('value', totalAmount);

    var hiddenInputRemainingFee = document.createElement('input');
    hiddenInputRemainingFee.setAttribute('type', 'hidden');
    hiddenInputRemainingFee.setAttribute('name', 'remainingFee');
    hiddenInputRemainingFee.setAttribute('value', remainingFee);

    var maHD = parseNumericValue(document.getElementById('id-bill-lsthp').textContent);

    var hiddenInputmahd = document.createElement('input');
    hiddenInputmahd.setAttribute('type', 'hidden');
    hiddenInputmahd.setAttribute('name', 'maHD');
    hiddenInputmahd.setAttribute('value', maHD);


    var form = document.getElementById('form-edit-trans');
    form.appendChild(hiddenInputData);
    form.appendChild(hiddenInputTotalAmount);
    form.appendChild(hiddenInputRemainingFee);
    form.appendChild(hiddenInputmahd);



    document.getElementById('tb1').innerHTML = "Đã cập nhật thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);
    // Submit the form

}

// Xoa giao dich lsthp

function deleteRow(index) {
    document.querySelector('.delete-ques-trans').style.display = 'block';


    document.getElementById('delete-trans').addEventListener('click', () => {
        document.querySelector('.delete-ques-trans').style.display = 'none';
        tbody = document.getElementById('tbody-lsthp');
        tbody.deleteRow(index);

        var tt = parseNumericValue(document.getElementById('total-amount-cell').textContent);

        tt -= lsthp[index].SoTien;
        document.getElementById("total-amount-cell").textContent = numberWithCommas(tt);

        var remainingFee = hoaDon_select.SoTienPhaiDong - tt;
        document.getElementById("npcl-amount-cell").textContent = numberWithCommas(remainingFee);



        lsthp.splice(index, 1);
        var rows = tbody.querySelectorAll('tr');
        // rows.length -=1;
        for (var i = index; i < lsthp.length; i++) {
            var row = tbody.rows[i];
            // var row2 = tbody.rows[i];
            row.cells[0].textContent = i + 1;

            row.querySelector('#edit-lsthp-btn').setAttribute('onclick', 'editRow(' + i + ')');
            row.querySelector('#delete-lsthp-btn').setAttribute('onclick', 'deleteRow(' + i + ')');


        }

    });

    document.getElementById('btn-cancle-delete-trans').addEventListener('click', () => {
        document.querySelector('.delete-ques-trans').style.display = 'none';

    });




}

document.getElementById('delete-trans').addEventListener('click', function (event) {
    document.querySelector('.delete-ques-trans').style.display = 'none';

});

///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// Chi Phi ////////////////////////

document.getElementById('btn-tab2').addEventListener('mouseenter', () => {
    document.getElementById('nav-container-Tab2').style.display = 'block';
});
document.getElementById('btn-tab2').addEventListener('mouseleave', () => {
    document.getElementById('nav-container-Tab2').style.display = 'none';
});
document.getElementById('nav-container-Tab2').addEventListener('mouseenter', () => {
    document.getElementById('nav-container-Tab2').style.display = 'block';
});
document.getElementById('nav-container-Tab2').addEventListener('mouseleave', () => {
    document.getElementById('nav-container-Tab2').style.display = 'none';
});
