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
        <td><select name="yandex_market_v2_status">
            <?php if ($yandex_market_v2_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_data_feed_on_fly; ?></td>
        <td><i><?php echo $data_feed_on_fly; ?></i></td>
      </tr>
      <tr>
        <td><?php echo $entry_data_feed_schedule; ?></td>
        <td><i><?php echo $data_feed_schedule; ?></i></td>
      </tr>
      <tr>
        <td><?php echo $entry_data_feed_schedule_time; ?></td>
        <td><i><?php echo $text_data_feed_schedule_time; ?></i></td>
      </tr>
      <tr>
        <td><?php echo $entry_export_category_list; ?></td>
        <td>
         <div class="scrollbox_wide">
            <?php $class = 'odd'; ?>
            <?php foreach ($categories as $category) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <div class="<?php echo $class; ?>">
              <?php if (in_array($category['category_id'], $export_category_list)) { ?>
              <input type="checkbox" parent="<?php echo $category['parent_id']; ?>" name="export_category_list[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
              <?php echo $category['name']; ?>
              <?php } else { ?>
              <input type="checkbox" parent="<?php echo $category['parent_id']; ?>" name="export_category_list[]" value="<?php echo $category['category_id']; ?>" />
              <?php echo $category['name']; ?>
              <?php } ?>
            </div>
            <?php } ?>
          </div>
        </td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript"><!--
$.tabs('.tabs a');
$(document).ready(function () {
  $("input:checkbox").each(function(){
   $(this).change(function(){
     if($(this).attr("checked")){
       // делаем что-то, когда чекбокс включен
       if($(this).attr("parent") !== "0") {
        var parent = $("input:checkbox[value='"+$(this).attr("parent")+"']");
        parent.attr("checked", "checked");
        parent.trigger('change');
       }
     } else {
      // делаем что-то другое, когда чекбокс выключен
      $("input:checkbox[parent='"+$(this).attr("value")+"']").each(function(){ $(this).removeAttr("checked"); $(this).trigger('change'); });
     }
   });
  });
});

//--></script>
<?php echo $footer; ?>