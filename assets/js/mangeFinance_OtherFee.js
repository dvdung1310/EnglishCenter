
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





// var a = Math.round(203000/100*24.123);

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
//Hiẹn thị bảng
var filteredData = dsHoaDon;
hienthids('', '');
function hienthids(status, kind) {

    if (status && kind) {

        filteredData_1 = dsHoaDon.filter(function (hoaDon) {
            return hoaDon['TrangThai'] === status;
        });

        filteredData = filteredData_1.filter(function (hoaDon) {
            return hoaDon['LoaiHD'] === kind;
        });
    }
    else {
        if (kind) {
            filteredData = dsHoaDon.filter(function (hoaDon) {
                return hoaDon['LoaiHD'] === kind;
            });
        }
        else if (status) {
            filteredData = dsHoaDon.filter(function (hoaDon) {
                return hoaDon['TrangThai'] === status;
            });
        }
    }

    var html = '';var html_last = '';
    var color = '';
    var tongSoTien = 0; 
    if (filteredData.length != 0) {
        for (var i = 0; i < filteredData.length; i++) {
            if (filteredData[i]['TrangThai'] === 'Đã thanh toán') {
                color = "lightgreen";
            }
            else { color = "#ff9393" }
            // else { color = "#bcbdff" }

            html += '<tr onclick="handleRowClick(' + i + ')">';
            html += '<td style="width:20px ;background-color:' + color + '">' + (i + 1) + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['MaHD'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['TenHD'] + '</td>';
            html += '<td style = "background-color:' + color + '">' + filteredData[i]['LoaiHD'] + '</td>';
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
        html_last += '<td >' + 'Tổng : </td>';
        html_last += '<td >' + numberWithCommas(tongSoTien) + '</td>';
        html_last += '<td >' +  '</td>';
        html_last += '<td >'  + '</td>';
        html_last += '</tr>';

        document.querySelector(".tbody-1").innerHTML = html;
        document.querySelector(".tbody-5").innerHTML = html_last;
    }
}



var selectKind = document.getElementById('select-kind-bill');
var selectStatus = document.getElementById('select-status');
var check_status = false;
var check_kind = false;
var selectedKind = '';
var selectedStatus = '';
selectStatus.addEventListener('change', function () {
    selectedStatus = selectStatus.value;

    hienthids(selectedStatus, selectedKind);

});


selectKind.addEventListener('change', function () {
    selectedKind = selectKind.value;

    hienthids(selectedStatus, selectedKind);
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


        if (columnIndex === 1 || columnIndex === 2 || columnIndex === 3 || columnIndex === 7) {
            if (sortDirection[columnIndex] === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        }
        else
            if (columnIndex === 0) {

                return;
            } else if (columnIndex === 4) {
                var aDate = parseDateValue(aValue);
                var bDate = parseDateValue(bValue);

                if (sortDirection[columnIndex] === 'asc') {
                    return aDate - bDate;
                } else {
                    return bDate - aDate;
                }
            } else if (columnIndex === 4 || columnIndex === 6) {

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

document.querySelector('.btn-close-add').addEventListener('click', () => {
    modalBgAdd.style.display = 'none';
   
        document.getElementById('lb-name-add').textContent = "";

            document.getElementById('lb-time-add').textContent = "";

    
        document.getElementById('lb-kind-add').textContent = "";
   
        document.getElementById('lb-money-add').textContent = "";
})


// Khi nhấn tao

document.getElementById('sumit-bill-add').addEventListener('click', function (event) {
    var check = true;
    const form1 = document.getElementById('form-add-bill')
    event.preventDefault();
    const name_bill = document.getElementById('bill-name-add').value;
    const month_bill = document.getElementById('bill-month-add').value;
    const year_bill = document.getElementById('bill-year-add').value;
    const kind_bill = document.getElementById('bill-kind-add').value;
    const money = document.getElementById('money-add-bill').value;


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
    if (!kind_bill) {

        document.getElementById('lb-kind-add').textContent = "*Chưa chọn loại hóa đơn";
        check = false;
    } else
        document.getElementById('lb-kind-add').textContent = "";
    if (!money) {

        document.getElementById('lb-money-add').textContent = "*Chưa ghi số tiền";
        check = false;
    } else
        document.getElementById('lb-money-add').textContent = "";




    if (!check)
        return;
    document.getElementById('tb1').innerHTML = 'Đã thêm hóa đơn "' + name_bill + '"' + " thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form1.submit();
    }, 1500);
});




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

    var selectedRow = filteredData[index];


    document.getElementById("btn-tab-3-1").classList.add("active");

    document.getElementById("tab-3-1").style.display = 'block';



    maHD_select = selectedRow.MaHD;



    for (var i = 0; i < dsHoaDon.length; i++) {

        if (maHD_select == dsHoaDon[i].MaHD)
            hoaDon_select = dsHoaDon[i];
    }

    document.getElementById('id-bill-detail').textContent = maHD_select;
    document.getElementById('name-bill-detail').textContent = hoaDon_select.TenHD;
    document.getElementById('kind-bill-detail').textContent = hoaDon_select.LoaiHD;

    document.getElementById('time-bill-detail').textContent = hoaDon_select.ThoiGian;

    document.getElementById('st-bill-detail').textContent = numberWithCommas(hoaDon_select.SoTien);


    if (hoaDon_select.ThoiGianTT != null)
        document.getElementById('time-tt-bill-detail').textContent = convertDateFormat(hoaDon_select.ThoiGianTT);
    else {
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




    document.getElementById('mahd-delete').value = hoaDon_select.MaHD;
    document.getElementById('mahd-delete-2').value = hoaDon_select.MaHD;
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
    document.getElementById('id-fee').value = maHD_select;
    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});

document.querySelector('.close-btn').addEventListener('click', () => {

    modalBg.style.display = 'none';



});

////Sua thong tin hoa don
const editButton = document.getElementById('edit-button');


const modalBgEdit = document.querySelector('.modal-bg-edit');
const modalContentEdit = document.querySelector('.modal-content-edit');

// Khi  nhấn vào nút "Sửa"
editButton.addEventListener('click', () => {


        var time = hoaDon_select.ThoiGian;
        var tt = hoaDon_select.TrangThai;
        var kind =  hoaDon_select.LoaiHD;
        numbers = time.split("/");

    
        var month = parseInt(numbers[0]);
        var year = parseInt(numbers[1]);
    
        var select = document.getElementById("bill-month-edit");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (parseInt(option.value) === month) {
                option.selected = true;
            }
        }
        select = document.getElementById("bill-year-edit");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (parseInt(option.value) === year) {
                option.selected = true;
            }
        }
    
        select = document.getElementById("bill-status-edit");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.value == tt) {
                option.selected = true;
            }
        }

        select = document.getElementById("bill-kind-edit");
        for (var i = 0; i < select.options.length; i++) {
            var option = select.options[i];
            if (option.value == kind) {
                option.selected = true;
            }
        }
    


    document.getElementById('id-bill-edit').value = maHD_select;
    document.getElementById('bill-name-edit').value = hoaDon_select.TenHD;
;

    document.getElementById('money-edit-bill').value = numberWithCommas(hoaDon_select.SoTien);


    if (hoaDon_select.ThoiGianTT != null)
        document.getElementById('time-tt-edit-bill').value = hoaDon_select.ThoiGianTT;
    // else {
    //     document.getElementById('time-tt-edit-bill').value = '';

    // }

    

    modalBgEdit.style.display = "block";



});

