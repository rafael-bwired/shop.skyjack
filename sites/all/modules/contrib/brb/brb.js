

function detectIE() {
  var ua = window.navigator.userAgent;
  var msie = ua.indexOf('MSIE ');
  var trident = ua.indexOf('Trident/');
  var edge = ua.indexOf('Edge/');

  console.log("ua, msie, trident, edge", ua, msie, trident, edge);
  if (msie > 0) {
    // IE 10 or older 
    //Do some stuff
    return true;
  }
  else if (trident > 0) {
    // IE 11 
    //Do some stuff
    return true;
  }
  else if (edge > 0) {
    // Edge 
    //Do some stuff
    return true;
  }
  else{
    return false;
  }
};


(function ($) {
  Drupal.behaviors.brb = {
    attach: function (context, settings) {
      // Load brb settings under Drupal.settings
      //settings.brb = brb;  // Remove this line once drupal_add_js() supports the browser option.
      console.log(settings);
      $('#brb-wrap').remove();
      if (detectIE() == true){
        $('body').prepend(settings.brb.widget);
        
        //$('#brb-wrap').html(modal: settings.brb.overlay);
      }
    }
  };
  $(document).on('click', '.brb-message-close-action', function(){
      $(this).parents('#brb-wrap').hide(400);
  });

})(jQuery);



