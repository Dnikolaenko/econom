<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 <?php /*style="background-image: url('view/image/backup.png');" */ ?>><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_restore"></span><span class="button_middle"><?php echo $button_import; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $export; ?>'" class="button"><span class="button_left button_backup"></span><span class="button_middle"><?php echo $button_export; ?></span><span class="button_right"></span></a></div>
  </div>
  <div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <div id="tab_general" class="page">
      <table class="form">
        <tr>
          <td colspan="2"><?php echo $entry_description; ?></td>
        </tr>
        <tr>
          <td width="25%"><?php echo $entry_restore; ?></td>
          <td><input type="file" name="upload" /></td>
        </tr>
      </table>
    </div>
    </form>
</div>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>