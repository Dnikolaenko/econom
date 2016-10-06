<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
<div id="content">
  <div class="middle">
  <div class="heading">
    <?php if (isset($name)) { ?>
      <?php if ($items != 'none') { ?>
        <div id="cat_list">
        <?php for ($i = 0; $i < sizeof($shopwork_items); $i = $i + 4) { ?>
          <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
            <?php if (isset($shopwork_items[$j])) { ?>
              <?php if ($j != $i) { ?>
                <span>|</span>
              <?php } ?>
              <?php if ($shopwork_items[$j]['information_id'] == $information_id) { ?>
                <a style="color: #ec7500; font-weight: bold;" href="<?php echo $shopwork_items[$j]['href']; ?>"><?php echo $shopwork_items[$j]['title']; ?></a>
              <?php } else { ?>
                <a href="<?php echo $shopwork_items[$j]['href']; ?>"><?php echo $shopwork_items[$j]['title']; ?></a>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <br />
        <?php } ?>
        </div>
      <?php } ?>
    <?php } ?>
    <h1><?php echo $heading_title; ?></h1>
  </div>
  <div class="description"><?php echo $description; ?></div>
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