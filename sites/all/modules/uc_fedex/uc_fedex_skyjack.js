(function ($) {
	$(document).ready(function () {

			
			
			//Opcion 	: admin/store/settings/quotes/settings/fedex 
			//Tab    	: USA Address
			//Id	 	: 001
			if( $('.page-admin-store-settings-quotes-settings-fedex').length > 0 ) {

					console.log("page-admin-store-settings-quotes-settings-fedex");
					console.log($("#edit-uc-store-country").val());



					jQuery.each(jQuery("#edit-uc-store-country option"),function(){ 

												
						//elimina todos los paises excepto USA
						if(jQuery(this).val() != 840){
								console.log("eliminando pais: "+jQuery(this).val())
								jQuery(this).remove();
						}

						//recargar states/provinces
						jQuery("#edit-uc-store-country").change();
	

					})




			}//001

			

	});


})(jQuery);