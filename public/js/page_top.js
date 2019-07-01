$(function () {
  var showFlag = false;
  var topBtn = $('#page-top');
  var showFlag = false;
  $(window).scroll(function () {
    if($(this).scrollTop() > 500) {
      if(!showFlag) {
        showFlag = true;
        topBtn.stop().animate({
          'bottom': '12px'
        }, 200);
      }
    } else {
      if(showFlag) {
        showFlag = false;
        topBtn.stop().animate({
          'bottom': '-100px'
        }, 200);
      }
    }
  });
  topBtn.click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });
});