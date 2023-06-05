
    // thông báo xóa lớp
    const delete_class = document.getElementById('delete');
    delete_class.addEventListener('click', function(event) {
        const form = document.getElementById('form_delete')
        event.preventDefault();

        document.querySelector('.delete-Option').style.display = 'block';
        const yesDelete = document.getElementById('yesDelete');
        const noDelete = document.getElementById('noDelete');

        yesDelete.addEventListener('click', function(event) {
            document.querySelector('.delete-Option').style.display = 'none';
            document.querySelector('.delete-success').style.display = 'block';
            setTimeout(function() {
                // document.querySelector('.delete-Option').style.display = 'none';
                form.submit();
            }, 1000);
        });

        noDelete.addEventListener('click', function(event) {
            document.querySelector('.delete-Option').style.display = 'none';
        });
    });


    // sửa lớp nào
    // hiển thị box chính
    const openBtn = document.getElementById('open-btn');
    const overlay = document.getElementById('overlay');
    const box = document.getElementById('box');
    const closeBtn = document.getElementById('close-btn');

    openBtn.addEventListener('click', () => {
        overlay.classList.add('active');
        box.classList.add('active');
    });

    closeBtn.addEventListener('click', () => {
        overlay.classList.remove('active');
        box.classList.remove('active');
    });


    // sửa lớp tiếp nào baby
    const submit_update = document.getElementById('update');
    submit_update.addEventListener('click', function(event) {
        const formUpadte = document.getElementById('form_edit');
        event.preventDefault();
        const classcode = document.getElementById('classcode').value;
        const classname = document.getElementById('classname').value;
        const classAge = document.getElementById('classAge').value;
        const classTimeOpen = document.getElementById('classTimeOpen').value;
        const price = document.getElementById('price').value;
        const numberlessons = document.getElementById('numberlessons').value;
        const students = document.getElementById('students').value;
        const teachers = document.getElementById('teachers').value;
        const TeacherSalarie = document.getElementById('TeacherSalarie').value;

        const element0 = document.getElementById('schedules0');
        console.log(element0);
        const idSchedules0 = element0 ? element0.value : "";
        console.log(idSchedules0);
        var element1 = document.getElementById('schedules1');
        if (element1 === null) {
            element1 = 1;
        }
        const idSchedules1 = element1 ? element1.value : "";


        const element2 = document.getElementById('schedules2');
        console.log(element2);
        const idSchedules2 = element2 ? element2.value : "";
        // kiểm tra dữ liệu nhập vào
        var erorr_empty = "*Dữ liệu không để trống";
        if (!classcode) {
            document.getElementById('lbclasscode').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbclasscode').textContent = "";

        if (!classname) {
            document.getElementById('lbclassname').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbclassname').textContent = "";

        if (!classAge) {
            document.getElementById('lbclassAge').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbclassAge').textContent = "";

        if (!classTimeOpen) {
            document.getElementById('lbclassTimeOpen').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbclassTimeOpen').textContent = "";

        if (idSchedules0 === idSchedules1 || idSchedules0 === idSchedules2 || idSchedules2 === idSchedules1) {
            document.getElementById('lbschedules').textContent = '*Lịch học trùng nhau';
            return;
        } else {
            document.getElementById('lbschedules').textContent = "";
        }

        if (!price) {
            document.getElementById('lbprice').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbprice').textContent = "";

        if (!numberlessons) {
            document.getElementById('lbnumberlessons').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbnumberlessons').textContent = "";
        if (!students) {
            document.getElementById('lbstudents').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbstudents').textContent = "";

        if (!teachers) {
            document.getElementById('lbteacher').textContent = erorr_empty;
            return;
        } else
            document.getElementById('lbteacher').textContent = "";
        
            if (!TeacherSalarie) {
                document.getElementById('lbTeacherSalarie').textContent = erorr_empty;
                return;
            } else
                document.getElementById('lbTeacherSalarie').textContent = "";
         

        document.querySelector('.update-success').style.display = 'block';
        document.querySelector('#overlay').style.position = 'fixed';

        setTimeout(function() {
            document.querySelector('.update-success').style.display = 'none';
            formUpadte.submit();
        }, 1000);
    });


    // hiện danh boxStudents
    const openBtnlistStudents = document.getElementById('opten-listStudents');
    const overlayStudent = document.getElementById('overlayStudent');
    const boxStudent = document.getElementById('boxStudent');
    const closebtnstudents = document.getElementById('closebtnstudents');

    openBtnlistStudents.addEventListener('click', () => {
        overlayStudent.classList.add('active');
        boxStudent.classList.add('active');
    });

    closebtnstudents.addEventListener('click', () => {
        overlayStudent.classList.remove('active');
        boxStudent.classList.remove('active');
    });

    // hiện boxAttendance điểm danh
   
    const openBtnlistAttendance = document.getElementById('opten-listAttendance');
    const overlayAttendance = document.getElementById('overlayAttendance');
    const boxAttendance = document.getElementById('boxAttendance');
    const closebtnAttendance = document.getElementById('closebtnAttendance');

    openBtnlistAttendance.addEventListener('click', () => {
        overlayAttendance.classList.add('active');
        boxAttendance.classList.add('active');
    });

    closebtnAttendance.addEventListener('click', () => {
        overlayAttendance.classList.remove('active');
        boxAttendance.classList.remove('active');
    });


    // thêm dấu phẩy nhé
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}