<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
        <div class="heading"><h1><?php echo $heading_title; ?></h1></div>
      <?php if ($description) { ?>
      <div style="margin-bottom: 15px;"><?php echo $description; ?></div>
      <?php } ?>
      <?php if ($categories) { ?>
        <table class="listcat">
          <?php for ($i = 0; $i < sizeof($categories); $i = $i + 4) { ?>
          <tr>
            <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
            <td width="25%">
             <?php if (isset($categories[$j])) { ?>
              <a href="<?php echo $categories[$j]['href']; ?>"><?php echo $categories[$j]['name']; ?></a>
             <?php } ?>
            </td>
            <?php } ?>
          </tr>
          <tr>
            <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
            <td width="25%">
             <?php if (isset($categories[$j])) { ?>
              <a href="<?php echo $categories[$j]['href']; ?>"><img src="<?php echo $categories[$j]['thumb']; ?>" title="<?php echo $categories[$j]['name']; ?>" alt="<?php echo $categories[$j]['name']; ?>" /></a>
             <?php } ?>
            </td>
            <?php } ?>
          </tr>
          <?php } ?>
        </table>
      <?php } ?>
      <?php if ($display_images) { ?>
        <div style="margin-bottom: 15px;">
        <?php if ($thumb) { ?>
          <a href="<?php echo $popup; ?>" class="thickbox"><img src="<?php echo $thumb; ?>" title="<?php echo $text_enlarge; ?>" alt="<?php echo $text_enlarge; ?>" /></a>
        <?php } ?>
        <?php if ($thumb1) { ?>
          <a href="<?php echo $popup1; ?>" class="thickbox"><img src="<?php echo $thumb1; ?>" title="<?php echo $text_enlarge; ?>" alt="<?php echo $text_enlarge; ?>" style="margin-left: 5px; margin-right: 5px;" /></a>
        <?php } ?>
        <?php if ($thumb2) { ?>
          <a href="<?php echo $popup2; ?>" class="thickbox"><img src="<?php echo $thumb2; ?>" title="<?php echo $text_enlarge; ?>" alt="<?php echo $text_enlarge; ?>" /></a>
        <?php } ?>
        </div>
      <?php } ?>
      <?php if ($products) { ?>
      <?php
      /*
      <div class="sort">
        <div class="div1">
          <select name="sort" onchange="location=this.value">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if (($sort . '-' . $order) == $sorts['value']) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="div2"><?php echo $text_sort; ?></div>
      </div>
      */
      ?>
      <table class="list">
        <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
        <tr>
          <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
          <td width="25%"><?php if (isset($products[$j])) { ?>
            <a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name'] .' - '. $products[$j]['model']; ?>" alt="<?php echo $products[$j]['name'] .' - '. $products[$j]['model']; ?>" /></a><br />
            <a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a><br />
            <a href="<?php echo $products[$j]['href']; ?>" style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></a><br />
            <?php if ($display_price) { ?>
            <?php if ($products[$j]['akcia'] == TRUE) { ?>
            <span style="color: #900; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span>
            <span style="color: #F00; font-weight: bold;"><?php echo $products[$j]['special']; ?></span>
            <?php } else { ?>
            <span style="color: #900; font-weight: bold;"><?php echo $products[$j]['price']; ?></span>
            <?php } ?>
            <?php if ($products[$j]['rating']) { ?>
            <img src="catalog/view/theme/default/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
            <?php } ?>
            <?php } ?></td>
          <?php } ?>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>

    <?php if ($bestseller_display_on_home) { ?>
    <div class="heading"><?php echo $text_latest; ?></div>
    <table class="list">
      <?php for ($t = 0; $t < sizeof($productss); $t = $t + 4) { ?>
      <tr>
        <?php for ($k = $t; $k < ($t + 4); $k++) { ?>
        <td style="width: 25%;"><?php if (isset($productss[$k])) { ?>
          <a href="<?php echo $productss[$k]['href']; ?>"><img src="<?php echo $productss[$k]['thumb']; ?>" title="<?php echo $productss[$k]['name']; ?>" alt="<?php echo $productss[$k]['name']; ?>" /></a><br />
          <a href="<?php echo $productss[$k]['href']; ?>"><?php echo $productss[$k]['name']; ?></a><br />
          <a href="<?php echo $productss[$k]['href']; ?>" style="color: #999; font-size: 11px;"><?php echo $productss[$k]['model']; ?></a><br />
          <?php if ($display_price) { ?>
          <?php if ($productss[$k]['akcia'] == TRUE) { ?>
          <span style="color: #900; text-decoration: line-through;"><?php echo $productss[$k]['price']; ?></span>
          <span style="color: #F00; font-weight: bold;"><?php echo $productss[$k]['special']; ?></span>
          <?php } else { ?>
          <span style="color: #900; font-weight: bold;"><?php echo $productss[$k]['price']; ?></span>
          <?php } ?>
          <?php } ?>
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
    <?php } ?>
      <?php } ?>

      <?php if($ga == 1) { ?>
      <div style="display:inline;">
      <img height="1" width="1" style="border-style:none;" alt="" src="/googleads.g.doubleclick.net/pagead/viewthroughconversion/933818405/?value=0&amp;guid=ON&amp;script=0"/>
      </div>
      <?php } ?>
      <?php if ($bottom_description && $page == 1) { ?>
      <div><?php echo $bottom_description; ?></div>
      <?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>
  <!-- код для Гугл эдвордc -->
<script type="text/javascript" src="/www.googleadservices.com/pagead/conversion.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 933818405;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
