$(document).ready(function () {

    var mH = 0
    $('.menu_lists .item-cont').each(function(){
        console.log($(this).height())
        if($(this).height() > mH) mH = $(this).height()
    })
    $('.menu_lists').height(mH+'px')

    $(document).on('click','.menu_selector',function(){
        $('.item-cont').each(function(){$(this).addClass('hide')})
        $($(this).data('selector')).removeClass('hide')
        $('.menu_selector').each(function(){$(this).removeClass('selected_menu')})
        $(this).addClass('selected_menu')
    })

})