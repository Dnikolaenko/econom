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
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_name; ?></td>
        <td><input name="colorcategory_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($colorcategory_description[$language['language_id']]) ? $colorcategory_description[$language['language_id']]['name'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
          <?php if (isset($error_name[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"> <?php echo $entry_tip; ?></td>
        <td><textarea name="colorcategory_description[<?php echo $language['language_id']; ?>][tip]" id="tip<?php echo $language['language_id']; ?>"><?php echo isset($colorcategory_description[$language['language_id']]) ? $colorcategory_description[$language['language_id']]['tip'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <?php } ?>
      <tr>
        <td><?php echo $entry_keyword; ?></td>
        <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="80" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('tip<?php echo $language['language_id']; ?>');
<?php } ?>
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>