document.querySelector('.cancle-btn').addEventListener('click', () => {
    modalBgEdit.style.display = 'none';
    
        document.getElementById('lb-name-edit').textContent = "";

 
            document.getElementById('lb-time-edit').textContent = "";


        document.getElementById('lb-kind-edit').textContent = "";
   
        document.getElementById('lb-money-edit').textContent = "";

    
            document.getElementById('lb-time-tt-edit').textContent = "";

    

});

// Cap nhat sua hoa don
document.getElementById('update-bill-edit').addEventListener('click', function (event) {
    var check = true;
    const form1 = document.getElementById('form-edit-bill')
    event.preventDefault();
    const name_bill = document.getElementById('bill-name-edit').value;
    const month_bill = document.getElementById('bill-month-edit').value;
    const year_bill = document.getElementById('bill-year-edit').value;
    const kind_bill = document.getElementById('bill-kind-edit').value;
    const money = document.getElementById('money-edit-bill').value;
    const time_tt = document.getElementById('time-tt-edit-bill').value;
    const status = document.getElementById('bill-status-edit').value;


    //Kiểm tra dữ liệu nhập vào

    if (!name_bill) {
        document.getElementById('lb-name-edit').textContent = "*Chưa nhập tên hóa đơn";
        check = false;
    } else
        document.getElementById('lb-name-edit').textContent = "";

    if (!month_bill) {
        document.getElementById('lb-time-edit').textContent = "*Chưa chọn thời gian";
        check = false;
    } else {

        if (!year_bill) {
            document.getElementById('lb-time-edit').textContent = "*Chưa chọn thời gian";
            check = false;
        } else
            document.getElementById('lb-time-edit').textContent = "";

    }
    if (!kind_bill) {

        document.getElementById('lb-kind-edit').textContent = "*Chưa chọn loại hóa đơn";
        check = false;
    } else
        document.getElementById('lb-kind-edit').textContent = "";
    if (!money) {

        document.getElementById('lb-money-edit').textContent = "*Chưa ghi số tiền";
        check = false;
    } else
        document.getElementById('lb-money-edit').textContent = "";

    if(status == 'Đã thanh toán'){
        if (!time_tt) {

            document.getElementById('lb-time-tt-edit').textContent = "*Chưa cập nhật thời gian thanh toán";
            check = false;
        } else
            document.getElementById('lb-time-tt-edit').textContent = "";

    }
   




    if (!check)
        return;

    document.getElementById('tb1').innerHTML = 'Đã cập nhật sửa đổi  hóa đơn "' + name_bill + '"' + " thành công!";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form1.submit();
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




