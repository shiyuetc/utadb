$(function () {
  $("#icon").on({
    "click": function () {
      $(this).addClass("animated pulse");
    },
    "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend": function () {
      $(this).removeClass("animated pulse");
    }
  });
});