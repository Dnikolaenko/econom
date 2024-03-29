<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
    <table class="form">
      <tr>
        <td width="25%"><?php echo $entry_status; ?></td>
        <td><select name="order_discount_status">
            <?php if ($order_discount_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input type="text" name="order_discount_sort_order" value="<?php echo $order_discount_sort_order; ?>" size="1" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_discount_from; ?> <input type="text" name="order_discount_sum1" value="<?php echo $order_discount_sum1; ?>" /></td>
        <td> = <input type="text" name="order_discount_percent1" value="<?php echo $order_discount_percent1; ?>" /> %</td>
      </tr>
      <tr>
        <td><?php echo $entry_discount_from; ?> <input type="text" name="order_discount_sum2" value="<?php echo $order_discount_sum2; ?>" /></td>
        <td> = <input type="text" name="order_discount_percent2" value="<?php echo $order_discount_percent2; ?>" /> %</td>
      </tr>
      <tr>
        <td><?php echo $entry_discount_from; ?> <input type="text" name="order_discount_sum3" value="<?php echo $order_discount_sum3; ?>" /></td>
        <td> = <input type="text" name="order_discount_percent3" value="<?php echo $order_discount_percent3; ?>" /> %</td>
      </tr>
      <tr>
        <td><?php echo $entry_discount_from; ?> <input type="text" name="order_discount_sum4" value="<?php echo $order_discount_sum4; ?>" /></td>
        <td> = <input type="text" name="order_discount_percent4" value="<?php echo $order_discount_percent4; ?>" /> %</td>
      </tr>
      <tr>
        <td><?php echo $entry_discount_from; ?> <input type="text" name="order_discount_sum5" value="<?php echo $order_discount_sum5; ?>" /></td>
        <td> = <input type="text" name="order_discount_percent5" value="<?php echo $order_discount_percent5; ?>" /> %</td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript"><!-- 
$.tabs('.tabs a');  
//--></script>
<?php echo $footer; ?>