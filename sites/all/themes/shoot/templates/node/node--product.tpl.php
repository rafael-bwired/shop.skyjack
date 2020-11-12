<?php
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/
?>
<?php 
	global $user;
	$available_for_role = true;
	$available = $content['field_available_to']['#object']->field_available_to;
	if($available['und'][0]['value'] == 'TM/VPs only' and (!user_is_logged_in() || (user_is_logged_in() and !in_array('administrator', $user->roles) and !in_array('territory manager', $user->roles) and !in_array('RVP', $user->roles))))
	{
		$available_for_role = false;
	}
	
	$products_cat = array();
	if(isset($content['field_product_category']['#object']->field_product_category['und']) and !empty($content['field_product_category']['#object']->field_product_category['und'])) {
		$products_cat = $content['field_product_category']['#object']->field_product_category['und'];
	}
	
	$products_character = array();
	if(isset($content['field_product_category']['#object']->field_characteristics['und']) and !empty($content['field_product_category']['#object']->field_characteristics['und'])) {
		$products_character = $content['field_product_category']['#object']->field_characteristics['und'];
	}
	
	//$product_cat = array_merge($products_cat, $products_character);
	$cat_str = '';
	foreach($products_cat as $v) {
		$cat_str .= '<a href="/?category='.$v['value'].'" class="pri-link">'.$v['value'].'</a>';
	}
	foreach($products_character as $v) {
		$cat_str .= '<a href="/?character='.$v['value'].'" class="pri-link">'.$v['value'].'</a>';
	}
	
	
	//check if on sale
	$pattern = '/(?:EUR|[$])\s*\d+(?:\.\d{2})?/';
	$display_price = $list_price = 0;
	
	if (preg_match($pattern, render ($content['display_price']), $matches)) {
		$display_price = str_replace('$', '', $matches[0]);
	}
	
	if (preg_match($pattern, render ($content['list_price']), $matches)) {
		$list_price = str_replace('$', '', $matches[0]);
	}
	
	$onsale = false;
	if($list_price != 0 and $list_price > $display_price) {
		$onsale = true;
	}
?>

<div id="node-<?php print $node->nid; ?>" class="node-product-detail <?php print $classes; ?> clearfix"<?php print $attributes; ?>>
    <?php if(!$available_for_role):?>
	<div class="msg-public-user">Sorry, the product is not available.</div>
	<?php else:?>
	
	<?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>

    <div class="row single-product">
	
        <div class="col-ld-4 col-md-4 col-sm-12 col-xs-12">
            <div class="product-detail-images">
                <?php print render($content['uc_product_image']);?>
				<?php print ($onsale)?'<div class="onsale-img"></div>':'';?>
				
            </div>    
        </div>

        <div class="col-ld-5 col-md-5 col-sm-12 col-xs-12">
			<div class="product-desc">
				<h1> <?php print $node->title;?></h1>
				<div class="product-desc"><p><?php print render($content['body']);?></p></div>
				<div class="cat-links">Categories: <?php echo $cat_str;?></div>
            </div>
        </div>
		<div class="col-ld-3 col-md-3 col-sm-12 col-xs-12">
			<div class="product-add-action">
				
				<div class="price <?php echo ($onsale)?'onsaleprice':'';?>">
					
					<?php if($onsale):?>
						<?php print render ($content['list_price']);?>
					<?php endif;?>
					<?php print render ($content['display_price']);?>
				</div>
				<div class="clearfix"></div>
				<div class="add-cart-form">
					<?php $addcart_form = drupal_get_form('uc_product_add_to_cart_form_'.$node->nid, $node);?>
					<?php print render($addcart_form);?>
				</div>
			</div>
		</div>
		
    </div>
    
    <div class="line-60"></div>
    <div class="dexp_tab_wrapper default clearfix" id="dexp_tab_wrapper_product_detail"> 
        
		<div class="relat-products">
			<div class="view view-home-popular-products">
			<div class="view-content">
			<div class="row">
			
			<?php 
				if(isset($content['field_related_products']['#object']->field_related_products) and !empty($content['field_related_products']['#object']->field_related_products))
				{
					echo '<h3>Related Products</h3>';
					
					$relatproducts = $content['field_related_products']['#object']->field_related_products;
					$relatproducts = array_slice($relatproducts['und'], 0, 4);
					
					foreach($relatproducts as $v) {
						
						if($v['node']->status == 0) {
							continue;
						}
						
						$relateproduct = node_load($v['nid']);
						
						$rl_onsale = false;
						$rl_class = '';
						
						if(isset($relateproduct->list_price) and $relateproduct->list_price > $relateproduct->price) {
							$rl_onsale = true;
						}
						
						$html = '<div class="dexp-grid-item col-lg-3 col-md-3 col-sm-12 col-xs-12"><div class="home-product-item">';
						
						$html .= '<div class="home-product-image"><div class="field-item"><a href="'.url('node/'. $v['nid']).'">';
						if(isset($relateproduct->uc_product_image['und'][0]['uri'])) {
							$html .= '<img src="'.file_create_url($relateproduct->uc_product_image['und'][0]['uri']).'">';
						}
						$html .= '</a></div>';
						
						if($rl_onsale) {
							$html .= '<div class="onsale-img"></div>';
							$rl_class = 'onsaleprice';
						}
						
						$html .= '</div>';
						
						$html .= '<div class="home-product-detail relat-title">';
						
						$html .= '<h4><a href="'.url('node/'. $v['nid']).'">'.$relateproduct->title.'</a></h4>';
						
						$html .= '<div class="price '.$rl_class.'">';
						
						$html .= '<div class="product-info display-price"><span class="uc-price">$'.number_format((float)$relateproduct->price, 2, '.', '').'</span></div>';
						
						if($rl_onsale) {
							
							$html .= '<div class="product-info list-price"><span class="uc-price">'.number_format((float)$relateproduct->list_price, 2, '.', '').'</span></div>';
						}
						
						$html .= '</div>';
						
						$html .= '</div></div></div>';
						
						echo $html;
						
					}
				}
				
			?>
			
			</div>
			</div>
			</div>
		</div>
    </div>
    <?php endif; ?>
	<!--end available_for_role-->
    <div class="sep60"></div>
	<div class="line-60"></div>
</div>
