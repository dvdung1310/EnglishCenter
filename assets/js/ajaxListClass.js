$(document).ready(function () {
  
    // lắng nghe sự kiện changes của province select box
    $('#province').on('change', function () {
        var province_id = $(this).val(); // this có nghĩa là đang ở province còn val là value của cái option đó
        $.post('ajax_get_listClass.php',{idSelect:province_id},function(idSelect){
            $('.class-container').html(idSelect);
       })

       var txt = $('.timkiem').val();
       var data = {
        key: txt,
        province_id: province_id
      };

      $.post('ajax_get_searchClass.php',{data:data},function(response){
        $('.class-container').html(response);
   })


    })

    $('.timkiem').keyup(function(){
        var txt = $('.timkiem').val();
        var province_id = $('#province').val();
        console.log(province_id);
        var data = {
            key: txt,
            province_id: province_id
          };
        $.post('ajax_get_searchClass.php',{data:data},function(response){
             $('.class-container').html(response);
        })
    })
})

