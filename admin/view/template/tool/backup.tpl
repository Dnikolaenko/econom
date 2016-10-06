<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <?php /*<div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_restore"></span><span class="button_middle"><?php echo $button_restore; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $backup; ?>'" class="button"><span class="button_left button_backup"></span><span class="button_middle"><?php echo $button_backup; ?></span><span class="button_right"></span></a></div> */?>
  <div class="buttons"><a onclick="dumper();" class="button"><span class="button_left button_restore"></span><span class="button_middle"><?php echo $button_enter; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
<?php /*<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form"> */?>
  <div id="tab_general" class="page">
    <?php /*<table class="form">
      <tr>
        <td width="25%"><?php echo $entry_restore; ?></td>
        <td><input type="file" name="import" /></td>
      </tr>
    </table>*/ ?>
  </div>
<?php /*</form>*/?>
<script type="text/javascript"><!--
function dumper() {
  $.ajax({
    type: 'post',
    url: 'backup/index.php',
    data: ({user : '<?php echo DB_USERNAME;?>', pass : '<?php echo DB_PASSWORD;?>', host : '<?php echo DB_HOSTNAME;?>'}),
    complete: function () {
      location = 'backup/';
    }
    });
}
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>