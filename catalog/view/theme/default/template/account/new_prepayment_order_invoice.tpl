<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/newinvoice.css" />
</head>
<body>
<div class="div1">
  <table width="100%">
    <tr align="center">
      <td colspan="2">
        <?php echo $text_warning_reserve; ?>
      </td>
    </tr>
    <tr>
      <td width="65%">
      <b><?php echo $text_supplier; ?></b>
      </td>
      <td width="35%" valign="top">
      <b><?php echo $text_customer; ?></b>
      </td>
    </tr>
    <tr>
      <td width="65%">
        <?php echo $supplier_address; ?>
      </td>
      <td width="35%" valign="top">
        <?php echo $payment_address; ?>
      </td>
    </tr>
  </table>
</div>
<div class="div2">
  <span class="h1"><?php echo $text_invoice_new; ?> <?php echo $order_id; ?></span><?php echo $text_from_date; ?><?php echo $date_added; ?><br />
  <?php echo $text_adv; ?>
</div>
<table class="product">
  <tr class="heading">
    <td align="center"><b><?php echo '№'; ?></b></td>
    <td align="center"><b><?php echo $column_product; ?></b></td>
    <td align="center"><b><?php echo $column_model; ?></b></td>
    <td align="center"><b><?php echo $column_unit_meas; ?></b></td>
    <td align="center"><b><?php echo $column_quantity; ?></b></td>
    <td align="center"><b><?php echo $column_price; ?>, <?php echo $column_currency; ?></b></td>
    <td align="center"><b><?php echo $column_total; ?>, <?php echo $column_currency; ?></b></td>
  </tr>
  <?php $counter = 1; ?>
  <?php foreach ($products as $product) { ?>
  <tr>
    <td align="center" width="3%"><?php echo $counter; ?></td>
    <td><?php echo ($product['prepayment'] < 1 ? $text_prepayment_50 : '') . $product['name']; ?>
      <?php foreach ($product['option'] as $option) { ?>
      <br />
      &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
      <?php } ?></td>
    <td><?php echo $product['model']; ?></td>
    <td align="center"><?php echo $text_unit_meas; ?></td>
    <td align="right"><?php echo $product['quantity']; ?></td>
    <td align="right"><?php echo $product['price']; ?></td>
    <td align="right"><?php echo $product['total']; ?></td>
  </tr>
  <?php if ($product['sborka']) { ?>
    <?php $counter = $counter + 1; ?>
    <tr>
      <td align="center" width="3%"><?php echo $counter; ?></td>
      <td><?php echo ($product['prepayment'] < 1 ? $text_prepayment_50 : '') . $text_sborka . ' ' . $product['name']; ?></td>
      <td>&nbsp;</td>
      <td align="center"><?php echo $text_sborka_unit_meas; ?></td>
      <td align="right"><?php echo $product['sborka_qty']; ?></td>
      <td align="right"><?php echo $product['sborka_cost']; ?></td>
      <td align="right"><?php echo $product['sborka_cost_total']; ?></td>
    </tr>
  <?php } ?>
  <?php $counter = $counter + 1; ?>
  <?php } ?>
  <tr>
    <td align="right" colspan="6"><b><?php echo $text_total_discount; ?></b></td>
    <td align="right"><?php echo number_format($total_discount, 2, '.', ''); ?></td>
  </tr>
  <tr>
    <td align="right" colspan="6"><b><?php echo $text_total_to_pay; ?></b></td>
    <td align="right"><?php echo number_format($total_to_pay, 2, '.', ''); ?></td>
  </tr>
</table>
<center><img alt="" src="catalog/view/theme/default/image/stamp33.png" /></center>
</body>
</html>