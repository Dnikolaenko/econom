<div id="column_left">
  <?php foreach ($modules as $module) { ?>
  <?php echo ${$module['code']}; ?>
  <?php } ?>
  <?php if (($config_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom.' . $config_banner_ext)) || ($config_second_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom_second.' . $config_second_banner_ext))) { ?>
  <center>
  <?php if ($config_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom.' . $config_banner_ext)) { ?>
    <div style="margin-top: 15px;">
      <?php if ($config_banner_ext == 'swf') { ?>
          <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="230" height="125">
            <param name="movie" value="<?php echo $preview_banner; ?>" />
            <param name="scale" value="noborder" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent">
            <embed src="<?php echo $preview_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="230" height="125"></embed>
          </object>
      <?php } else { ?>
        <?php if ($config_banner_url) { ?>
          <a href="<?php echo $config_banner_url; ?>" target="_blank">
        <?php } ?>
          <img src="<?php echo $preview_banner; ?>" />
        <?php if ($config_banner_url) { ?>
          </a>
        <?php } ?>
      <?php } ?>
    </div>
  <?php } ?>
  <?php if ($config_second_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom_second.' . $config_second_banner_ext)) { ?>
    <div style="margin-top: 15px;">
      <?php if ($config_second_banner_ext == 'swf') { ?>
          <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="230" height="125">
            <param name="movie" value="<?php echo $preview_second_banner; ?>" />
            <param name="scale" value="noborder" />
            <param name="quality" value="high" />
            <param name="wmode" value="transparent">
            <embed src="<?php echo $preview_second_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="230" height="125"></embed>
          </object>
      <?php } else { ?>
        <?php if ($config_second_banner_url) { ?>
          <a href="<?php echo $config_second_banner_url; ?>" target="_blank">
        <?php } ?>
          <img src="<?php echo $preview_second_banner; ?>" />
        <?php if ($config_second_banner_url) { ?>
          </a>
        <?php } ?>
      <?php } ?>
    </div>
  <?php } ?>
  </center>
  <?php } ?>
</div>
