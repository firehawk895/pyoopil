/**
 * Created by himanshu on 12/9/14.
 */
$('.tweet').twittie();

$(document).ready(function () {

  $(".lightbox-close").click(function () {
    $(".lightbox, .lightbox-overlay").hide();
  });

  $(".feature-selector-buttons li").click(function () {
    $('.feature-selector-frame img').hide();
  });

});