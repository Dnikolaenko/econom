<div style="text-align: left; color: #999; margin-bottom: 4px;"><?php echo $entry_language; ?>
  <?php if (count($languages) > 1) { ?>
  <?php foreach ($languages as $language) { ?>
  <?php //if ($language['status']) { ?>
  <form id="lang_<?php echo $language['code']; ?>" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div style="display: inline;">
      <?php if ($language['code'] == $default) { ?>
        <span style="color:#fff"><?php echo $language['name']; ?></span>
      <?php } else { ?>
        <a href='#' onclick="javascript:$('#lang_<?php echo $language['code']; ?>').submit();"><?php echo $language['name']; ?></a>
      <?php } ?>
      <input type="hidden" name="language_code" value="<?php echo $language['code']; ?>" />
      <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    </div>
  </form>
  <?php //} ?>
  <?php } ?>
  <?php } ?>
</div>
