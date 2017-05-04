<?php
/**
 * Copyright (c) 2008 PayFast (Pty) Ltd
 * You (being anyone who is not PayFast (Pty) Ltd) may download and use this plugin / code in your own website in conjunction with a registered and active PayFast account. If your PayFast account is terminated for any reason, you may not use this plugin / code or part thereof.
 *Except as expressly indicated in this licence, you may not use, copy, modify or distribute this plugin / code or part thereof in any way.
 */

require_once( 'payfast_common.inc' );

ob_get_clean();

$pfError = false;
$pfErrMsg = '';
$pfDone = false;
$pfData = array();
$pfHost = ( ( osc_get_preference('payfast_sandbox', 'payment_pro' ) == 1 ) ? 'sandbox' : 'www' ) . '.payfast.co.za';
$pfOrderId = '';
$pfParamString = '';

pflog( 'PayFast ITN call received' );
//// Notify PayFast that information has been received
if( !$pfError && !$pfDone )
{
    header( 'HTTP/1.0 200 OK' );
    flush();
}

//// Get data sent by PayFast
if( !$pfError && !$pfDone )
{
    pflog( 'Get posted data' );
    // Posted variables from ITN
    $pfData = pfGetData();
    pflog( 'PayFast Data: '. print_r( $pfData, true ) );
    if( $pfData === false )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_ACCESS;
    }
}

//// Verify security signature
if( !$pfError && !$pfDone )
{
    pflog( 'Verify security signature' );
    $passPhrase = payment_pro_decrypt(osc_get_preference('payfast_passphrase', 'payment_pro'));
    $pfPassPhrase = empty( $passPhrase ) ? null : $passPhrase;
    // If signature different, log for debugging
    if( !pfValidSignature( $pfData, $pfParamString, $pfPassPhrase ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_INVALID_SIGNATURE;
    }
}

//// Verify source IP (If not in debug mode)
if( !$pfError && !$pfDone )
{
    pflog( 'Verify source IP' );
    if( !pfValidIP( $_SERVER['REMOTE_ADDR'] ) )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_SOURCE_IP;
    }
}

//// Verify data received
if( !$pfError )
{
    pflog( 'Verify data received' );
    $pfValid = pfValidData( $pfHost, $pfParamString );
    if( !$pfValid )
    {
        $pfError = true;
        $pfErrMsg = PF_ERR_BAD_ACCESS;
    }
}

if( $pfError )
{
    pflog( 'Error occurred: '. $pfErrMsg );
}

//// Check status and update order
if( !$pfError && !$pfDone )
{
    pflog('Check Status and Update Order');
    // $paymentStatus = $listener->paymentStatus();
    $paymentStatus = $pfData['payment_status'];
    // update order status
    switch ($paymentStatus)
    {
        case 'COMPLETE':
            PayfastPayment::processPayment();
            break;
        case 'PENDING':
            // do nothing, as no order is created
            break;
        case 'FAILED':
            // do nothing, as no order is created
            break;
        default:
            break;
    }
}





