<?php
osc_add_route( 'payfast-return', 'payment/payfast-return/(.+)', 'payment/payfast-return/{extra}', PAYMENT_PRO_PLUGIN_FOLDER . 'payments/payfast/return.php' );
osc_add_route( 'payfast-cancel', 'payment/payfast-cancel/(.+)', 'payment/payfast-cancel/{extra}', PAYMENT_PRO_PLUGIN_FOLDER . 'payments/payfast/cancel.php' );
osc_add_route( 'payfast-notify', 'payment/payfast-notify/(.+)', 'payment/payfast-notify/{extra}', PAYMENT_PRO_PLUGIN_FOLDER . 'payments/payfast/callback.php' );
require_once PAYMENT_PRO_PATH . 'payments/payfast/PayfastPayment.php';


function payment_pro_payfast_install()
{
    // If extra actions are needed 
    osc_set_preference( 'payfast_enabled', '0', 'payment_pro', 'BOOLEAN' );
    osc_set_preference( 'payfast_merchant_id', payment_pro_crypt( '' ), 'payment_pro', 'STRING' );
    osc_set_preference( 'payfast_merchant_key', payment_pro_crypt( '' ), 'payment_pro', 'STRING' );
    osc_set_preference( 'payfast_passphrase', payment_pro_crypt( '' ), 'payment_pro', 'STRING' );
    osc_set_preference( 'payfast_sandbox', '1', 'payment_pro', 'BOOLEAN' );
}
osc_add_hook( 'payment_pro_install', 'payment_pro_payfast_install' );

function payment_pro_payfast_conf_save()
{
    osc_set_preference( 'payfast_enabled', Params::getParam( "payfast_enabled" ) ? Params::getParam( "payfast_enabled" ) : '0', 'payment_pro', 'BOOLEAN' );
    osc_set_preference( 'payfast_merchant_id', Params::getParam( "payfast_merchant_id" ) ? payment_pro_crypt( Params::getParam( "payfast_merchant_id" ) ) : '', 'payment_pro', 'STRING' );
    osc_set_preference( 'payfast_merchant_key', Params::getParam( "payfast_merchant_key" ) ? payment_pro_crypt( Params::getParam( "payfast_merchant_key" ) ) : '', 'payment_pro', 'STRING' );
    osc_set_preference( 'payfast_passphrase', Params::getParam( "payfast_passphrase" ) ? payment_pro_crypt( Params::getParam( "payfast_passphrase" ) ) : '', 'payment_pro', 'STRING' );
    osc_set_preference( 'payfast_sandbox', Params::getParam( "payfast_sandbox" ) ? Params::getParam( "payfast_sandbox" ) : '0', 'payment_pro', 'BOOLEAN' );
    
    // This is needed to bootstrap the payment's button, do not remove
    if( Params::getParam( "payfast_enabled" )==1 )
    {
        payment_pro_register_service( 'Payfast', __FILE__ );
    }
    else
    {
        payment_pro_unregister_service( 'Payfast' );
    }
}
osc_add_hook( 'payment_pro_conf_save', 'payment_pro_payfast_conf_save' );


// show configuration options
function payment_pro_payfast_conf_form()
{
    require_once dirname( __FILE__ ) . '/admin/conf.php';
}
osc_add_hook( 'payment_pro_conf_form', 'payment_pro_payfast_conf_form', 4 );

function payment_pro_payfast_conf_footer()
{
    require_once dirname( __FILE__ ) . '/admin/footer.php';
}
osc_add_hook( 'payment_pro_conf_footer', 'payment_pro_payfast_conf_footer' );


function payment_pro_payfast_load_lib()
{
    // In case you need to use some JS library at checkout page for the button,
    /*if( Params::getParam( 'page' )=='custom' && Params::getParam( 'route' )=='payment-pro-checkout' )
    {
        osc_register_script( 'payfast-some-js', PAYMENT_PRO_URL . 'payments/payfast/some-js-library.js', array( 'jquery' ) );
        osc_enqueue_script( 'payfast-some-js' );
    }*/
}
osc_add_hook( 'init', 'payment_pro_payfast_load_lib' );

