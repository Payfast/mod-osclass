<?php

    class PayfastPayment implements iPayment
    {

        public function __construct()
        {
        }

        public static function button( $products, $extra = null )
        {
            echo '<li class="payment payfast-btn">';

            $r = rand( 0,1000 );
            $extra['random'] = $r;
            $extra = payment_pro_set_custom( $extra );

            if( osc_get_preference( 'payfast_sandbox', 'payment_pro' ) == 1 )
            {
                $ENDPOINT = 'https://www.sandbox.payfast.co.za/eng/process';
                $merchant_id = '10000100';
                $merchant_key = '46f0cd694581a';
            }
            else
            {
                $ENDPOINT = 'https://www.payfast.co.za/eng/process';
                $merchant_id = payment_pro_decrypt( osc_get_preference( 'payfast_merchant_id', 'payment_pro' ) );
                $merchant_key = payment_pro_decrypt ( osc_get_preference( 'payfast_merchant_key', 'payment_pro' ) );
            }
            $data = payment_pro_get_custom( Params::getParam( "data" ) );

            $amount = '';
        //    $itemDescriptions = '';
            foreach( $products as $p )
            {
                $amount += $p['amount'];
            //    $itemDescriptions .= $p['description'] . '; ';
            }
            $description = http_build_query( $products ) ;
            $description = urldecode( $description ) ;

            $info = array(
                'merchant_id' => $merchant_id,
                'merchant_key' => $merchant_key,
                'return_url' => osc_route_url( 'payfast-return', array( 'extra' => $extra )  ) ,
                'cancel_url' => osc_route_url( 'payfast-cancel', array( 'extra' => $extra )  ) ,
                'notify_url' => osc_route_url( 'payfast-notify', array( 'extra' => $extra )  ) ,
                'm_payment_id' => $r,
                'amount' => $amount,
                'item_name' => osc_page_title() . ' : Transaction ID ' . $r,
                'item_description' => $description
            );

            $pfOutput = '';
            // Create output string
            foreach( $info as $key => $value )
                $pfOutput .= $key .'='. urlencode( trim( $value ) ) .'&';

            $passPhrase = payment_pro_decrypt( osc_get_preference( 'payfast_passphrase', 'payment_pro' )  ) ;
            if ( empty( $passPhrase ) || ( osc_get_preference( 'payfast_sandbox', 'payment_pro' )  == 1 ) )
            {
                $pfOutput = substr( $pfOutput, 0, -1 );
            }
            else
            {
                $pfOutput = $pfOutput."passphrase=".urlencode( $passPhrase );
            }

            $info['signature'] = md5( $pfOutput ) ;

            if ( strlen( $description )  <= 255 )
            {
                ?>

                <form class="nocsrf" action="<?php echo $ENDPOINT; ?>" method="post" id="payfast_<?php echo $r; ?>">
                    <?php foreach ( $info as $k => $v )  { ?>
                        <input type="hidden" name="<?php echo $k; ?>" value="<?php echo $v; ?>"/>
                    <?php } ?>
                </form>
                <div class="buttons">
                    <div class="right"><a style="cursor:pointer;cursor:hand" id="button-confirm"
                                          class="button payfast-btn"
                                          onclick="$('#payfast_<?php echo $r; ?>').submit();"><span><img
                                    src='<?php echo PAYMENT_PRO_URL; ?>payments/payfast/logo.png'
                                    border='0'/></span></a></div>
                </div>
                <?php
            }
        }

        public static function recurringButton( $products, $extra = null )
        {

        }

        public static function processPayment()
        {
            $data = Params::getParam( 'extra' ) ;
            $data = payment_pro_get_custom( $data ) ;

            $products = explode( '&', $_POST['item_description'] ) ;

            foreach ( $products as $result )
            {
                $product = explode( '=', $result ) ;
                $productArray[$product[0]] = $product[1];
            }

            $productList = array_values( $productArray ) ;
            $finalList = array_chunk( $productList, 5 ) ;

            foreach ( $finalList as $k => $v )
            {
                $finalList[$k]['id'] = $finalList[$k][0];
                unset( $finalList[$k][0] ) ;
                $finalList[$k]['description'] = $finalList[$k][1];
                unset( $finalList[$k][1] ) ;
                $finalList[$k]['amount'] = $finalList[$k][2];
                unset( $finalList[$k][2] ) ;
                $finalList[$k]['tax'] = $finalList[$k][3];
                unset( $finalList[$k][3] ) ;
                $finalList[$k]['quantity'] = $finalList[$k][4];
                unset( $finalList[$k][4] ) ;
            }

            $invoiceId = ModelPaymentPro::newInstance()->saveInvoice(
            $_POST['pf_payment_id'], // transaction code (unique field that related to Payfast's transaction/log
            $_POST['amount_gross'], // subtotal amount
            '-', // tax amount
            $_POST['amount_gross'], // total amount
            PAYMENT_PRO_COMPLETED,  // usually PAYMENT_PRO_COMPLETED
            'ZAR', //currency
            @$data['email'], // payer's email
            @$data['user'], // user's ID (if the payment has that information
            'PAYFAST',
            $finalList
            );

            $additional_data = array();
            // FINALLY, MARK AS PAID THE ITEMS; DO WHAT THEY SHOULD DO
            foreach( $finalList as $finalProduct )
            {
                // additional data is and array with extra data related to the product and / or payment if required, could be an empty array
                osc_run_hook( 'payment_pro_item_paid', $finalProduct, $additional_data, $invoiceId);
            }
            
            return PAYMENT_PRO_COMPLETED;

        }

    }

