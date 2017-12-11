$(document).ready(function () { 
    wH = window.screen.availHeight - $('.top_header').height() - $('.menu-gradient').height() - $('.footer').height()
    $('#main_cont').css('min-height',wH+'px')

    $(document).on('change','input[type="file"]',function(){
        var fileName = $(this).val().split('\\').pop() || 'Selezionare un file'
        $(this).next('label').eq('0').text(fileName)
    })
})