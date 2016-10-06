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
        <td width="25%"><span class="required">*</span> <?php echo $entry_name; ?></td>
        <td><?php if ($error_name) { ?>
            <span class="error"><?php echo $error_name; ?></span>
            <?php } ?><br />
            <input name="name" value="<?php echo $name; ?>" size="80" /></td>
      </tr>
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_email; ?></td>
        <td><?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?><br />
        <input name="email" value="<?php echo $email; ?>" size="80" /></td>
      </tr>
      <tr>
        <td width="25%"><span class="required">*</span> <?php echo $entry_text; ?></td>
        <td><textarea name="text" id="text"><?php echo $text; ?></textarea></td>
      </tr>
      <tr>
        <td width="25%"> <?php echo $entry_answer; ?></td>
        <td><textarea name="answer" id="answer"><?php echo $answer; ?></textarea></td>
      </tr>
      <tr>
        <td width="25%"> <?php echo $entry_published; ?></td>
        <td><?php if ($published) { ?>
          <input type="radio" name="published" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="published" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="published" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="published" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="25%"> <?php echo $entry_date_added; ?></td>
        <td><input name="date_added" value="<?php echo $date_added; ?>" size="64"/></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
CKEDITOR.replace('text');
CKEDITOR.replace('answer');
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>