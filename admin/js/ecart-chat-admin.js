(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
	 */ $( window ).load(function() {
			$('a[href="admin.php?page=ecart-popup"]').hide();
	 });
	 /*
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
        
        //console.log(commonL10n.dismiss);
        jQuery( '.notice.is-dismissible' ).each( function() {
            
            /* dismiss ajax call start

		var abcart_get_name = this.className;
		if (abcart_get_name.indexOf('abcart-consent') !== -1){
			var $this = jQuery( this ),
				$button = jQuery( '<button type="button" class="notice-dismiss"><span class="abcart screen-reader-text"></span></button>' ),
				btnText = commonL10n.dismiss || '';

			// Ensure plain text
			$button.find( '.screen-reader-text' ).text( btnText );

			$this.append( $button );
			$button.on( 'click.notice-dismiss', function( event ) {
				console.log ('here');
				//alert('This');
				event.preventDefault();
				$this.fadeTo( 100 , 0, function() {
					//alert();
					jQuery(this).slideUp( 100, function() {
						jQuery(this).remove();
						var data = {
							action: "abcart_admin_notices"
						};
						var admin_url = jQuery( "#admin_url" ).val();
							jQuery.post( admin_url + "/admin-ajax.php", data, function( response ) {
						});
					});
				});
			});

		}
                // dismiss ajax call end */
	});
        
        

})( jQuery );
