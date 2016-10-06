<div id="column_right">
  <?php foreach ($modules as $module) { ?>
  <?php echo ${$module['code']}; ?>
  <?php } ?>
  <?php if (($config_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom.' . $config_banner_ext)) || ($config_second_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom_second.' . $config_second_banner_ext))) { ?>
  <script type="text/javascript"><!--
    <?php if (($config_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom.' . $config_banner_ext)) && ($config_second_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_bottom_second.' . $config_second_banner_ext))) { ?>
      $("#content > .middle").css("min-height", "695px");
    <?php } else { ?>
      $("#content > .middle").css("min-height", "550px");
    <?php } ?>

    theObjects = $("object");
    for (var i = 0; i < theObjects.length; i++) {
        theObjects[i].outerHTML = theObjects[i].outerHTML;
    }
  //--></script>
  <?php } ?>
</div>