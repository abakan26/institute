(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

// calc_shipping
// 	$('div.woocommerce').on('change', '#calc_shipping_state', function(){
// 		console.log("up")
// 		//jQuery("[name='calc_shipping']").trigger("click");
// 		//alert("sds")
// 	});
	// $( document.body ).on( 'updated_cart_totals', function(){ alert("update")});
	//$( document.body ).trigger( 'country_to_state_changed' );
	//$( document.body ).trigger( 'country_to_state_changed' );
	// $(".state_select").change(function () {
	// 	alert("s")
	// 	//$("[name='update_cart']").trigger("click");
	// });
	// $( '.calc_shipping' ).on( 'update', function() {
	// 	alert("bbb")
	// })
	// $('.select2-results__option').on('click', function(){
	// 	$("[name='update_cart']").trigger("click");
	// });

	// $( ".entry-title" ).on("click", function (e) {
	// 	console.log(e)
	// })
	var q  = 0;
	// $(document.body).on("change", "#calc_shipping_state", function (e) {
	// 	if(q++ > 0){
	// 		console.log($("[name='update_cart']"))
	// 	}
	//
	// })
	$(document).on('change', '#calc_shipping_state', function() {

		if(q++ > 0) {
			$("[name='calc_shipping']").trigger("click");
		}

	});
	// $(document).on('change', '.shipping_method', function() {
	// 	console.log("shipping_method");
	// 	console.log($("[name='update_cart']"));
	//
	// 		$("[name='update_cart']").trigger("click");
	// });





})( jQuery );
