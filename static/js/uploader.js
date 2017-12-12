$(document).ready(function () { 
    
    $(document).on('change','.gameSelector',function(){
        if($(this).val() == 'other') $('#newGameInfo').removeClass('hide')
        else $('#newGameInfo').addClass('hide')
    })

    $(document).on('change','#changeLeague',function(){
        $('.changeLeagueBtn').click();
    })

})