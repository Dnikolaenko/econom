<?php echo $header; ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
  <div style="margin-top: 60px;">
    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="100%" height="500">
      <param name="movie" value="/admin/contacts/Manager.swf" />
      <param name="scale" value="noborder" />
      <param name="quality" value="high" />
      <param name="bgcolor" value="#869ca7" />
      <embed src="/admin/contacts/Manager.swf" wmode="" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="100%" height="500"></embed>
    </object>
  </div>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>