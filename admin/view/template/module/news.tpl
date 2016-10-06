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
        <td><?php echo $entry_limit; ?></td>
        <td><input type="text" name="news_limit" value="<?php echo $news_limit; ?>" size="1" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_position; ?></td>
        <td><select name="news_position">
            <?php if ($news_position == 'left') { ?>
            <option value="left" selected="selected"><?php echo $text_left; ?></option>
            <?php } else { ?>
            <option value="left"><?php echo $text_left; ?></option>
            <?php } ?>
            <?php if ($news_position == 'right') { ?>
            <option value="right" selected="selected"><?php echo $text_right; ?></option>
            <?php } else { ?>
            <option value="right"><?php echo $text_right; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_display_on_home; ?></td>
        <td><?php if ($news_display_on_home) { ?>
          <input type="radio" name="news_display_on_home" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="news_display_on_home" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="news_display_on_home" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="news_display_on_home" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="news_status">
            <?php if ($news_status) { ?>
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
        <td><input type="text" name="news_sort_order" value="<?php echo $news_sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>