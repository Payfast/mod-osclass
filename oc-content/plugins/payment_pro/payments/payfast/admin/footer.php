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