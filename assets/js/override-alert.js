(function ($) {

    $('.single_add_to_cart_button').unbind("click").bind("click", function(event){

        if ( $( this ).is('.disabled') ) {
            event.preventDefault();

            if ( $( this ).is('.wc-variation-is-unavailable') ) {
                Swal.fire({
                    text:wc_add_to_cart_variation_params.i18n_unavailable_text,
                    icon:'info'
                });
            } else if ( $( this ).is('.wc-variation-selection-needed') ) {
                Swal.fire({
                    text:wc_add_to_cart_variation_params.i18n_make_a_selection_text,
                    icon:'info'
                });
            }

            return false;
        }
    });

})(jQuery);