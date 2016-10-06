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
        <td class="right"><?php echo $column_sort_order; ?></td>
        <td class="right"><?php echo $column_action; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if ($advcategories) { ?>
      <?php $class = 'odd'; ?>
      <?php foreach ($advcategories as $advcategory) { ?>
      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
      <tr class="<?php echo $class; ?>">
        <td style="text-align: center;"><?php if ($advcategory['selected']) { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $advcategory['advcategory_id']; ?>" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="selected[]" value="<?php echo $advcategory['advcategory_id']; ?>" />
          <?php } ?></td>
        <td class="left"><?php echo $advcategory['name']; ?></td>
        <td class="right"><?php echo $advcategory['sort_order']; ?></td>
        <td class="right"><?php foreach ($advcategory['action'] as $action) { ?>
          [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
          <?php } ?></td>
      </tr>
      <?php } ?>
      <?php } else { ?>
      <tr class="even">
        <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</form>
<?php echo $footer; ?>