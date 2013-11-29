(function( $ ) {
    "use strict";
 
    wp.customize( 'cc_link_color', function( value ) {
        value.bind( function( to ) {
            $( 'a' ).css( 'color', to );
        } );
    });
 
})( jQuery );