<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="location='<?php echo $insert; ?>'" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_insert; ?></span><span class="button_right"></span></a><a onclick="$('#form').submit();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_delete; ?></span><span class="button_right"></span></a></div>
</div>
<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
  <table class="list">
    <thead>
      <tr>
        <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
        <td class="left"><?php echo $column_name; ?></td>
        <td class="center"><?php echo $column_status; ?></td>
        <td class="left"><?php echo $column_sort_order; ?></td>
        <td class="right"><?php echo $column_action; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($credits) { ?>
      <?php $class = 'odd'; ?>
      <?php foreach ($credits as $credit) { ?>
      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
      <tr class="<?php echo $class; ?>">
        <td style="text-align: center;"><?php if ($credit['selected']) { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $credit['credit_id']; ?>" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $credit['credit_id']; ?>" />
          <?php } ?></td>
        <td class="left"><?php echo $credit['name']; ?></td>
        <td class="center"><?php echo $credit['status']; ?></td>
        <td class="left"><?php echo $credit['sort_order']; ?></td>
        <td class="right"><?php foreach ($credit['action'] as $action) { ?>
          [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
          <?php } ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr class="even">
        <td class="center" colspan="5"><?php echo $text_no_results; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</form>
<?php echo $footer; ?>