const ANIMATION_TIME = 200;

$("#register").click(function () {
  $("#login-panel").fadeOut(ANIMATION_TIME);
  $("#register-panel").delay(ANIMATION_TIME).fadeIn(ANIMATION_TIME);
});
$("#login").click(function () {
  $("#register-panel").fadeOut(ANIMATION_TIME);
  $("#login-panel").delay(ANIMATION_TIME).fadeIn(ANIMATION_TIME);
});
