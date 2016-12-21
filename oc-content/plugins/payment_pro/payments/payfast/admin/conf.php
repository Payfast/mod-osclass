<h2 class="render-title separate-top"><?php _e('PayFast settings', 'payment_pro'); ?> <span><a href="javascript:void(0);" onclick="$('#dialog-payfast').dialog('open');" ><?php _e('help', 'payment_pro'); ?></a></span> <span style="font-size: 0.5em" ><a href="javascript:void(0);" onclick="$('.payfast').toggle();" ><?php _e('Show options', 'payment_pro'); ?></a></span></h2>
<div class="form-row payfast hide">
    <div class="form-label"><?php _e('Enable PayFast'); ?></div>
    <div class="form-controls">
        <div class="form-label-checkbox">
            <label>
                <input type="checkbox" <?php echo (osc_get_preference('payfast_enabled', 'payment_pro') ? 'checked="true"' : ''); ?> name="payfast_enabled" value="1" />
                <?php _e('Enable PayFast as a method of payment', 'payment_pro'); ?>
            </label>
        </div>
    </div>
</div>
<div class="form-row payfast hide">
    <div class="form-label"><?php _e('PayFast Merchant ID', 'payment_pro'); ?></div>
    <div class="form-controls"><input type="text" class="xlarge" name="payfast_merchant_id" value="<?php echo payment_pro_decrypt(osc_get_preference('payfast_merchant_id', 'payment_pro')); ?>" /></div>
</div>
<div class="form-row payfast hide">
    <div class="form-label"><?php _e('PayFast Merchant Key', 'payment_pro'); ?></div>
    <div class="form-controls"><input type="text" class="xlarge" name="payfast_merchant_key" value="<?php echo payment_pro_decrypt(osc_get_preference('payfast_merchant_key', 'payment_pro')); ?>" /></div>
</div>
<div class="form-row payfast hide">
    <div class="form-label"><?php _e('PayFast Passphrase', 'payment_pro'); ?></div>
    <div class="form-controls"><input type="text" class="xlarge" name="payfast_passphrase" value="<?php echo payment_pro_decrypt(osc_get_preference('payfast_passphrase', 'payment_pro')); ?>" /></div>
</div>
<div class="form-row payfast hide">
    <div class="form-label"><?php _e('PayFast Sandbox'); ?></div>
    <div class="form-controls">
        <div class="form-label-checkbox">
            <label>
                <input type="checkbox" <?php echo (osc_get_preference('payfast_sandbox', 'payment_pro') ? 'checked="true"' : ''); ?> name="payfast_sandbox" value="1" />
                <?php _e('Use the sandbox environment to test before going live', 'payment_pro'); ?>
            </label>
        </div>
    </div>
</div>