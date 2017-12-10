$(document).ready(function () { 
    wH = window.screen.availHeight - $('.top_header').height() - $('.menu-gradient').height() - $('.footer').height()
    console.log($('.top_header').height())
    console.log($('.menu-gradient').height())
    console.log($('.footer').height())
    $('#main_cont').css('min-height',wH+'px')
})