<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_data"><?php echo $tab_data; ?></a><a tab="#tab_installation"><?php echo $tab_installation; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
    <table class="form">
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_name; ?></td>
        <td><input name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
          <?php if (isset($error_name[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_index_description; ?></td>
        <td><input name="category_description[<?php echo $language['language_id']; ?>][index_description]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['index_description'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
          <?php if (isset($error_index_description[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_index_description[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_page_title; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][page_title]" cols="77" rows="2"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['page_title'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_description; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][meta_description]" cols="77" rows="3"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_keywords; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][meta_keywords]" cols="77" rows="3"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['meta_keywords'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_description; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td width="25%"> <?php echo $entry_tip; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][tip]" id="tip<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['tip'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td width="25%"> <?php echo $entry_bottom_description; ?></td>
        <td><textarea name="category_description[<?php echo $language['language_id']; ?>][bottom_description]" id="bottom_description<?php echo $language['language_id']; ?>"><?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['bottom_description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div id="tab_data" class="page">
    <table class="form">
      <tr>
        <td><?php echo $entry_category; ?></td>
        <td><select name="parent_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($categories as $category) { ?>
            <?php if ($category['category_id'] == $parent_id) { ?>
            <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_keyword; ?></td>
        <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="80" /></td>
      </tr>

      <tr>
        <td width="25%"><?php echo $entry_display_images; ?></td>
        <td><?php if ($display_images) { ?>
          <input type="radio" name="display_images" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="display_images" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="display_images" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="display_images" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>

      <tr>
        <td><?php echo $entry_image; ?></td>
        <td><input type="file" name="image" size="80" /></td>
      </tr>
      <tr>
        <td></td>
        <td><img src="<?php echo $preview; ?>" alt="" style="border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image1; ?></td>
        <td><input type="file" name="image1" size="80" /></td>
      </tr>
      <tr>
        <td></td>
        <td><img src="<?php echo $preview1; ?>" alt="" style="border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image2; ?></td>
        <td><input type="file" name="image2" size="80" /></td>
      </tr>
      <tr>
        <td></td>
        <td><img src="<?php echo $preview2; ?>" alt="" style="border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_yml_export; ?></td>
        <td><?php if ($yml_export) { ?>
          <input type="radio" name="yml_export" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="yml_export" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="yml_export" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="yml_export" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_yandex_export; ?></td>
        <td><?php if ($yandex_export) { ?>
          <input type="radio" name="yandex_export" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="yandex_export" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="yandex_export" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="yandex_export" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_expanded; ?></td>
        <td><?php if ($expanded) { ?>
          <input type="radio" name="expanded" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="expanded" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="expanded" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="expanded" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_external; ?></td>
        <td><?php if ($external) { ?>
          <input type="radio" name="external" value="1" checked="checked" onclick="external_link_show_hide(this);" />
          <?php echo $text_yes; ?>
          <input type="radio" name="external" value="0" onclick="external_link_show_hide(this);" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="external" value="1" onclick="external_link_show_hide(this);" />
          <?php echo $text_yes; ?>
          <input type="radio" name="external" value="0" checked="checked" onclick="external_link_show_hide(this);" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <?php if ($external) { ?>
      <tr id="external_link">
      <?php } else { ?>
      <tr id="external_link" style="display: none;">
      <?php } ?>
        <td><?php echo $entry_external_link; ?></td>
        <td><input type="text" name="external_link" value="<?php echo $external_link; ?>" size="80" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_hide; ?></td>
        <td><?php if ($hide) { ?>
          <input type="radio" name="hide" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="hide" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="hide" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="hide" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
 <div id="tab_installation" class="page">
  <table class="form">
   <tr>
    <td><?php echo $entry_installation_percent; ?></td>
    <td><input type="text" name="installation_percent" value="<?php echo $installation_percent; ?>" size="4" />%<?php echo $entry_installation_threshold; ?></td>
    <td><input type="text" name="installation_threshold" value="<?php echo $installation_threshold; ?>" size="4" /></td>
   </tr>
   <tr>
    <td><?php echo $entry_update_product_installation; ?></td>
    <td colspan="2">
     <input type="radio" name="update_product_installation" value="1" />
     <?php echo $text_yes; ?>
     <input type="radio" name="update_product_installation" value="0" checked="checked" />
     <?php echo $text_no; ?>
    </td>
   </tr>
  </table>
 </div>
</form>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
CKEDITOR.replace('tip<?php echo $language['language_id']; ?>');
CKEDITOR.replace('bottom_description<?php echo $language['language_id']; ?>');
<?php } ?>
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
// 120902 ET-120828 External links to categories Begin
function external_link_show_hide(radio){
  if (radio.value === "1") {
    $('#external_link').show();
  } else {
    $('#external_link').hide();
  }
}
// 120902 ET-120828 External links to categories End
//--></script>
<?php echo $footer; ?>