function convertDateFormat(dateString) {
    var dateParts = dateString.split("-");
    var formattedDate = dateParts[2] + "-" + dateParts[1] + "-" + dateParts[0];
    return formattedDate;
}
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function parseDateValue(value) {
    var parts = value.split('/');
    var month = parseInt(parts[0]);
    var year = parseInt(parts[1]);
    return new Date(year, month - 1);
}
function parseNumericValue(value) {
    return parseInt(value.replace(/,/g, ''));
}

function parseCustomDateFormat(dateString, format) {
    var parts = dateString.split('-');
    if (parts.length !== 3) return NaN;

    var day = parseInt(parts[0], 10);
    var month = parseInt(parts[1], 10) - 1;
    var year = parseInt(parts[2], 10);

    return new Date(year, month, day);
}

var filteredData= dsHoaDon;
hienthids();

function hienthids() {

    document.querySelector(".tbody-1").innerHTML = '';
    document.querySelector(".tbody-5").innerHTML = '';

    if(filteredData.length ==0)
    {
        document.querySelector(".tbody-1").innerHTML = 'Không có dữ liệu phù hợp';
        return;
    }


    var html = ''; var html_last = '';

    var tongSoTien = 0; 
    if (filteredData.length != 0) {
        for (var i = 0; i < filteredData.length; i++) {
      
            html += '<tr>';
            html += '<td style="width:20px ">' + (i + 1) + '</td>';
            html += '<td >' + filteredData[i]['MaLuong'] + '</td>';
            html += '<td >' + filteredData[i]['TenHD'] + '</td>';
            html += '<td >' + filteredData[i]['ThoiGian'] + '</td>';
            var parts = filteredData[i]['ThoiGian'].split("/");
            var month = parts[0]; // "7"
            var year = parts[1];
            var html_lop = '';
            for (var j = 0; j < dssoBuoiDay.length; j++) {
                if (dssoBuoiDay[j].MaGV == MaGV && dssoBuoiDay[j].Thang == month && dssoBuoiDay[j].Nam == year) {
                    html_lop += dssoBuoiDay[j].MaLop + ': ' + dssoBuoiDay[j].SoBuoiDay + 'buổi          (' + numberWithCommas(dssoBuoiDay[i].TienTraGV) + ' / buổi)' + '<br>';
                }
            }
        
            html += '<td >' + html_lop + '</td>';
            html += '<td >' + convertDateFormat(filteredData[i]['ThoiGianTT'])+ '</td>';
            html += '<td >' + numberWithCommas(filteredData[i]['SoTien']) + '</td>'
            html += '</tr>';
            tongSoTien += filteredData[i]['SoTien'];
        }

        html_last += '<tr>';
        html_last += '<td style="width:20px ;  ">'  + '</td>';
        html_last += '<td >' +  '</td>';  
        html_last += '<td >' +  '</td>'; 
        html_last += '<td >'  + '</td>';

        html_last += '<td >' +  '</td>'; 
        html_last += '<td >' + 'Tổng : </td>';
        html_last += '<td >' + numberWithCommas(tongSoTien) + '</td>';
   
   
        html_last += '</tr>';
        document.querySelector(".tbody-1").innerHTML = html;
        document.querySelector(".tbody-5").innerHTML = html_last;
    }
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


        if (columnIndex === 1 || columnIndex === 2 || columnIndex === 4 ) {
            if (sortDirection[columnIndex] === 'asc') {
                return aValue.localeCompare(bValue);
            } else {
                return bValue.localeCompare(aValue);
            }
        }
        else
            if (columnIndex === 0) {

                return;
            } else if (columnIndex === 3) {
                var aDate = parseDateValue(aValue);
                var bDate = parseDateValue(bValue);

                if (sortDirection[columnIndex] === 'asc') {
                    return aDate - bDate;
                } else {
                    return bDate - aDate;
                }
            } else if (columnIndex === 5) {

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
    sortIcon.src = '../../assets/images/arrow-up-down-bold-icon.png';
    sortIcon.style.width = '20px';
    sortIcon.style.backgroundColor = 'white';
    sortIcon.style.borderRadius = '30px';
    if (sortDirection[columnIndex] === 'asc') {
        sortIcon.style.transform = 'rotate(180deg)';
    }
    clickedHeader.appendChild(sortIcon);
}