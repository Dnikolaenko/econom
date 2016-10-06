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
        <td><input name="credit_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($credit_description[$language['language_id']]) ? $credit_description[$language['language_id']]['name'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
          <?php if (isset($error_name[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <?php /*
      <tr>
        <td><?php echo $entry_page_title; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][page_title]" cols="77" rows="2"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['page_title'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_description; ?></td>
        <td><textarea name="credit_description[<?php echo $language['language_id']; ?>][meta_description]" cols="77" rows="5"><?php echo isset($credit_description[$language['language_id']]) ? $credit_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_keyword; ?></td>
        <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
      </tr>
      */ ?>
      <tr>
        <td><?php echo $entry_description; ?></td>
        <td><textarea name="credit_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($credit_description[$language['language_id']]) ? $credit_description[$language['language_id']]['description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <?php } ?>
      <tr>
        <td><?php echo $entry_image; ?></td>
        <td><input type="file" name="image" size="80" /></td>
      </tr>
      <tr>
        <td></td>
        <td><img src="<?php echo $preview; ?>" alt="" style="border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="status">
            <?php if ($status) { ?>
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
        <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
<?php } ?>
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>