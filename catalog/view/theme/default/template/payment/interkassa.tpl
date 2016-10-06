<form id="payment" name="payment" action="<?php echo $action ?>" method="POST"
enctype="application/x-www-form-urlencoded">
<input type="hidden" name="ik_shop_id" value="<?php echo $ik_shop_id; ?>">
<input type="hidden" name="ik_payment_amount" value="<?php echo $ik_payment_amount; ?>">
<input type="hidden" name="ik_payment_id" value="<?php echo $ik_payment_id; ?>">
<input type="hidden" name="ik_payment_desc" value="<?php echo $ik_payment_desc; ?>">
<input type="hidden" name="ik_status_url" value="<?php echo $ik_status_url; ?>"/>
<input type="hidden" name="ik_status_method" value="<?php echo $ik_status_method; ?>"/>
<input type="hidden" name="ik_success_url" value="<?php echo $ik_success_url; ?>"/>
<input type="hidden" name="ik_success_method" value="<?php echo $ik_success_method; ?>"/>
</form>
<div class="buttons">
    <div class="right"><a onclick="$('#payment').submit();" class="button"><span><?php echo $button_confirm; ?></span></a></div>
</div>