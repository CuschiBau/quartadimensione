$(document).ready(function () {
  $("#cards_slider").slick({
    variableWidth: true,
    infinite: false,
    slidesToShow: 1,
    focusOnSelect: true,
    slidesToScroll: 1,
    initialSlide: 2,
    arrows: false,
    centerMode: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 320,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  });

  $(document).on('click','.orari',function(){
    if($(this).hasClass('mobile')) {
      $('.times_body').css('height','215px')
      $('.dove_siamo .box_body').css('padding-top','75px')
    }
    else $('.times_body').css('left','50%')
  })

  $(document).on('click','.close_times',function(){
    if($(this).hasClass('mobile')) {
      $('.times_body').css('height','0')
      $('.dove_siamo .box_body').css('padding-top','50px')
    }
    else $('.times_body').css('left','0')
  })

})