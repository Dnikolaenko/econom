<?php echo $header; ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
  <div class="box">
  <div class="tabs"><a tab="#tab_general"><?php echo "Экспорт фида"; ?></a></div>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <table class="form">
  <tr>
  <td><?php echo $entry_xml; ?></td>
  <td><button id="xml" name="xml">Export</button></td>
  </tr>
   <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="gaxml_status">
            <?php if ($gaxml_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
  </table>
  </form>
  </div>
</div>  
<?php echo $footer; ?>