var ArrCountries = []; 
//var currentCountry = 124; //124:Canada  / 840:USA
var forbiddenExit = false;

var currentCountry;

function filtrarPaises(){
	
	console.log("filtrarPaises");
	//alert("filtrarPaises")
	        
	/*filter country destination*/
	//jQuery.each(jQuery("#edit-panes-delivery-delivery-country option"), function() {
	//edit-panes-delivery-delivery-country--2
	jQuery.each(jQuery("[id*='edit-panes-delivery-delivery-country'] option"), function() {		
		//console.log(jQuery(this).val()+" "+jQuery(this).text())
		ArrCountries.push({
			name: jQuery(this).text(),
			value: jQuery(this).val()
		})
		//if country 840 (USA) then remove all other countries from list
		if (currentCountry == 840) {
			if (jQuery(this).val() != currentCountry) jQuery(this).remove();
		} else {
			//remove just USA from the list
			if (jQuery(this).val() == 840) jQuery(this).remove();
		}
	})
	
}

function pick_up(){

	jQuery('#delivery-pane').fadeOut(1000);
	
	
	jQuery( "input[name^='panes[delivery]']" ).val('').blur();
	


}

function shipping(){
	
	filtrarPaises();

	jQuery('#delivery-pane').fadeIn(1000);

	
	jQuery( "input[name^='panes[quotes][quotes]'].form-radio" ).each(function(key,val){
			 var name = "panes[quotes][quotes]["+jQuery(val).val()+"][rate]";
			  console.log("buscando el elemento con name "+name);
			 var value = parseInt(document.getElementsByName(name)[0].value);
			 console.log(value);
			 if(value == 0) {
			   //jQuery(this).parent().hide();
			   jQuery(this).parent().remove();
			 }
			})
	
}


