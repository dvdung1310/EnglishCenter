

// bieu do tang giam hoc sinh
var chart_doanhthu = null;

var doanhThu = [];
var thu = [];
var chi = [];

var selectedYear_1 = new Date().getFullYear();
filterByYear_1(new Date().getFullYear());

doanhThu = thu.map((value, index) => value - chi[index]);

createStudentChar();


function createStudentChar() {
    var data = {
        labels: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
        total: doanhThu,
        soThu: thu,
        soChi: chi,
    };

    // Vẽ biểu đồ
    var ctx = document.getElementById("chart-1").getContext("2d");
    if (chart_doanhthu) {
        chart_doanhthu.destroy();
    }
    chart_doanhthu = new Chart(ctx, {
        type: "bar",
        data: {
            labels: data.labels,
            datasets: [
                {
                    type: "bar",
                    label: "Doanh thu",
                    data: data.total,
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                },
                {
                    type: "line",
                    label: "Chi",
                    data: data.soChi,
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    fill: false
                },
                {
                    type: "line",
                    label: "Thu",
                    data: data.soThu,
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
                    text: 'Biểu đồ thu chi hàng tháng',
                    position: 'bottom',
                    font: {
                        family: 'Arial',
                        size: 22,
                        weight: 'bold',
                        color: '#333333'
                    }

                }
            }
        }
    });

}



function filterByYear_1(year) {
    thu = Array.from({ length: 12 }, () => 0);
    chi = Array.from({ length: 12 }, () => 0);
    ds_countThu.forEach(function (item) {
        if (item.Nam == year) {
            thu[item.Thang - 1] = item.SoTien;
        }
    });
    ds_countChi.forEach(function (item) {
        if (item.Nam == year) {
            chi[item.Thang - 1] = item.SoTien;
        }
    });

}

var selectYear_1 = document.getElementById('select-year-1');
selectYear_1.addEventListener('change', function () {
    selectedYear_1 = selectYear_1.value;
    filterByYear_1(selectedYear_1);

    doanhThu = thu.map((value, index) => value - chi[index]);
    createStudentChar();
});
///////////////////////////////////////////////////////////






var tongDoanhThu = [];
var tyLeLoiNhuan = [];
var dtThang12 = 0;
var selectedYear_2 = new Date().getFullYear();

countTotal(tongDoanhThu);
tinhTyLeLoiNhuan(tyLeLoiNhuan, tongDoanhThu);

createDoanhThuChart(tongDoanhThu, tyLeLoiNhuan);


function countTotal(tongDoanhThu) {
    tongDoanhThu.length = 0;
    dtThang12 = 0;

    for (var i = 1; i <= 12; i++) {
        var monthData = {
            Thang: i,
            Nam: selectedYear_2,
            so: 0
        };



        var s = 0;
        for (var j = 0; j < ds_DTTheoThang.length; j++) {
            if (((monthData.Thang >= ds_DTTheoThang[j].Thang) && (monthData.Nam == ds_DTTheoThang[j].Nam)) || (monthData.Nam > ds_DTTheoThang[j].Nam)) {
                s += parseInt(ds_DTTheoThang[j].SoTien);

            }
        }
        monthData.so = s;
        tongDoanhThu.push(monthData.so);
    }
    for (var k = 0; k < ds_DTTheoThang.length; k++) {
        if (((12 >= ds_DTTheoThang[k].Thang) && (monthData.Nam - 1 == ds_DTTheoThang[k].Nam)) || (monthData.Nam - 1 > ds_DTTheoThang[k].Nam)) {
            dtThang12 += parseInt(ds_DTTheoThang[k].SoTien);

        }
    }
}





