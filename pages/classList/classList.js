$(".class-living").onclick = ()=>{
    $(".class-living-list").classList.remove("class-disabled")
    $(".class-living").classList.add("active-btn")
    $(".class-done-list").classList.add("class-disabled")
    $(".class-done").classList.remove("active-btn")

}
$(".class-done").onclick = ()=>{
    $(".class-living-list").classList.add("class-disabled")
    $(".class-done-list").classList.remove("class-disabled")
    $(".class-living").classList.remove("active-btn")
    $(".class-done").classList.add("active-btn")
}
//init
$(".class-living-list").classList.remove("class-disabled")
$(".class-living").classList.add("active-btn")
$(".class-done-list").classList.add("class-disabled")
$(".class-done").classList.remove("active-btn")