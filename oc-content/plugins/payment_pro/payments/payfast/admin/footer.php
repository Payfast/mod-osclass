<!--Copyright (c) 2008 PayFast (Pty) Ltd
You (being anyone who is not PayFast (Pty) Ltd) may download and use this plugin / code in your own website in conjunction with a registered and active PayFast account. If your PayFast account is terminated for any reason, you may not use this plugin / code or part thereof.
Except as expressly indicated in this licence, you may not use, copy, modify or distribute this plugin / code or part thereof in any way.-->
<form id="dialog-payfast" method="get" action="#" class="has-form-actions hide">
    <div class="form-horizontal">
        <div class="form-row">
            <h3><?php _e('Learn more about PayFast', 'payment_pro'); ?></h3>
            <p>
                <?php _e('Create your PayFast account on the PayFast site (https://www.payfast.co.za) in order to obtain your merchant ID and key.', 'payment_pro'); ?>.
                <br/>
            </p>
        </div>
        <div class="form-actions">
            <div class="wrapper">
                <a class="btn" href="javascript:void(0);" onclick="$('#dialog-payfast').dialog('close');"><?php _e('Cancel'); ?></a>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" >
    $("#dialog-payfast").dialog({
        autoOpen: false,
        modal: true,
        width: '90%',
        title: '<?php echo osc_esc_js( __('PayFast help', 'payment_pro') ); ?>'
    });
</script>