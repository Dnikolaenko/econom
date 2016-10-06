<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
<div id="content">
  <div class="middle">
    <div class="heading"><h1><?php echo $heading_title; ?></h1></div>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-bottom: 10px;"><?php echo $text_error; ?></div>
    <div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="location='<?php echo $continue; ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?> 