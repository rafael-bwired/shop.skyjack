<div class="panel panel-default">
  <div class="panel-heading">
  <h4 class="panel-title"><a class="<?php if($class){print $class;}?>" data-parent="#ACCORDION_WRAPPER_ID" data-toggle="collapse" href="#<?php print $accordion_item_id;?>"><?php if ($icon!=""){ print "<i class='$icon'></i>";}?><?php print $title;?></a></h4>
  </div>
  <div class="panel-collapse collapse <?php print $item_active;?>" id="<?php print $accordion_item_id;?>">
    <div class="panel-body">
      <?php print $content;?>
    </div>
  </div>
</div>