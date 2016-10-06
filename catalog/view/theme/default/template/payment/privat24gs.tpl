<form action="<?php echo $action; ?>" method="post" id="payment"  accept-charset="UTF-8">
        <input type="hidden" name="amt" value="<?php echo $amount; ?>" />
        <input type="hidden" name="ccy" value="<?php echo $currency; ?>" />
        <input type="hidden" name="merchant" value="<?php echo $merchant_id; ?>" />
        <input type="hidden" name="order" value="<?php echo $order_id; ?>" />
        <input type="hidden" name="details" value="<?php echo $description;  ?>" />
        <input type="hidden" name="ext_details" value="" />
        <input type="hidden" name="pay_way" value="privat24" />
        <input type="hidden" name="return_url" value="<?php echo $result_url; ?>" />
        <input type="hidden" name="server_url" value="<?php echo $server_url; ?>" />
  <div class="buttons">
    <div class="right"><a onclick="$('#payment').submit();" class="button"><span><?php echo $button_confirm; ?></span></a></div>
  </div>
</form>
