<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
    <div class="heading">
      <?php if ($catitems != 'none') { ?>
        <div id="cat_list">
        <?php for ($i = 0; $i < sizeof($advcategories); $i = $i + 4) { ?>
          <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
            <?php if (isset($advcategories[$j])) { ?>
              <?php if ($j != $i) { ?>
                <span>|</span>
              <?php } ?>
              <?php if ($advcategories[$j]['advcategory_id'] == $advcategory_id) { ?>
                <a style="color: #ec7500; font-weight: bold;" href="<?php echo $advcategories[$j]['href']; ?>"><?php echo $advcategories[$j]['name']; ?></a>
              <?php } else { ?>
                <a href="<?php echo $advcategories[$j]['href']; ?>"><?php echo $advcategories[$j]['name']; ?></a>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <br />
        <?php } ?>
        </div>
      <?php } ?>
      <h1><?php echo $heading_title; ?></h1>
    </div>
    <div style="position: relative;">
      <div style="float: left; width: 50%;">
        <?php if ($exists != 'none') { ?>
            <?php foreach ($advice as $advice_info) { ?>
                <?php echo $advice_info['date_added']; ?>&nbsp;-&nbsp;<a href="<?php echo $advice_info['href']; ?>"><?php echo $advice_info['name']; ?></a><br />
            <?php } ?>
        <?php } ?>
      </div>
      <div style="float: right; width: 47%; color: #999999; text-align: justify;">
        <?php echo $text_info1; ?><br /><br />
        <?php echo $text_info2; ?>
      </div>
    </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 