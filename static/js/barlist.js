$(document).ready(function () {

    $(".menu_lists").slick({
        arrows: false
    });

    $(document).on('click','.menu_selector',function(){
        $(".menu_lists").slick('slickGoTo', $(this).data('selector'))       
        $('.menu_selector').each(function(){$(this).removeClass('selected_menu')})
        $(this).addClass('selected_menu') 
    })

    $('.menu_lists').on('swipe', function(event, slick, direction){
        var c = $(this).slick('slickCurrentSlide')
        $('.menu_selector').each(function(){$(this).removeClass('selected_menu')})
        $('.menu_selector[data-selector="'+c+'"]').addClass('selected_menu') 
      });

})
