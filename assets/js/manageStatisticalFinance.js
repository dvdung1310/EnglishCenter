

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
                        size: 18,
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


// function countTotal() {
//     tongSoHS = [];
    

//     for (var i = 1; i <= 12; i++) {
//         var monthData = {
//             Thang: i,
//             Nam: selectedYear_1,
//             so: 0
//         };


//         var s = 0;
//         for (var j = 0; j < ds_HSTang.length; j++) {
//             if (((monthData.Thang >= ds_HSTang[j].Thang) && (monthData.Nam == ds_HSTang[j].Nam)) || (monthData.Nam > ds_HSTang[j].Nam)) {
//                 s += ds_HSTang[j].so;
//             }
//         }
//         monthData.so = s;

//         tongSoHS.push(monthData.so);
//     }
// }









// Mặc định hiển thị tab đầu tiên

document.getElementById("btn-tab2").classList.add("active");
document.getElementById('btn-tab2').addEventListener('click', () => {
    window.location.href = "./manageStatisticalFinance.php";

});




// var a = Math.round(203000/100*24.123);

function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}







function formatNumber(input) {
    let value = input.value;
 
    value = value.replace(/[^\d,]/g, '');

    value = value.replace(/,/g, '');

    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    input.value = value;
}





