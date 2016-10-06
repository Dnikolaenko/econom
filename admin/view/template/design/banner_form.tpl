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
           <td><span class="required">*</span> <?php echo $entry_name; ?></td>
           <td><input type="text" name="name" value="<?php echo $name; ?>" size="80" />
             <?php if ($error_name) { ?>
             <span class="error"><?php echo $error_name; ?></span>
             <?php } ?></td>
         </tr>
         <tr>
           <td><?php echo $entry_sort_order; ?></td>
           <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
         </tr>
         <tr>
           <td><?php echo $entry_position; ?></td>
           <td><?php if ($position == 'h') { ?>
             <input type="radio" name="position" value="h" checked="checked" />
             <?php echo $text_home; ?>
             <input type="radio" name="position" value="t" />
             <?php echo $text_header; ?>
             <?php } else { ?>
             <input type="radio" name="position" value="h" />
             <?php echo $text_home; ?>
             <input type="radio" name="position" value="t" checked="checked" />
             <?php echo $text_header; ?>
             <?php } ?>
           </td>
         </tr>
         <tr>
           <td><?php echo $entry_view_type; ?></td>
           <td>
             <?php if ($view_type == 's') { ?>
             <input type="radio" name="view_type" value="s" checked="checked" />
             <?php echo $text_slideshow; ?>
             <input type="radio" name="view_type" value="i" <?php echo ($position == 'h'? 'disabled="disabled"' : '') ?>/>
             <?php echo $text_image; ?>
             <?php } else { ?>
             <input type="radio" name="view_type" value="s" />
             <?php echo $text_slideshow; ?>
             <input type="radio" name="view_type" value="i" checked="checked" />
             <?php echo $text_image; ?>
             <?php } ?>
           </td>
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
       </table>
       <table id="images" class="list">
         <thead>
           <tr>
             <td class="left"><?php echo $entry_title; ?></td>
             <td class="left"><?php echo $entry_link; ?></td>
             <td class="left"><?php echo $entry_image; ?></td>
             <td class="left"><?php echo $column_s_order; ?></td>
             <td></td>
           </tr>
         </thead>
         <?php $image_row = 0; ?>
         <?php foreach ($banner_images as $banner_image) { ?>
         <tbody id="image-row<?php echo $image_row; ?>">
          <tr>
             <td class="left"><?php foreach ($languages as $language) { ?>
               <input type="text" name="banner_image[<?php echo $image_row; ?>][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($banner_image['banner_image_description'][$language['language_id']]) ? $banner_image['banner_image_description'][$language['language_id']]['title'] : ''; ?>" />
               <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
               <?php if (isset($error_banner_image[$image_row][$language['language_id']])) { ?>
               <span class="error"><?php echo $error_banner_image[$image_row][$language['language_id']]; ?></span>
               <?php } ?>
               <?php } ?></td>
             <td class="left"><input type="text" name="banner_image[<?php echo $image_row; ?>][link]" value="<?php echo $banner_image['link']; ?>" /></td>
             <td class="left"><div class="image"><img src="<?php echo $banner_image['thumb']; ?>" alt="" id="thumb<?php echo $image_row; ?>" />
                 <input type="hidden" name="banner_image[<?php echo $image_row; ?>][image]" value="<?php echo $banner_image['image']; ?>" id="image<?php echo $image_row; ?>"  />
                 <br />
                 <a onclick="image_upload('image<?php echo $image_row; ?>', 'thumb<?php echo $image_row; ?>');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb<?php echo $image_row; ?>').attr('src', '<?php echo $no_image; ?>'); $('#image<?php echo $image_row; ?>').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
             <td class="left"><input name="banner_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $banner_image['sort_order']; ?>" size="1" /></td>
             <td class="left">
              <a onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a>
             </td>
           </tr>
         </tbody>
         <?php $image_row++; ?>
         <?php } ?>
         <tfoot>
           <tr>
             <td colspan="4"></td>
             <td class="left">
               <a onclick="addImage();" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_banner; ?></span><span class="button_right"></span></a>
             </td>
           </tr>
         </tfoot>
       </table>
  </div>
</form>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
html  = '<tbody id="image-row' + image_row + '">';
html += '<tr>';
html += '<td class="left">';
<?php foreach ($languages as $language) { ?>
html += '<input type="text" name="banner_image[' + image_row + '][banner_image_description][<?php echo $language['language_id']; ?>][title]" value="" /> <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
<?php } ?>
html += '</td>';
html += '<td class="left"><input type="text" name="banner_image[' + image_row + '][link]" value="" /></td>';
html += '<td class="left"><div class="image"><img src="<?php echo $no_image; ?>" alt="" id="thumb' + image_row + '" /><input type="hidden" name="banner_image[' + image_row + '][image]" value="" id="image' + image_row + '" /><br /><a onclick="image_upload(\'image' + image_row + '\', \'thumb' + image_row + '\');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$(\'#thumb' + image_row + '\').attr(\'src\', \'<?php echo $no_image; ?>\'); $(\'#image' + image_row + '\').attr(\'value\', \'\');"><?php echo $text_clear; ?></a></div></td>';
html += '<td class="left"><input name="banner_image[' + image_row  + '][sort_order]" value="0" size="1" /></td>'
html += '<td class="left"><a onclick="$(\'#image-row' + image_row  + '\').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
html += '</tr>';
html += '</tbody>'; 

$('#images tfoot').before(html);

image_row++;
}
//--></script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
$('#dialog').remove();

$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
//$('#dialog').modal();

$('#dialog').dialog({
title: '<?php echo $text_image_manager; ?>',
close: function (event, ui) {
if ($('#' + field).attr('value')) {
$.ajax({
url: 'index.php?route=common/filemanager/image&image=' + encodeURIComponent($('#' + field).attr('value')),
dataType: 'text',
success: function(data) {
$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
}
});
}
},
bgiframe: false,
width: 700,
height: 400,
resizable: false,
modal: false
});
};
//--></script>
<script type="text/javascript"><!--
$(document).ready(function () {
  $("input:radio[name='position']").each(function(){
   $(this).change(function(){
     if($(this).attr("checked")) {
       if($(this).val() === "h") {
        $("input:radio[value='i']").attr("disabled", "disabled");
        $("input:radio[value='i']").removeAttr("checked");
        $("input:radio[value='s']").attr("checked", "checked");
       } else {
        $("input:radio[value='i']").removeAttr("disabled");
       }
     } else {
      $("input:radio[value='i']").removeAttr("disabled");
     }
   });
  });
});
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>