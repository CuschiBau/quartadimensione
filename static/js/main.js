$(document).ready(function () { 
    wH = $(window).height() - $('.top_header').height() - $('.menu-gradient').height() - $('.footer').height() - 20
    $('#main_cont').css('min-height',wH+'px')

    $(document).on('change','input[type="file"]',function(){
        var fileName = $(this).val().split('\\').pop() || 'Selezionare un file'
        $(this).next('label').eq('0').text(fileName)
    })
})