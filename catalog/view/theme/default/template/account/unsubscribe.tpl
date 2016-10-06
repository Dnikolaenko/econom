<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
<div id="content">
  <div class="middle">
  <div class="heading"><?php echo $heading_title; ?></div>
  <?php echo $text_message; ?>
    <div class="buttons">
      <table>
        <tr>
          <td align="right" width="100%"><a onclick="location='<?php echo $continue; ?>'" class="button"><span><?php echo $button_continue; ?></span></a></td>
        </tr>
      </table>
    </div>
  </div>
</div>
</div>
<?php echo $footer; ?> 