(function ($) {
	
	$.fn.AjaxShipping = function(total, credit,order_id) {
		
		//var qrate = arguments["qrate"];
		if($("#metodo_shipping").prop("checked")){
			console.log("llamando a shipping...");
			shipping();
		}
		else{
			pick_up();
			console.log("llamando a pickup.....");
		}
		

		/*<input class="btn form-submit ajax-processed" type="submit" id="edit-panes-quotes-quote-button--7" name="op" value="Click to calculate shipping">*/
		$("input[value='Click to calculate shipping']").hide()


		//var qrate = arguments["qrate"];
		//console.log("credit",credit);
		console.log("Order_id : "+order_id);
		$(".cart-block-summary-total").first().html(total);
		$(".cart-block-user-credits").first().html(credit);

    	
  	};

	$(document).ready(function () {
		
		//console.log("ready to ...",$("#delivery-pane").attr("style"));
		jQuery("#region_selector_bw").html(jQuery("#block-uc-multiprice-country-masquerade").html());
		
		
		//ticket #48 - Christmas note to shop
		//ticket #64 - Remove Message
		//jQuery("section[id=section-header]").html(jQuery("section[id=section-header]").html()+'<div style="background-color: #ff00002e;text-align:center;color:red!important;font-weight:bold;padding-top:5px;padding-bottom:5px"> ** ORDERS PLACED AFTER FRIDAY, DECEMBER 15TH WILL NOT BE FILLED UNTIL JAN 3, 2018 ** </div>')
		

		currentCountry = jQuery("#edit-uc-multiprice-country").val();

		jQuery("#block-uc-multiprice-country-masquerade").html('');
	   
		/******************
		/* shopping cart
		/*******************/
		var ifMouseOver = false;
	   
		$('body').on('mouseenter', '.view-cart-txt, .cart-block-items', function(){
			ifMouseOver = true;
			$('.cart-block-items').fadeIn('fast');
			if($('.cart-block-items').height() > 450) {
				$('.cart-block-items').css({
					'display': 'block',
					'height': 450,
					'overflow': 'scroll'
				});
			}
		   
		});
	   
		$('body').on('mouseleave', '.view-cart-txt, .cart-block-items', function(){
			ifMouseOver = false;
			setTimeout(function() {
				if(!ifMouseOver)
					$('.cart-block-items').fadeOut('fast');
			}, 500);
		   
		});
	   
		/********************************
		* footer link
		***********************************/
		$('.footer-view-link > a').text('BUY NOW');
	   
		
		/**********************************************
		* Home page products multiple images bxSlider
		***********************************************/
	   
		if($('.page-node-1').length > 0)
		{
			if(typeof bxSlider == 'undefined')
			{
				jQuery.getScript('/sites/all/modules/drupalexp/modules/dexp_views_bxslider/js/jquery.bxslider.min.js', function()
				{
					jQuery("<link/>", {
					   rel: "stylesheet",
					   type: "text/css",
					   href: "/sites/all/modules/drupalexp/modules/dexp_views_bxslider/css/jquery.bxslider.css"
					}).appendTo("head");

					jQuery("<link/>", {
					   rel: "stylesheet",
					   type: "text/css",
					   href: "/sites/all/modules/drupalexp/modules/dexp_views_bxslider/css/dexp_bxslider.css"
					}).appendTo("head");

					
					jQuery.getScript( "/sites/all/modules/drupalexp/modules/dexp_views_bxslider/js/dexp_bxslider.js", function() {
						// script is now loaded and executed.
						jQuery('.field-items').each(function(){
							if($(this).find('.field-item').length > 1)
							{
								$(this).bxSlider({
									maxSlides: 1, 
									pagerCustom: '#bx-pager',
									prevText: '',
									nextText: '',
								});
							}
						});
					});
				});
			}
			else
			{
				jQuery('.field-items').each(function(){
					if($(this).find('.field-item').length > 1)
					{
						$(this).bxSlider({
							maxSlides: 1, 
							pagerCustom: '#bx-pager',
							prevText: '',
							nextText: '',
						});
					}
				});
			}
		}
		
		/**********************************************
		* Move pagination up to top right corner
		***********************************************/
		
		$('.pager-next a').html('<i class="fa fa-chevron-right"></i>');
		$('.pager-previous a').html('<i class="fa fa-chevron-left"></i>');
		$('.item-list .pagination').appendTo('.cat-title');
		
	   /**********************************************************
		* Redirect when choose shopper type territory manager
		**********************************************************/
		
		if($('#skyjackstorem-customer-type-form').length > 0) {
			$('form#skyjackstorem-customer-type-form')[0].reset();
		}
		
		$('#edit-customer-type-manager').click(function(){
			
			window.location.replace("/user");
		});
		
		/**********************************************************
		* Redirect when choose shopper type territory manager
		**********************************************************/
		
		if($('#edit-panes-quotes-quotes-quote-option-flatrate-1-0').is(':checked') || $('#edit-panes-quotes-quotes-quote-option-flatrate-3-0').is(':checked')) {
			$('#delivery-pane').show();
		}
		
		//when guest check out, only costing shipping method can be choose, so show deliver information
		if($('.page-cart-checkout').length > 0 && $('#edit-panes-quotes-quotes-quote-option-flatrate-1-0').length == 0 && $('#edit-panes-quotes-quotes-quote-option-flatrate-3-0').length == 0) {
			$('#delivery-pane').show();
		}
		
		/**********************************************************
		* Remove cart item on checkout page
		**********************************************************/
		if($('.remove-cart-link').length > 0 && $('.page-cart-checkout').length > 0) {
			$('.remove-cart-link').each(function(idx){
				this.onclick = function(event) {
				  return false;
				};
			});
			
			$('.remove-cart-link').click(function(){
				if (confirm('You can\'t remove items on checkout page. Do you want to redirect to cart-view page to remove items.')) {
					$('#edit-cancel').trigger('click');
				}
				
			})
		}
		
		/**********************************************************
		* Checkout page, to go to other page
		**********************************************************/
		
		if($('.page-cart-checkout').length > 0) {
			
			$('.cart-block-view-cart').each(function(idx){
				this.onclick = function(event) {
				  return false;
				};
			});
			
			$('.cart-block-view-cart').click(function(){
				$('#edit-cancel').trigger('click');
			});

			forbiddenExit = true;

			//hidde Region selector
			jQuery("#region_selector_bw").parent().parent().hide()//fadeOut(1000)



			jQuery('#delivery-pane').fadeOut(1000);

			var deliveryMethodsDiv = '<fieldset class="form-wrapper" id="quote-pane"><div></div><legend><span class="fieldset-legend">Delivery Method</span></legend><div class="fieldset-wrapper"><div id="quotes">';
         
			if(currentCountry!=840){
				
				deliveryMethodsDiv += '<div class="form-item form-type-radio form-item-panes-quotes-quotes-quote-option">'+
									        '<input type="radio" id="metodo_pickup" name="metodo" value="0" checked="checked" class="form-radio" onclick="pick_up();" style="width:12px;">  <label class="option">Pick Up</label>'+
									  '</div>';
			}
	
			deliveryMethodsDiv += '<div class="form-item form-type-radio form-item-panes-quotes-quotes-quote-option">'+
								        '<input type="radio" id="metodo_shipping" name="metodo" value="1"  class="form-radio" onclick="shipping();" style="width:12px;">   <label class="option">Shipping </label>'+
								    '</div>';
			


			deliveryMethodsDiv +=     '</div>'+
								   '</div>'+
								  '</fieldset>';





			jQuery('#customer-pane').before(deliveryMethodsDiv);


			if(currentCountry==840){
				$("#metodo_shipping").click();
			}






			document.getElementById("edit-panes-delivery-delivery-zone").options.length = 1;


			//jQuery("#edit-panes-delivery-delivery-zone").select2();



			$(window).on("beforeunload", function(e) {
			  	//return "Are you sure you want leave?";

				console.log(forbiddenExit);

			  	if(forbiddenExit){ 			  	
			  		return "Are you sure you want leave?";
			  	}else{
			  		return;

			  	}

			});



			$("#edit-continue").on("click",function(){
				forbiddenExit = false;
			});
			
			filtrarPaises();
		

//			/*filter country destination*/
//			jQuery.each(jQuery("#edit-panes-delivery-delivery-country option"),function(){ 
//				
//				//console.log(jQuery(this).val()+" "+jQuery(this).text())
//				ArrCountries.push({name:jQuery(this).text(),value:jQuery(this).val()})
//				
//
//				//if country 840 (USA) then remove all other countries from list
//				if(currentCountry == 840){
//
//					if(jQuery(this).val() != currentCountry) jQuery(this).remove();
//
//				}else{
//
//					//remove just USA from the list
//					if(jQuery(this).val() == 840) jQuery(this).remove();
//					
//
//				}
//
//			})

			if(jQuery("#edit-uc-multiprice-country").val() !=840){
				jQuery("#edit-panes-delivery-delivery-country").val(124)
			}

			//document.getElementById("edit-panes-delivery-delivery-country").options.length = 0;
			console.log(ArrCountries)
			jQuery("#edit-panes-delivery-delivery-country").change();



		}
		
		
		/**********************************************************
		* Make catgory page 'NEXT', 'PREVIOUSE' icon bigger
		**********************************************************/
		
		//if($('.cat-nav > ul > li:first-child a').length > 0 && !$('.cat-nav > ul > li:first-child a').hasClass('active')) {
		if($('.cat-nav > ul > li:first-child a').length > 0) {
			
			$('.pagination').addClass('on-cat-page');
			$('.pagination .pager-next a').html('NEXT <i class="fa fa-chevron-right"></i>');
			$('.pagination .pager-previous a').html('<i class="fa fa-chevron-left"></i> PREVIOUS');
		}
		
		/**********************************************************
		* Check out page coupon button, change style
		**********************************************************/
		$('#edit-panes-coupon-apply').addClass('btn-info').removeClass('btn-primary');
		
		
		/******************************************************************
		* Ajax cart button - click to go to cart on small mobile screen
		*******************************************************************/
		
		var cartLinkOnMobile = function(){
			$('.cart-link').remove();
			
			var cartPos = $('.view-cart-txt').offset();
			var cartWidth = $('.view-cart-txt').width();
			var cartHeight = $('.view-cart-txt').height();
			
			$('<div class="cart-link"></div>').css(cartPos).css({'width':cartWidth+25, 'height':cartHeight+25}).appendTo('body');
			$('.cart-link').click(function(event){

				event.stopPropagation();
				window.location.href = "/cart";
				
			});
		};
		
		if($( window ).width() <= 320) {
			cartLinkOnMobile();
		}
		
		
		$(window).resize(function() {
			if($( window ).width() <= 320) {
				cartLinkOnMobile();
			}
		});
		
		//add temporary text under header
		//$('#section-main-content').before('<section><div class="container"><div class="row"><div class="col-md-12" style="color:red;margin-top: 10px">Please note: Purchases made after December 19th will not be filled until after the holidays. Thank you!</div></div></div></section>');
		
	});

   
})(jQuery);
