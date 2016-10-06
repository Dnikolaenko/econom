<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/stylesheet.css" />
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="view/stylesheet/ie6.css" />
<![endif]-->
<script type="text/javascript" src="view/javascript/jquery/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/superfish/js/superfish.js"></script>
<script type="text/javascript" src="view/javascript/jquery/tab.js"></script>
<script type="text/javascript" src="view/javascript/jquery/jquery.ui.block.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="view/javascript/jquery/ui/external/jquery.bgiframe-2.1.2.js"></script>
<script type="text/javascript">
function pingServer() {
$.ajax({ url: location.href });
}
$(document).ready(function() {
setInterval('pingServer()', 20000);
});
</script>
</head>
<body>
<script type="text/javascript"><!--
  $.blockUI({fadeIn: 1000, message: '<H1><?php echo $text_loading; ?></H1>'});
//--></script>
<div id="header">
  <div class="div1">
    <div class="div2"><?php echo $text_heading; ?></div>
    <?php if ($logged) { ?>
    <div class="div3"><?php echo $user; ?> | <a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></div>
    <?php } ?>
  </div>
</div>
<?php echo $menu; ?>
<div id="container">
<div id="column_left"></div>
<div id="content">
<?php if ($breadcrumbs) { ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
  <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php } ?>
<script type="text/javascript"><!--
$(document).ready(function () {
  $.unblockUI();
});
//--></script>