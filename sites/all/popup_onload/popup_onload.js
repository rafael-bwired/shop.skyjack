/**
 * @file
 * Javascript to display a popup after a delay.
 */

(function ($) {

Drupal.behaviors.initPopupOnLoad = {
  attach: function (context, settings) {
    if (!$.isFunction($.colorbox)) {
      return;
    }

    $('body', context).once('popup_onload', function() {
      var popup_onload_settings = settings.popup_onload;

      setTimeout(function() {
        $.colorbox(popup_onload_settings);
        jQuery("#cboxLoadedContent").html(jQuery("#region_selector_bw").html());
        jQuery("#cboxClose").hide();
      }, popup_onload_settings.delay);
    });
  }
}

})(jQuery);
