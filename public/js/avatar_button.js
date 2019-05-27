document.getElementById("avatar-button").onclick = function () {
  var dialog = $("#nav-dialog");
  if (dialog.hasClass("active")) {
    dialog.fadeOut('fast');
  } else {
    dialog.fadeIn('fast');
  }
  dialog.toggleClass("active");
  $("#avatar-button").parent().toggleClass("active");
};
document.getElementById("avatar-button").onblur = function () {
  var dialog = $("#nav-dialog");
  if (dialog.hasClass("active")) {
    dialog.fadeOut('fast');
    dialog.removeClass("active");
    $("#avatar-button").parent().removeClass("active");
  }
};