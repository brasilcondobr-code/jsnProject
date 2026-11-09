/**
 * Idyllic Clone — live preview do Customizer (refresco de logo/título).
 */
(function () {
	'use strict';

	if ( typeof wp === 'undefined' || ! wp.customize ) {
		return;
	}

	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			var title = document.querySelector( '.site-title a' );

			if ( title ) {
				title.textContent = to;
			}
		} );
	} );

	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			var desc = document.querySelector( '.site-description' );

			if ( desc ) {
				desc.textContent = to;
			}
		} );
	} );
})();
