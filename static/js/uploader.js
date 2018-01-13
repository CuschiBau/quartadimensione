$(document).ready(function () { 
    
    $(document).on('change','.gameSelector',function(){
        if($(this).val() == 'other') $('#newGameInfo').removeClass('hide')
        else $('#newGameInfo').addClass('hide')
    })

    $(document).on('change','#changeLeague',function(){
        $('.changeLeagueBtn').click();
    })

    if($('.gameSelector option').length == 1){ $('#newGameInfo').removeClass('hide') }
    if($('#changeLeague option').length == 1 && window.location.href.indexOf('lega=') == -1){ $('.changeLeagueBtn').click(); }    

})