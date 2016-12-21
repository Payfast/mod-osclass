<?php

payment_pro_cart_drop();

$tx = $pfData['pf_payment_id'];
$payment = ModelPaymentPro::newInstance()->getPaymentByCode( $tx, 'PAYFAST' );

osc_add_flash_ok_message( __( 'Payment processed correctly', 'payment_pro' ) );

payment_pro_js_redirect_to( osc_route_url( 'payment-pro-done', array( 'tx' => $tx ) ) );