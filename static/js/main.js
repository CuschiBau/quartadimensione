$(document).ready(function () { 
    // wH = $(window).height() - $('.top_header').height() - $('.menu-gradient').height() - $('.footer').height() - 20
    // $('#main_cont').css('min-height',wH+'px')

    $(document).on('change','input[type="file"]',function(){
        var fileName = $(this).val().split('\\').pop() || 'Selezionare un file'
        $(this).next('label').eq('0').text(fileName)
    })

    $(document).on('click','.menu_icon_cont',function(){
        var ac = parseInt($('.menu-gradient').css('top').replace('px','')) 
        if(ac > 0) $('.menu-gradient').css('top',0)
        else $('.menu-gradient').css('top',$('.top_header').height()+'px')
    })

})