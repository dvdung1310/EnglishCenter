


//so luong nguoi dung

var gv = countUser[0].SoLuong;
var hs = countUser[1].SoLuong;
var ph = countUser[2].SoLuong;
var countUsertOptions = {
    chart: {
        type: 'pie',
        height: 400,

    },
    series: [gv, hs, ph],
    labels: ['Giáo viên', 'Học sinh', 'Phụ huynh'],

}

// Tạo biểu đồ tròn
var userCountChart = new ApexCharts(document.querySelector("#countUserChart"), countUsertOptions);
userCountChart.render();


// so luong HS lien ket

var countHSlkOptions = {
    chart: {
        type: 'pie',
        height: 250,
    },
    series: [countHSlk[0].SoHS, countHSlk[1].SoHS - countHSlk[0].SoHS],
    labels: ['Học sinh đã liên kết', 'Học sinh chưa liên kết'],
    colors: ['#FFA500', '#00FF00'],
}

new ApexCharts(document.querySelector("#countHSlkChart"), countHSlkOptions).render();
// so luong PH lien ket
var countPHlkOptions = {
    chart: {
        type: 'pie',
        height: 250,
    },
    series: [countPHlk[0].SoPH, countPHlk[1].SoPH - countPHlk[0].SoPH],
    labels: ['Phụ huynh đã liên kết', 'Phụ huynh chưa liên kết'],
    colors: ['#FFA500', '#00FF00'],
}

new ApexCharts(document.querySelector("#countPHlkChart"), countPHlkOptions).render();

////////////////////
var chart_classActiveChar = null;

var countLopHD_year = [];
var SoLop = [];


filterByYear(new Date().getFullYear());
filterCountLopDong(new Date().getFullYear())

createclassActiveChart();
function createclassActiveChart() {
    var labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

    var ctx = document.getElementById('classActiveChart').getContext('2d');
    if (chart_classActiveChar) {
        chart_classActiveChar.destroy();
    }
    chart_classActiveChar = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Lớp hoạt động',
                data: countLopHD_year,
                backgroundColor: 'rgba(75, 192, 192, 0.5)', // Màu nền cột 1
                borderColor: 'rgba(75, 192, 192, 1)', // Màu viền cột 1
                borderWidth: 1
            }, {
                label: 'Lớp đóng',
                data: SoLop,
                backgroundColor: 'rgba(255, 99, 132, 0.5)', // Màu nền cột 2
                borderColor: 'rgba(255, 99, 132, 1)', // Màu viền cột 2
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Tháng'
                    }
                },
                y: {
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Số lượng'
                    },
                    ticks: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ số lượng lớp thay đổi theo tháng',
                    position: 'bottom',
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                        color: '#333333'
                    }

                }
            }
        }

    });

}










var selectYear = document.getElementById('select-year');
selectYear.addEventListener('change', function () {

    var currentYear = selectYear.value;
    filterByYear(currentYear);
    filterCountLopDong(currentYear);

    createclassActiveChart();

});

/// ds lop hoat dong theo nam
function filterByYear(year) {
    countLopHD_year = [];
    countLopHD_year = Array.from({ length: 12 }, () => 0);

    countLopHD.forEach(function (item) {
        if (item.Nam == year) {
            countLopHD_year[item.Thang - 1] = item.SoLop;
        }
    });

}


// loc so luong lop dong theo thang
function filterCountLopDong(year) {
    SoLop = [];
    for (var month = 1; month <= 12; month++) {
        var previousMonth = month - 1;
        if (previousMonth == 0) {
            previousMonth = 12;
        }
        var currentMonthData = ds_LopHD.filter(function (item) {
            return item.Thang == month && item.Nam == year;
        });

        var previousMonthData = ds_LopHD.filter(function (item) {
            if (previousMonth == 12) {
                return item.Thang == previousMonth && item.Nam == year - 1;

            }
            else
                return item.Thang == previousMonth && item.Nam == year;

        });

        var count = 0;

        for (var i = 0; i < previousMonthData.length; i++) {
            var existsInCurrentMonth = currentMonthData.some(function (item) {

                return item.MaLop == previousMonthData[i].MaLop;
            });
            if (!existsInCurrentMonth) {

                count++;

            }


        }
        if ((month > (new Date().getMonth() + 1)) && (year == (new Date().getFullYear()))) {
            count = 0;
        }
        SoLop.push(count);
    }
}

//////////
var tt = countGender[0].so + countGender[1].so;
document.getElementById('total-student').innerHTML = 'Tổng số học viên : ' + tt + ' học viên';

//biểu đồ tỷ lệ học viên Nam/Nữ


var genderChart = new Chart(document.getElementById('genderChart'), {
    type: 'pie',
    data: {
        labels: ['Nam', 'Nữ'],
        datasets: [{
            data: [countGender[1].so, countGender[0].so],
            backgroundColor: ['#3498db', '#e74c3c'],
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Tỷ lệ nam/nữ',
            fontSize: 18,
        },
        plugins: {
            title: {
                display: true,
                text: 'Tỷ lệ giới tính học viên',
                position: 'bottom',
                font: {
                    family: 'Arial',
                    size: 18,
                    weight: 'bold',
                    color: '#333333'
                }

            }
        }
    }


});
///
// theo do tuoi

var countAgeFiltered = [];
var age_16 = 0;
for (var i = 6; i < 16; i++) {

    var item = countAge.find(function (element) {
        if (element.Tuoi >= 16)
            age_16++;
        else
            return element.Tuoi === i;

    });

    if (item) {
        countAgeFiltered.push(item.so);
    } else {
        countAgeFiltered.push(0);
    }
}
countAgeFiltered.push(age_16);




var ageData = {
    labels: ['6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16+'],
    datasets: [
        {
            label: 'Số lượng học sinh',
            data: countAgeFiltered,
            backgroundColor: 'rgba(0, 123, 255, 0.5)',
            borderColor: 'rgba(0, 123, 255, 1)',
            borderWidth: 1,
        }
    ]
};

var ageOptions = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            beginAtZero: true,
            title: {
                display: true,
                text: 'Số lượng học viên'
            }
        },
        x: {
            title: {
                display: true,

            }
        }
    },
    plugins: {
        title: {
            display: true,
            text: 'Độ tuổi học viên',
            position: 'bottom',
            font: {
                family: 'Arial',
                size: 18,
                weight: 'bold',
                color: '#333333'
            }

        }
    }

};

