<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
    <div class="heading">
      <?php if ($items != 'none') { ?>
        <div id="cat_list">
        <?php for ($i = 0; $i < sizeof($freeshipping_items); $i = $i + 4) { ?>
          <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
            <?php if (isset($freeshipping_items[$j])) { ?>
              <?php if ($j != $i) { ?>
                <span>|</span>
              <?php } ?>
              <a href="<?php echo $freeshipping_items[$j]['href']; ?>"><?php echo $freeshipping_items[$j]['title']; ?></a>
            <?php } ?>
          <?php } ?>
          <br />
        <?php } ?>
        </div>
      <?php } ?>
      <h1><?php echo $heading_title; ?></h1>
    </div>
    <div class="description"><?php echo $description; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>