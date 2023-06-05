//slick setup
$('.introSlider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.introNavigation',
  prevArrow: $('.intro-control-prev'),
  nextArrow: $(".intro-control-next-wrap"),

});
$('.introNavigation').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.introSlider',
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  prevArrow: $('.intro-control-prev'),
  nextArrow: $(".intro-control-next-wrap"),
});
$('.teacherSlider').slick({
  infinite:true,
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows:true,
  centerMode:true,
  autoplay:true,
  focusOnSelect:true,
  prevArrow:$('.teacher-control-left'),
  nextArrow:$(".teacher-control-right"),
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
        infinite: true,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    }
  ]
});
$('.instructSlider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.instructNavigation',
  prevArrow: $('.instruct-control-prev'),
  nextArrow: $(".instruct-control-next-wrap"),

});
$('.instructNavigation').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.instructSlider',
  dots: false,
  centerMode: true,
  focusOnSelect: true,
  prevArrow: $('.instruct-control-prev'),
  nextArrow: $(".instruct-control-next-wrap"),
});

$('.courseSlider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.instructNavigation',
  prevArrow: $('.course-control-prev'),
  nextArrow: $(".course-control-next-wrap"),

});
// initial setup
var $ = document.querySelector.bind(document)
var $$ = document.querySelectorAll.bind(document)
//getDataFromFile
function getDataFromFile(element,list,func){
  const listHTML = list.map(item=>{
    return func(item)
  })

  if($(element))
  $(element).innerHTML = listHTML.join("")
}
//homeIntro

// console.log($(".intro-control-icon-prev"))
// $(".intro-control-icon-prev").onClick = function(){
//   console.log("next")
//   $(".slider-for").slick("slickPrev")
// }
// $(".intro-control-icon-next").onClick = ()=>{
//   $(".slider-for").slick("slickNext")
// }

//vision
var collapseElementList = [].slice.call(document.querySelectorAll('.collapse'))
var collapseImgList = [].slice.call(document.querySelectorAll('.vision-img-wrap'))

const visionBtn = $$(".vision-btn")
const btnArr = Array.from(visionBtn)
 btnArr.forEach((item,i)=>{
   item.onclick=()=>{
    btnArr.forEach(item=>{
      item.classList.remove("vision-active")
    })
    collapseElementList.forEach((collapse,idx)=>{
      console.log("idx",idx)
      collapse.classList.remove("show")
      if(idx!=i){
        collapseImgList[idx].classList.remove("on-show")
      }
      else{
        console.log(collapseImgList[idx])
        collapseImgList[idx].classList.add("on-show")

      }
    })
    collapseImgList[i].classList.add("on-show")
    item.classList.add("vision-active")
    } 
  })
//teacher-home