// Tạo biểu đồ cột
var ageChart = new Chart(document.getElementById('ageChart'), {
    type: 'bar',
    data: ageData,
    options: ageOptions
});


////
// bieu do tang giam hoc sinh
var chart_StudentChar = null;

var tongSoHS = [];

var soHSDKHoc = [];
var soHSKHoc = [];

var selectedYear = new Date().getFullYear();
filterByYear_Hs(new Date().getFullYear());
countTotal();

soHSKHoc = tongSoHS.map((value, index) => value - soHSDKHoc[index]);


createStudentChar();


function createStudentChar() {
    var data = {
        labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
        total: tongSoHS,
        hocDiHoc: soHSDKHoc,
        hocKhongHoc: soHSKHoc
    };

    // Vẽ biểu đồ
    var ctx = document.getElementById("studentChart").getContext("2d");
    if (chart_StudentChar) {
        chart_StudentChar.destroy();
    }
    chart_StudentChar = new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.labels,
            datasets: [
                {
                    type: "bar",
                    label: "Tổng số học sinh",
                    data: data.total,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                },
                {
                    type: "line",
                    label: "Số học sinh đăng ký học",
                    data: data.hocDiHoc,
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    fill: false
                },
                {
                    type: "line",
                    label: "Số học sinh không không đăng ký học",
                    data: data.hocKhongHoc,
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 2,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ số lượng học viên',
                    position: 'bottom',
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                        color: '#333333'
                    }

                }
            }
        }
    });

}



function filterByYear_Hs(year) {
    var currentMonth = new Date().getMonth() + 1;

    var currentYear = new Date().getFullYear();
    if(year == currentYear){
        soHSDKHoc = Array.from({ length: currentMonth }, () => 0);

    }
    else{
        soHSDKHoc = Array.from({ length: 12 }, () => 0);
    }
   

    ds_DangKyHoc.forEach(function (item) {
        if (item.Nam == year) {
            soHSDKHoc[item.Thang - 1] = item.so;
        }
    });

}

var selectYear_hs = document.getElementById('select-year-hs');
selectYear_hs.addEventListener('change', function () {
    selectedYear = selectYear_hs.value;
    filterByYear_Hs(selectedYear);
    countTotal();
    soHSKHoc = tongSoHS.map((value, index) => value - soHSDKHoc[index]);
    createStudentChar();
});


function countTotal() {
    tongSoHS = [];


    for (var i = 1; i <= 12; i++) {
        var monthData = {
            Thang: i,
            Nam: selectedYear,
            so: 0
        };


        var s = 0;
        for (var j = 0; j < ds_HSTang.length; j++) {
            if (((monthData.Thang >= ds_HSTang[j].Thang) && (monthData.Nam == ds_HSTang[j].Nam)) || (monthData.Nam > ds_HSTang[j].Nam)) {
                s += ds_HSTang[j].so;
            }
        }

    
        var currentMonth = new Date().getMonth() + 1;

        var currentYear = new Date().getFullYear();

        if( ((monthData.Thang > currentMonth) && (monthData.Nam == currentYear)) || (monthData.Nam > currentYear)){
            s = 0;
        }
        monthData.so = s;

        tongSoHS.push(monthData.so);
    }
}
/////////////
///Ty le hoc sinh nghi hoc



var countHSDHOptions = {
    chart: {
        type: 'pie',
        height: 350,
    },
    series: [ds_HSDD[0].so, ds_HSDD[1].so],
    labels: ['Tham gia', 'Nghỉ học'],
    colors: ['#6fd332', '#cdb089'],
}

new ApexCharts(document.querySelector("#absentChart"), countHSDHOptions).render();








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



var today = new Date();
var day = today.getDate();
var month = today.getMonth() + 1;
var year = today.getFullYear();
var currentDate = day + '-' + month + '-' + year;

var html = '<h3> Tính đến ngày ' + currentDate + ' :</h3> <br>';
html += '<ul> <li> Tổng số lớp đã mở : ' + (ds_tongLop[0].so + ds_tongLop[1].so) + '</li>  ';
html += ' <li> Tổng số lớp đang hoạt động : ' + ds_tongLop[0].so + '</li>  ';
html += '<li> Tổng số lớp đã hoàn thành : ' + ds_tongLop[1].so + '</li>  </ul>';





document.getElementById('class-detail').innerHTML = html;











// Mặc định hiển thị tab đầu tiên

document.getElementById("btn-tab1").classList.add("active");



document.getElementById('btn-tab2').addEventListener('click', () => {
    window.location.href = "./manageStatisticalFinance.php";

});


document.getElementById('btn-tab1').addEventListener('click', () => {
    window.location.href = "./manageStatistical.php";

});