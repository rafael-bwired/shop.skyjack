<?php
/**
 * @file brb-widget.tpl.php
 * Main widget template
 *
 * Variables available:
 * - $body: The main content.
 * - $browsers: Array with all optional browsers offered to the user.
 *     ['id']: The id attribute used for the item list
 *     ['name']: The browser name and text to be enclosed with the anchor tag
 *     ['url']: The download URL for the browser
 *     ['attributes']: An associative array of HTML attributes to apply to the anchor tag
 */
?>

<div id="brb-wrap" class="msg_ie">
  <div id="brb-wrap-inner">
    <?php // Message ?>
    <div id="brb-message">
      <div id="brb-message-inner">
        <div class="texto">
          <?php print $body; ?>
          <?php global $base_url; ?>
          <?php // Browsers list ?>
          <?php if (isset($browsers) && count($browsers) > 0) : ?>
            <?php print t("Please use");?>
                <?php $last = count($browsers) - 1; ?>
                <?php $edge = ''; ?>
                <?php foreach ($browsers as $key => $browser) : ?>
                    <?php $edge = (($key == 0) ? ' ' : (($key == $last) ? ' or ' : ', '));?>
                    <?php print  $edge . l($browser["name"], $browser["url"], array('attributes' => $browser["attributes"]))?>
                <?php endforeach;?>
            <?php endif; ?>
        </div>
        <div id="brb-message-close">
            <img src="<?php echo $base_url; ?>/sites/all/modules/contrib/brb/images/close.jpg" class="brb-message-close-action" /> 
        </div>
      </div>
    </div>
  </div>
</div>


