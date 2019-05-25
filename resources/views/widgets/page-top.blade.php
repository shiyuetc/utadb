<p id="page-top"><a href="#wrap"><i class="far fa-arrow-alt-circle-up fa-3x"></i></a></p>

<script type="text/javascript">
  $(function () {
    var showFlag = false;
    var topBtn = $('#page-top');
    topBtn.css('bottom', '-100px');
    var showFlag = false;
    $(window).scroll(function () {
      if ($(this).scrollTop() > 500) {
        if (!showFlag) {
          showFlag = true;
          topBtn.stop().animate({
            'bottom': '20px'
          }, 200);
        }
      } else {
        if (showFlag) {
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
</script>