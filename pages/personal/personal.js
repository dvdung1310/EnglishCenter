// initial setup
var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)

var isEdit = false
const editBtn = $(".edit-info")

$$(".personal-inner-value").forEach(item=>{
    item.classList.add("personal-act-inline")
})
const inputdata = {
    name:"",
    email:"",
    phone:"",
}
//func chuyển dạng
const onChangeEditType = (type,opt)=>{
    isEdit = type
    
    if(isEdit){
        $$(`.personal-inner-value-${opt}`).forEach((item)=>{
            item.classList.remove("personal-act-inline")
        })
        $(`.control-${opt}`).classList.add("personal-act-flex")
        $$(`.personal-inner-edit-range-${opt}`).forEach((item)=>{
            item.classList.add("personal-active")
        })
        // khởi tạo giá trị của input khi chuyển sang dạng edit
        if(opt==="info"){
            console.log("active")
            $("#name-input").value =$("#name").textContent
            $("#email-input").value =$("#email").textContent
            $("#phone-input").value =$("#phone").textContent
        }
    }
    else{
        $$(`.personal-inner-edit-range-${opt}`).forEach((item)=>{
            item.classList.remove("personal-active")
        })
        $$(`.personal-inner-value-${opt}`).forEach((item)=>{
            item.classList.add("personal-act-inline")
        })
        $(`.control-${opt}`).classList.remove("personal-act-flex")
    }
}

editBtn.onclick = ()=>{
    onChangeEditType(!isEdit,"info")
}

$(".edit-pass").onclick = ()=>{
    onChangeEditType(!isEdit,"pass")
}

$(".info-cancel").onclick = ()=>{
onChangeEditType(false,"info")
}
$(".password-cancel").onclick = ()=>{
onChangeEditType(false,"pass")
}