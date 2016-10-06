<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
<div id="content">
  <div class="middle">
    <div class="heading"><?php echo $heading_title; ?></div>
    <h1><?php echo $text_no_nds; ?></h1>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
      <table width="100%">
        <tr>
          <td width="33.3%" valign="top"><b><?php echo $text_order; ?></b><br />
            #<?php echo $order_id; ?><br />
            <br />
            <b><?php echo $text_email; ?></b><br />
            <?php echo $email; ?><br />
            <br />
            <b><?php echo $text_telephone; ?></b><br />
            <?php echo $telephone; ?><br />
            <br />
            <?php if ($fax) { ?>
            <b><?php echo $text_fax; ?></b><br />
            <?php echo $fax; ?><br />
            <br />
            <?php } ?>
            <?php if ($shipping_method) { ?>
            <b><?php echo $text_shipping_method; ?></b><br />
            <?php echo $shipping_method; ?><br />
            <br />
            <?php } ?>
            <?php if ($payment_method) { ?>
            <b><?php echo $text_payment_method; ?></b><br />
            <?php echo $payment_method; ?><br />
            <?php } ?>
            <?php if ($credit_id > 0) { ?>
            <b><?php echo $text_credit; ?></b><br />
            <?php echo $credit_name; ?><br />
            <?php } ?>
          </td>
          <td width="33.3%" valign="top"><?php if ($shipping_address) { ?>
            <b><?php echo $text_shipping_address; ?></b><br />
            <?php echo $shipping_address; ?><br />
            <?php } ?></td>
          <td width="33.3%" valign="top"><b><?php echo $text_payment_address; ?></b><br />
            <?php echo $payment_address; ?><br /></td>
        </tr>
      </table>
    </div>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
      <table width="100%">
        <tr>
          <th align="left"><?php echo $text_product; ?></th>
          <th align="left"><?php echo $text_model; ?></th>
          <th align="right"><?php echo $text_quantity; ?></th>
          <th align="right"><?php echo $text_price; ?></th>
          <th align="right"><?php echo $text_total; ?></th>
        </tr>
        <?php foreach ($products as $product) { ?>
        <?php if($product['nds'] == 0) { ?>
        <tr>
          <td align="left" valign="top"><?php echo $product['name']; ?>
            <?php foreach ($product['option'] as $option) { ?>
            <br />
            &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
            <?php } ?></td>
          <td align="left" valign="top"><?php echo $product['model']; ?></td>
          <td align="right" valign="top"><?php echo $product['quantity']; ?></td>
          <td align="right" valign="top"><?php echo $product['price']; ?></td>
          <td align="right" valign="top"><?php echo $product['total']; ?></td>
        </tr>
        <?php } ?>
        <?php if ($product['sborka']) { ?>
        <tr>
          <td align="left" valign="top"><?php echo $text_sborka . ' ' . $product['name']; ?>
          <td align="left" valign="top">&nbsp;</td>
          <td align="right" valign="top"><?php echo $product['sborka_qty']; ?></td>
          <td align="right" valign="top"><?php echo $product['sborka_cost']; ?></td>
          <td align="right" valign="top"><?php echo $product['sborka_cost_total']; ?></td>
        </tr>
        <?php } ?>
        <?php } ?>
      </table>
      <br />
      <div style="width: 100%; display: inline-block;">
        <table style="float: right; display: inline-block;">
            <tr>
    <td align="right" colspan="6"><b><?php echo $totals['0']['title']; ?></b></td>
    <td align="right"><?php echo number_format($totals['0']['val_no_nds'], 2, '.', ''); ?> грн</td>
  </tr>
   <tr>
    <td align="right" colspan="6"><b><?php echo $totals['1']['title']; ?></b></td>
    <td align="right"><?php echo number_format($totals['1']['value'], 2, '.', ''); ?> грн</td>
  </tr>
    <tr>
    <td align="right" colspan="6"><b><?php echo $totals['2']['title']; ?></b></td>
    <td align="right"><?php echo number_format($totals['2']['value'], 2, '.', ''); ?> грн</td>
  </tr>
   <tr>
    <td align="right" colspan="6"><b><?php echo $totals['3']['title']; ?></b></td>
    <td align="right"><?php echo number_format($totals['3']['val_no_nds']+$totals['2']['value']-$totals['1']['value'], 2, '.', ''); ?> грн</td>
  </tr>
        </table>
      </div>
    </div>
    <?php if ($comment) { ?>
    <b style="margin-bottom: 2px; display: block;"><?php echo $text_comment; ?></b>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"><?php echo $comment; ?></div>
    <?php } ?>
    <b style="margin-bottom: 2px; display: block;"><?php echo $text_order_history; ?></b>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;">
      <table width="536">
        <tr>
          <th align="left"><?php echo $column_date_added; ?></th>
          <th align="left"><?php echo $column_status; ?></th>
          <th align="left"><?php echo $column_comment; ?></th>
        </tr>
        <?php foreach ($historys as $history) { ?>
        <tr>
          <td valign="top"><?php echo $history['date_added']; ?></td>
          <td valign="top"><?php echo $history['status']; ?></td>
          <td valign="top"><?php echo $history['comment']; ?></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <div class="buttons">
      <table>
        <tr>
          <td align="left" width="35%"><a onclick="window.open('<?php echo $prepayment_invoice; ?>');" class="button"><span><?php echo $button_prepayment_invoice; ?></span></a></td>
          <td align="center" width="20%"><a onclick="window.open('<?php echo $invoice; ?>');" class="button"><span><?php echo $button_invoice; ?></span></a></td>
          <?php if (isset($data)) { ?>
          <td align="right" width="15%">
            <form method="POST" action="https://www.liqpay.com/api/checkout" id="liqpay" accept-charset="utf-8">
              <input type="hidden" name="data"  value="<?php echo $data; ?>" />
              <input type="hidden" name="signature" value="<?php echo $signature; ?>" />
              <a onclick="ga('send', 'event', 'oplata_online', 'click', 'button'); setTimeout(function(){ $('#liqpay').submit(); }, 500); return;" class="button"><span><?php echo $button_pay; ?></span></a>
            </form>
          </td>
          <?php } ?>
          <td align="right" width="25%"><a onclick="location='<?php echo $continue; ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
    <div class="payu"><img src="/image/payu/logos-07.png" width="100%" /></div>
  </div>
</div>
</div>
<?php echo $footer; ?> 