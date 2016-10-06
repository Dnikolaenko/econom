<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
      <div id="content">
        <div id="middle">
              <form method="POST" action="https://www.liqpay.com/api/checkout" id="liqpays" accept-charset="utf-8">
              <input type="hidden" name="data"  value="<?php echo $datas; ?>" />
              <input type="hidden" name="signature" value="<?php echo $signatures; ?>" />
              <a onclick="ga('send', 'event', 'oplata_online', 'click', 'button'); setTimeout(function(){ $('#liqpays').submit(); }, 500); return;" class="button"><span>Оплата</span></a>
              </form>
        </div>
     </div>
<?php echo $footer; ?>
<script type="text/javascript">
    $( document ).ready(function() {
        $("#liqpays").submit();
    });   
</script>