
function convertDateFormat(dateString) {
    var dateParts = dateString.split("-");
    var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    return formattedDate;
}

function parseCustomDateFormat(dateString, format) {
    var parts = dateString.split('-');
    if (parts.length !== 3) return NaN;

    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10) - 1;
    var year = parseInt(parts[2], 10);

    return new Date(year, month, day);
}



// Mặc định hiển thị tab đầu tiên
document.getElementById("Tab1").style.display = "block";
document.getElementById("btn-tab2").classList.add("active");

document.getElementById("Tab1-add").style.display = "block";
document.getElementById("btn-tab1-add").classList.add("active");




// var a = Math.round(203000/100*24.123);

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
//Hiẹn thị bảng
var filteredData_ds = dsHoaDon;
hienthids('', filteredData_ds);

function hienthids(status,filteredData) {
    filteredData_ds = [];
    document.querySelector(".tbody-1").innerHTML = '';
    document.querySelector(".tbody-5").innerHTML = '';
    // var filteredData = dsHoaDon;
    if (status) {
        // filteredData = dsHoaDon.filter(function (hoaDon) {
        //     return hoaDon['TrangThai'] === status;
        // });
        filteredData = dsHoaDon.filter(function (hoaDon) {
            return hoaDon['TrangThai'] === status;
        });
    }
    if(filteredData.length ==0)
    {
        document.querySelector(".tbody-1").innerHTML = 'Không có dữ liệu phù hợp';
    }
    filteredData_ds = filteredData;

    var html = ''; var html_last = '';
    var color = '';
    var tongSoTien = 0; var tienChuaTT = 0;  var tienDaTT =0;var dem1 =0; var dem0 =0;
    if (filteredData.length != 0) {
        for (var i = 0; i < filteredData.length; i++) {
            if (filteredData[i]['TrangThai'] === 'Đã thanh toán') {
                color = "lightgreen";
                tienDaTT += filteredData[i]['SoTien'];
               
                dem1++;
            }
            else { color = "#ff9393";
            tienChuaTT += filteredData[i]['SoTien'];
            dem0++;
        }
            // else { color = "#bcbdff" }

            html += '<tr onclick="handleRowClick(' + i + ')">';
            html += '<td style="width:20px ;background-color:' + color + '">' + (i + 1) + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['MaLuong'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TenHD'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['MaGV'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TenGV'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['Lop'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['ThoiGian'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + numberWithCommas(filteredData[i]['SoTien']) + '</td>';

            if (filteredData[i]['ThoiGianTT'] != null) {
                html += '<td style = "background-color:' + color + '">' + convertDateFormat(filteredData[i]['ThoiGianTT']) + '</td>';
            }
            else {
                html += '<td style = "background-color:' + color + '">' + '' + '</td>';
            }

            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TrangThai'] + '</td>';

            html += '</tr>';
            

            tongSoTien += filteredData[i]['SoTien'];
        }

        html_last += '<tr>';
        html_last += '<td style="width:20px ;  ">'  + '</td>';
        html_last += '<td >' +  '</td>';
        html_last += '<td >' +  '</td>';
        html_last += '<td >' +  '</td>';   
        html_last += '<td >' +  '</td>'; 
        html_last += '<td >' +  '</td>'; 
        html_last += '<td >' + 'Tổng : </td>';
        html_last += '<td >' + numberWithCommas(tongSoTien) + '</td>';
        html_last += '<td >' + 'Đã thanh toán :  </td>';
        html_last += '<td >'  +  numberWithCommas(tienDaTT)+'('+ dem1+') </td>';

        html_last += '</tr>';
        html_last += '<tr>';
        html_last += '<td style="width:20px ;  ">'  + '</td>';
        html_last += '<td >' +  '</td>';
        html_last += '<td >' +  '</td>';
        html_last += '<td >' +  '</td>';   
        html_last += '<td >' +  '</td>'; 
        html_last += '<td >' +  '</td>'; 
        html_last += '<td >' + '</td>';
        html_last += '<td >' + '</td>';
        html_last += '<td >' + 'Chưa thanh toán :  </td>';
        html_last += '<td >'  +  numberWithCommas(tienChuaTT)+'('+ dem0+') </td>';

        html_last += '</tr>';
        document.querySelector(".tbody-1").innerHTML = html;
        document.querySelector(".tbody-5").innerHTML = html_last;
    }
}



var selectStatus = document.getElementById('select-status');
selectStatus.addEventListener('change', function () {
    var selectedStatus = selectStatus.value;
    hienthids(selectedStatus, filteredData_ds);
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


        if (columnIndex === 1 || columnIndex === 2 || columnIndex === 3 || columnIndex === 4 || columnIndex === 5 || columnIndex === 9) {
            if (sortDirection[columnIndex] === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        }
        else
            if (columnIndex === 0) {

                return;
            } else if (columnIndex === 6) {
                var aDate = parseDateValue(aValue);
                var bDate = parseDateValue(bValue);

                if (sortDirection[columnIndex] === 'asc') {
                    return aDate - bDate;
                } else {
                    return bDate - aDate;
                }
            } else if (columnIndex === 8) {

                if (aValue === '' && bValue !== '') {
                    return 1;
                } else if (aValue !== '' && bValue === '') {
                    return -1;
                } else if (aValue === '' && bValue === '') {
                    return 0;
                }

                var aDate = parseCustomDateFormat(aValue, 'd-m-y');
                var bDate = parseCustomDateFormat(bValue, 'd-m-y');

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



function openTab_add(evt, tabName) {
    var i, tabcontent, tablinks;


    tabcontent = document.getElementsByClassName("tabcontent-add");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }


    tablinks = document.getElementsByClassName("tablinks-add");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }


    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}


// Them hoa don

const modalBgAdd = document.querySelector('.modal-bg-add');
const modalContentAdd = document.querySelector('.modal-content-add');

document.querySelector('.add-bill-button').addEventListener('click', () => {
    modalBgAdd.style.display = 'block';
})


// thay doi selection chọn giáo viên
var monthSelect = document.getElementById("bill-month-add");
var yearSelect = document.getElementById("bill-year-add");
var teacherSelect = document.getElementById("bill-teacher-add");

monthSelect.addEventListener("change", updateTeacherOptions);
yearSelect.addEventListener("change", updateTeacherOptions);
var addedTeachers = [];
// Hàm cập nhật các giá trị trong select bill-teacher-add
function updateTeacherOptions() {
    // Lấy giá trị tháng và năm được chọn
    var selectedMonth = monthSelect.value;
    var selectedYear = yearSelect.value;
    var check = true;

    if (inputsValue.length != 0) {
        inputs.forEach(input => outputDiv.removeChild(input));
        inputs = [];
        inputsValue = [];
    }
    // Xóa tất cả các option hiện tại trong select bill-teacher-add
    while (teacherSelect.options.length > 0) {
        teacherSelect.remove(0);
    }

    // Add default option
    var defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Chọn Giáo viên';
    teacherSelect.appendChild(defaultOption);

    // Tạo mảng tạm thời để lưu trữ các giáo viên đã được thêm vào select bill-teacher-add
    addedTeachers = [];
    // Lặp qua các bản ghi trong dsgv_lopxdd
    for (var i = 0; i < dsgv_lopxdd.length; i++) {
        var diemdanh = dsgv_lopxdd[i];
        var diemdanhMonth = parseInt(diemdanh.ThoiGian.split("-")[1]);
        var diemdanhYear = parseInt(diemdanh.ThoiGian.split("-")[0]);

        // Kiểm tra xem bản ghi đang xét có cùng tháng và năm được chọn hay không
        if ((diemdanhMonth == selectedMonth) && (diemdanhYear == selectedYear)) {

            var teacher = {
                MaGV: diemdanh.MaGV,
                TenGV: diemdanh.TenGV
            };

            // Kiểm tra xem giáo viên đã tồn tại trong mảng tạm thời hay chưa
            var isTeacherAdded = addedTeachers.some(function (addedTeacher) {
                return addedTeacher.MaGV === teacher.MaGV && addedTeacher.TenGV === teacher.TenGV;
            });

            if (!isTeacherAdded && check) {
                var defaultOption = document.createElement('option');
                defaultOption.value = 'all';
                defaultOption.textContent = 'Tất cả';
                teacherSelect.appendChild(defaultOption);
                check = false;
            }

            // Nếu giáo viên chưa tồn tại trong mảng tạm thời, thêm giáo viên và option tương ứng
            if (!isTeacherAdded) {
                addedTeachers.push(teacher);
                var option = document.createElement("option");
                option.value = teacher.MaGV + '.' + teacher.TenGV;
                option.text = teacher.MaGV + " - " + teacher.TenGV;
                teacherSelect.add(option);
            }
        }
    }
}




// class
const select = document.getElementById("bill-teacher-add");
const outputDiv = document.getElementById("div-bill-class-add");
const options_All = document.querySelectorAll('#bill-teacher-add option');

var inputs = [];
var inputsValue = [];



select.addEventListener("change", (event) => {
    // Xóa input đã chọn nếu có
    var check = true;
    const selectedOption = event.target.value;

    if (selectedOption == 'all') {
        inputs.forEach(input => outputDiv.removeChild(input));
        inputs = [];
        inputsValue = [];
        const options_All = addedTeachers;
        for (var i = 0; i < options_All.length; i++) {
            const input = document.createElement('input');
            input.type = 'text';

            input.value = options_All[i].MaGV + '.' + options_All[i].TenGV;
            input.setAttribute('readonly', 'readonly');


            inputsValue.push(options_All[i].MaGV);
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

            var parts = selectedOption.split(".");
            inputsValue.push(parseInt(parts[0]));
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

        document.getElementById('lb-class-add').textContent = "*Chưa chọn giáo viên";
        check = false;
    } else
        document.getElementById('lb-class-add').textContent = "";

    document.getElementById('teacher-add-bill').value = inputsValue;

    if (!check)
        return;
    document.getElementById('tb1').innerHTML = "Đã thêm lương giáo viên tháng " + month_bill + "/" + year_bill + " thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form1.submit();
    }, 1500);
});


// Thêm hóa đơn cá nhân
var classSelect = document.getElementById("bill-teacher-add-ps");
var studentSelect = document.getElementById("name-student-add-bill");
//ds giáo viên
var inputText = document.getElementById("name-teacher-add-bill");
var teacherListElement = document.getElementById("teacher-list");

// Xử lý sự kiện khi nhấn vào một li trong danh sách
teacherListElement.addEventListener("click", function (event) {
    var clickedTeacher = event.target.textContent;

    teacherListElement.innerHTML = "";

    var parts = clickedTeacher.split(".");
    inputText.value = parts[1];
    document.getElementById('name-teacher-s').value = parseInt(parts[0]);
});

// Hàm lọc và hiển thị danh sách giáo viên
function filterTeachers() {
    // Lấy giá trị từ input text
    var inputValue = inputText.value.toLowerCase();
    if (!inputValue) {
        teacherListElement.innerHTML = "";
    }
    else {
        // Lọc danh sách giáo viên dựa trên tên
        var filteredTeachers = dsgv.filter(function (teacher) {
            return teacher.TenGV.toLowerCase().includes(inputValue);
        });

        // Hiển thị kết quả lọc
        teacherListElement.innerHTML = "";

        // Tạo phần tử li cho mỗi giáo viên
        filteredTeachers.forEach(function (teacher) {
            var liElement = document.createElement("li");
            liElement.textContent = teacher.MaGV + '.' + teacher.TenGV;
            teacherListElement.appendChild(liElement);
        });
    }
}

function formatNumber(input) {
    let value = input.value;
    // Xóa tất cả ký tự không phải là số và dấu phẩy
    value = value.replace(/[^\d,]/g, '');
    // Xóa dấu phẩy hiện có
    value = value.replace(/,/g, '');
    // Thêm dấu phẩy sau mỗi ba chữ số
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    input.value = value;
}



document.getElementById('money-add-bill').addEventListener('blur', function () {


    var value = parseNumericValue(this.value);

    if (!value) {
        this.value = '';
    }
    else {
        this.value = numberWithCommas(value);

    }

});


document.getElementById('sumit-bill-add-ps').addEventListener('click', function (event) {

    var check = true;


    const form1 = document.getElementById('form-add-bill-ps');
    event.preventDefault();
    const name_bill = document.getElementById('bill-name-add-ps').value;

    const name_teacher = document.getElementById('name-teacher-add-bill').value;
    const money = document.getElementById('money-add-bill').value;




    //Kiểm tra dữ liệu nhập vào

    if (!name_bill) {
        document.getElementById('lb-name-add-ps').textContent = "*Chưa nhập tên hóa đơn";
        check = false;
    } else
        document.getElementById('lb-name-add-ps').textContent = "";
    var check_name = false;
    for (var i = 0; i < dsgv.length; i++) {
        if (dsgv[i].TenGV == document.getElementById('name-teacher-add-bill').value) {
            check_name = true;
        }
    }
    if (!name_teacher) {
        document.getElementById('lb-class-add-ps').textContent = "*Chưa nhập tên giáo viên ";
        check = false;
    } else if (!check_name) {

        document.getElementById('lb-class-add-ps').textContent = "Nhập sai tên";
        check = false;
    }
    else
        document.getElementById('lb-class-add-ps').textContent = '';

    if (!money) {
        document.getElementById('lb-money-add-ps').textContent = "*Chưa số tiền";
        check = false;
    } else
        document.getElementById('lb-money-add-ps').textContent = "";

    if (!check)
        return;


    document.getElementById('tb1').innerHTML = "Đã thêm hóa đơn " + name_bill + " của giáo  viên " + name_teacher + " thành công! ";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form1.submit();
    }, 1500);
});

//thong tin chi tiet hoa don

const rows = document.querySelectorAll('.tbody-1 tr');
const modalBg = document.querySelector('.modal-bg');
const modalContent = document.querySelector('.modal-content');

const select_tt = document.getElementById('status-detail');
var maHD_select;
var hoaDon_select;

var lsthp = [];
function handleRowClick(index) {
    // Xử lý sự kiện khi bấm vào một dòng
    // var selectedRow = rows[index].cells[1];
    
    var selectedRow = filteredData_ds[index];


    document.getElementById("btn-tab-3-1").classList.add("active");

    document.getElementById("tab-3-1").style.display = 'block';



    maHD_select = selectedRow.MaLuong;

    for (var i = 0; i < dsHoaDon.length; i++) {
        if (maHD_select == dsHoaDon[i].MaLuong)
            hoaDon_select = dsHoaDon[i];
    }

    document.getElementById('id-bill-detail').textContent = maHD_select;
    document.getElementById('name-bill-detail').textContent = hoaDon_select.TenHD;
    // document.getElementById('class-bill-detail').textContent = hoaDon_select.Lop;
    document.getElementById('id-st-detail').textContent = hoaDon_select.MaGV;
    document.getElementById('name-st-bill-detail').textContent = hoaDon_select.TenGV;
    document.getElementById('time-bill-detail').textContent = hoaDon_select.ThoiGian;
    document.getElementById('st-bill-detail').textContent = numberWithCommas(hoaDon_select.SoTien);
    if (hoaDon_select.ThoiGianTT !=null)
        document.getElementById('time-tt-bill-detail').textContent = convertDateFormat(hoaDon_select.ThoiGianTT);
    else{
        document.getElementById('time-tt-bill-detail').textContent = '';

    }
  
    var tt = hoaDon_select.TrangThai;

    if (tt == 'Đã thanh toán') {
        select_tt.value = 'Đã thanh toán';
        select_tt.style.color = 'green';
    }
    else {
        select_tt.value = 'Chưa thanh toán';
        select_tt.style.color = 'red';

    }

    var parts = hoaDon_select.ThoiGian.split("/");
    var month = parts[0]; // "7"
    var year = parts[1];
    var html = '';
    if (hoaDon_select.Lop != null) {


        for (var i = 0; i < dssoBuoiDay.length; i++) {
            if (dssoBuoiDay[i].MaGV == hoaDon_select.MaGV && dssoBuoiDay[i].Thang == month && dssoBuoiDay[i].Nam == year) {
                html += dssoBuoiDay[i].MaLop + ': ' + dssoBuoiDay[i].SoBuoiDay + ' buổi             (' + numberWithCommas(dssoBuoiDay[i].TienTraGV) + ' / buổi)' + '<br>';
            }
        }
    }

    document.getElementById('class-bill-detail').innerHTML = html;


    document.getElementById('mahd-delete').value = hoaDon_select.MaLuong;
    document.getElementById('mahd-delete-2').value = hoaDon_select.MaLuong;
    modalBg.style.display = 'block';



}

select_tt.addEventListener("change", function () {
    if (select_tt.value == 'Đã thanh toán')
        select_tt.style.color = 'green';
    else
        select_tt.style.color = 'red';
});

// cap nhat trang thai hoa don

document.getElementById('update-tt').addEventListener('click', function (event) {


    const form = document.getElementById('form-update-status');

    event.preventDefault();

    document.getElementById('tb1').innerHTML = "Đã cập nhật trạng thái  thành công! ";
    document.getElementById('id-wage').value = maHD_select;
    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});

document.querySelector('.close-btn').addEventListener('click', () => {

    modalBg.style.display = 'none';



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

    if (hoaDon_select.TrangThai == 'Đã thanh toán') {
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



document.getElementById('btn-tab1').addEventListener('click', () => {
    window.location.href = "./manageFinance.php";

});


document.getElementById('btn-tab3').addEventListener('click', () => {
    window.location.href = "./manageHistoryFinance.php";

});
