<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
      <div id="content">
          <div id="middle">
              <form method="POST" action="https://www.liqpay.com/api/checkout" id="liqpay" accept-charset="utf-8">
              <input type="hidden" name="data"  value="<?php echo $data; ?>" />
              <input type="hidden" name="signature" value="<?php echo $signature; ?>" />
              <a onclick="ga('send', 'event', 'oplata_online', 'click', 'button'); setTimeout(function(){ $('#liqpay').submit(); }, 500); return;" class="button"><span>Оплата</span></a>
            </form>
          </div>
     </div>
</div>
<?php echo $footer; ?>
<script type="text/javascript">
    $( document ).ready(function() {
        $("#liqpay").submit();
    });   
</script>