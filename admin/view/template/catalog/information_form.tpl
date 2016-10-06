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

  <input type="hidden" name="type" value="<?php echo $type; ?>" />
  <?php if($type !="news") {?>
		<input type="hidden" name="date_added" value="<?php echo $date_added; ?>" />
		<?php foreach ($languages as $language) { ?>
		<input type="hidden" name="information_description[<?php echo $language['language_id']; ?>][anons]" value=" " />
		<?php } ?>
  <?php } else {?>
		<input type="hidden" name="name" value="<?php echo $name; ?>" />
  <?php } ?>
  
  <div id="tab_general" class="page">
    <table class="form">
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_title; ?></td>
        <td><input name="information_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['title'] : ''; ?>" size="64"/>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
          <?php if (isset($error_title[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_title[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_page_title; ?></td>
        <td><textarea name="information_description[<?php echo $language['language_id']; ?>][page_title]" cols="77" rows="1"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['page_title'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_description; ?></td>
        <td><textarea name="information_description[<?php echo $language['language_id']; ?>][meta_description]" cols="77" rows="3"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_keywords; ?></td>
        <td><textarea name="information_description[<?php echo $language['language_id']; ?>][meta_keywords]" cols="77" rows="3"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['meta_keywords'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <?php } ?>
      <?php if($type =="news") { ?>
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td><?php echo $entry_anons; ?></td>
        <td><input type="text" name="information_description[<?php echo $language['language_id']; ?>][anons]" value="<?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['anons'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" />
        </td>
      </tr>
      <?php } ?>
      <?php } ?>
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td><span class="required">*</span> <?php echo $entry_description; ?></td>
        <td><textarea name="information_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($information_description[$language['language_id']]) ? $information_description[$language['language_id']]['description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" />
          <?php if (isset($error_description[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_description[$language['language_id']]; ?></span>
          <?php } ?></td>
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
      <?php if($type == "news") {?>
      <tr>
        <td><?php echo $entry_date_added; ?></td>
        <td><input name="date_added" value="<?php echo $date_added; ?>" class="date"/></td>
        <input type="hidden" name="parent_information_id" value="0" />
      </tr>
	  <?php } else  {?>
      <tr>
        <td><?php echo $entry_name; ?></td>
        <td><input name="name" value="<?php echo $name; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_parent; ?></td>
        <td><select name="parent_information_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($informations as $information) { ?>
            <?php if ($information['information_id'] == $parent_information_id) { ?>
            <option value="<?php echo $information['information_id']; ?>" selected="selected"><?php echo $information['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $information['information_id']; ?>"><?php echo $information['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <?php } ?>
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