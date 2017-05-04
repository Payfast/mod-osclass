<?php
/**
 * Copyright (c) 2008 PayFast (Pty) Ltd
 * You (being anyone who is not PayFast (Pty) Ltd) may download and use this plugin / code in your own website in conjunction with a registered and active PayFast account. If your PayFast account is terminated for any reason, you may not use this plugin / code or part thereof.
 * Except as expressly indicated in this licence, you may not use, copy, modify or distribute this plugin / code or part thereof in any way.
 */

payment_pro_cart_drop();

$tx = $pfData['pf_payment_id'];
$payment = ModelPaymentPro::newInstance()->getPaymentByCode( $tx, 'PAYFAST' );

osc_add_flash_ok_message( __( 'Payment processed correctly', 'payment_pro' ) );

payment_pro_js_redirect_to( osc_route_url( 'payment-pro-done', array( 'tx' => $tx ) ) );