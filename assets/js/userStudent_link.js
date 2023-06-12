document.getElementById('btn-link').addEventListener('click', function (event) {
    var check = true;
    var check_value = false;
    var check_has = false;

    event.preventDefault();

    const form = document.getElementById('form-link');

    var maph = document.getElementById('maPH-link').value;

    for (var i = 0; i < ds_ph.length; i++) {
        if (ds_ph[i].MaPH == maph) {
            var check_has = true;
        }
    }

    for (var i = 0; i < ds_maPH.length; i++) {
        if (ds_maPH[i].MaPH == maph) {
            check_value = true;
            document.getElementById('name-parent').value = ds_maPH[i].TenPH;
        }
    }
    if (!maph) {
        document.getElementById('err').textContent = "Chưa nhập mã phụ huynh";
        check = false;
    } else if (check_has) {
        document.getElementById('err').textContent = "Phụ huynh này đã liên kết";
        check = false;
    } else if (!check_value) {
        document.getElementById('err').textContent = "Mã phụ huynh không chính xác";
        check = false;
    } else
        document.getElementById('err').textContent = "";

    if (!check)
        return;

    document.getElementById('tb1').innerHTML = "Đã gửi yêu cầu liên kết !";

    document.querySelector('.add-success').style.display = 'block';

    setTimeout(function () {
        document.querySelector('.add-success').style.display = 'none';
        form.submit();
    }, 1500);

});


///
var button = document.getElementById('btn-nofi');
var hiddenDiv = document.getElementById('div-nofi');

button.addEventListener('click', function() {
    hiddenDiv.style.display = hiddenDiv.style.display === 'block' ? 'none' : 'block';
 
});


var divNofiContainer = document.getElementById('div-nofi');

ds_yeuCau.forEach(function(yeuCau) {

  var nofiDiv = document.createElement('div');
  nofiDiv.id = 'nofi';
  nofiDiv.innerHTML = '<p>Phụ huynh ' + yeuCau.TenPH + ' đã gửi yêu cầu liên kết với bạn</p>' +
                      '<button onclick="tuChoi(' + yeuCau.MaHS + ',' + yeuCau.MaPH + ')">Từ chối</button>' +
                      '<button onclick="chapNhan(' + yeuCau.MaHS + ',' + yeuCau.MaPH + ')">Chấp nhận</button>';

  divNofiContainer.appendChild(nofiDiv);
});

function tuChoi(maHS, maPH) {
    var form = document.createElement('form');

    form.method = 'POST';
      form.name = 'refuse-form'
   
    var input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'refuse-maPH';
    input.value = maPH;
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
  input.name = 'accept-maPH';
  input.value = maPH;
  form.appendChild(input);

  document.body.appendChild(form);
  form.submit();
}