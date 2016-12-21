<?php
payment_pro_cart_drop();
osc_add_flash_error_message(__( 'The payment has been cancelled, if this is an error please contact the administrator', 'payment_pro' ) );
payment_pro_js_redirect_to( osc_route_url( 'payment-pro-done', array( 'tx' => '' ) ) );