function tinhTyLeLoiNhuan(tyLeLoiNhuan, tongDoanhThu) {
    tyLeLoiNhuan.length = 0



    // Tính tỷ lệ lợi nhuận của tháng 1 n

    if (dtThang12 == 0) {
        tyLeLoiNhuan.push(parseFloat(0).toFixed(2));
    }
    else {
        var tyLeThang1 = ((tongDoanhThu[0] - dtThang12) / dtThang12) * 100;


        tyLeLoiNhuan.push(tyLeThang1.toFixed(2));
    }
    for (var i = 1; i < tongDoanhThu.length; i++) {

        var doanhThuHienTai = tongDoanhThu[i];
        var doanhThuTruoc = tongDoanhThu[i - 1];
        if (doanhThuTruoc == 0 && doanhThuHienTai == 0) {
            tyLeLoiNhuan.push(parseFloat(0).toFixed(2));
        }
        else if (doanhThuTruoc == 0 && doanhThuHienTai != 0) {
            tyLeLoiNhuan.push(parseFloat(100).toFixed(2));
        }
        else {
            if (doanhThuTruoc < 0 && doanhThuHienTai < 0) {
                var tyLe = (-((doanhThuHienTai - doanhThuTruoc) / doanhThuTruoc)) * 100;
            }
            else
                var tyLe = ((doanhThuHienTai - doanhThuTruoc) / doanhThuTruoc) * 100;
            tyLeLoiNhuan.push(parseFloat(tyLe).toFixed(2));
        }
    }
}



function createDoanhThuChart(tongDoanhThu, tyLeLoiNhuan) {


    var chartData = {
        chart: {
            type: 'area',
            height: 700
        },
        series: [
            {
                name: 'Tổng doanh thu',
                data: tongDoanhThu
            },
            {
                name: 'Tỷ lệ lợi nhuận',
                data: tyLeLoiNhuan
            }
        ],
        xaxis: {
            categories: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']
        },
        yaxis: [
            {
                title: {
                    text: 'Tổng doanh thu (VND)'
                }
            },
            {
                opposite: true,
                title: {
                    text: 'Tỷ lệ lợi nhuận (%) '
                }
            }
        ],
        fill: {
            type: 'solid',
            opacity: [0.7, 0.5],


        }
    };


    var chart = new ApexCharts(document.querySelector("#chart-2"), chartData);
    chart.render();

}


var selectYear_2 = document.getElementById('select-year-2');
selectYear_2.addEventListener('change', function () {
    selectedYear_2 = selectYear_2.value;
    countTotal(tongDoanhThu);
    tinhTyLeLoiNhuan(tyLeLoiNhuan, tongDoanhThu);

    createDoanhThuChart(tongDoanhThu, tyLeLoiNhuan);
    console.log(tyLeLoiNhuan);
    console.log(tongDoanhThu);

});
///////////

var thuChiChart = null;
setChart(new Date().getFullYear());

var selectYear_3 = document.getElementById('select-year-3');
selectYear_3.addEventListener('change', function () {
    selectedYear_3 = selectYear_3.value;
    setChart(selectedYear_3);

});

function setChart(year) {
    var thu = 0;
    var chi = 0;

    for (var i = 0; i < ds_Thu.length; i++) {
        if (year == ds_Thu[i].Nam) {
            thu = parseInt(ds_Thu[i].SoTien);
        }
    }
    for (var j = 0; j < ds_Chi.length; j++) {
        if (year == ds_Chi[j].Nam) {
            chi = parseInt(ds_Chi[j].SoTien);
        }
    }

    createThuChiChart(thu, chi);
}





function createThuChiChart(thu, chi) {

    var data = {
        labels: ['Thu', 'Chi'],
        datasets: [{
            data: [thu, chi],
            backgroundColor: ['#11d66e', '#ff5c5c']
        }]
    };

    var ctx = document.getElementById('chart-3').getContext('2d');

    if (thuChiChart) {
        thuChiChart.destroy();
    }
    thuChiChart = new Chart(ctx, {
        type: 'pie',
        data: data,
        options: {
            title: {
                display: true,
                text: 'Tỷ lệ thu / chi'
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Biểu đồ thu chi hàng năm',
                    position: 'bottom',
                    font: {
                        family: 'Arial',
                        size: 18,
                        weight: 'bold',
                       
                    }
                }
            }
        }
    });

}


// Mặc định hiển thị tab đầu tiên

document.getElementById("btn-tab2").classList.add("active");
document.getElementById('btn-tab2').addEventListener('click', () => {
    window.location.href = "./manageStatisticalFinance.php";

});

document.getElementById('btn-tab1').addEventListener('click', () => {
    window.location.href = "./manageStatistical.php";

});







