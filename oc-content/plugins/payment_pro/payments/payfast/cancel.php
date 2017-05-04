<?php
/**
 * Copyright (c) 2008 PayFast (Pty) Ltd
 * You (being anyone who is not PayFast (Pty) Ltd) may download and use this plugin / code in your own website in conjunction with a registered and active PayFast account. If your PayFast account is terminated for any reason, you may not use this plugin / code or part thereof.
 * Except as expressly indicated in this licence, you may not use, copy, modify or distribute this plugin / code or part thereof in any way.
 */
payment_pro_cart_drop();
osc_add_flash_error_message(__( 'The payment has been cancelled, if this is an error please contact the administrator', 'payment_pro' ) );
payment_pro_js_redirect_to( osc_route_url( 'payment-pro-done', array( 'tx' => '' ) ) );
