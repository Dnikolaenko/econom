<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
      <?php /*<div class="heading"><h1><?php echo $heading_title; ?></h1></div>*/ ?>
      <?php if (($config_left_top_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'left_top.' . $config_left_top_banner_ext)) || ($config_right_top_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_top.' . $config_right_top_banner_ext))) { ?>
        <center>
        <table width="100%" style="margin-bottom: 15px;"><tr align="center">
        <?php if ($config_left_top_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'left_top.' . $config_left_top_banner_ext)) { ?>
          <td width="50%">
          <?php if ($config_left_top_banner_ext == 'swf') { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="340" height="170">
              <param name="movie" value="<?php echo $preview_left_top_banner; ?>" />
              <param name="scale" value="noborder" />
              <param name="quality" value="high" />
              <param name="wmode" value="transparent">
              <embed src="<?php echo $preview_left_top_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="340" height="170"></embed>
            </object>
          <?php } else { ?>
            <?php if ($config_left_top_banner_url) { ?>
              <a href="<?php echo $config_left_top_banner_url; ?>" target="_blank">
            <?php } ?>
              <img src="<?php echo $preview_left_top_banner; ?>" />
            <?php if ($config_left_top_banner_url) { ?>
              </a>
            <?php } ?>
          <?php } ?>
          </td>
        <?php } ?>
        <?php if ($config_right_top_banner_display && file_exists(DIR_IMAGE . 'akcija/' .'right_top.' . $config_right_top_banner_ext)) { ?>
          <td width="50%">
          <?php if ($config_right_top_banner_ext == 'swf') { ?>
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="340" height="170">
              <param name="movie" value="<?php echo $preview_right_top_banner; ?>" />
              <param name="scale" value="noborder" />
              <param name="quality" value="high" />
              <param name="wmode" value="transparent">
              <embed src="<?php echo $preview_right_top_banner; ?>" wmode="transparent" quality="high" menu="false" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="340" height="170"></embed>
            </object>
          <?php } else { ?>
            <?php if ($config_right_top_banner_url) { ?>
              <a href="<?php echo $config_right_top_banner_url; ?>" target="_blank">
            <?php } ?>
              <img src="<?php echo $preview_right_top_banner; ?>" />
            <?php if ($config_right_top_banner_url) { ?>
              </a>
            <?php } ?>
          <?php } ?>
          </td>
        <?php } ?>
        </tr>
        </table>
        </center>
      <?php } ?>
      <?php if (sizeof($categories) > 1) { ?>
      <?php /* <div class="heading"><?php echo $text_choose_category; ?></div> */ ?>
      <div id="category_img">
      <table class="list">
        <?php for ($i = 0; $i < sizeof($categories); $i = $i + 2) { ?>
        <tr>
          <?php for ($j = $i; $j < ($i + 2); $j++) { ?>
          <td style="width: 50%; vertical-align: middle; padding-bottom: 1px;">
            <?php if (isset($categories[$j])) { ?>
              <a href="<?php echo $categories[$j]['href'] ?>">
                <div class="cat" style="background: url(<?php echo $categories[$j]['thumb'] ?>) no-repeat 0px 0px;">
                  <div class="cat_name"><?php echo $categories[$j]['name'] ?></div>
                  <div class="cat_desc"><?php echo $categories[$j]['index_description'] ?></div>
                </div>
              </a>
            <?php } ?></td>
          <?php } ?>
        </tr>
        <?php } ?>
      </table>
      </div>
      <?php } ?>
      <?php if ($slideshow_display_on_home) { ?>
      <div class="slider-wrapper theme-default">
          <div id="slider" class="nivoSlider">
           <?php foreach ($slideshow as $slide) { ?>
              <?php if ($slide['link']) { ?>
                <a href="<?php echo $slide['link']; ?>"><img src="<?php echo $slide['thumb']; ?>" alt="<?php echo $slide['title']; ?>" /></a>
              <?php } else { ?>
                <img src="<?php echo $slide['thumb']; ?>" alt="<?php echo $slide['title']; ?>" />
              <?php } ?>
           <?php } ?>
          </div>
      </div>
      <?php } ?>
  <?php if ($bestseller_display_on_home) { ?>
  <div class="heading"><?php echo $text_latest; ?></div>
  <table class="list">
    <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
    <tr>
      <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
      <td style="width: 25%;"><?php if (isset($products[$j])) { ?>
        <a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><br />
        <a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a><br />
        <a href="<?php echo $products[$j]['href']; ?>" style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></a><br />
        <?php if ($display_price) { ?>
        <?php if ($products[$j]['akcia'] == TRUE) { ?>
        <span style="color: #900; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span>
        <span style="color: #F00; font-weight: bold;"><?php echo $products[$j]['special']; ?></span>
        <?php } else { ?>
        <span style="color: #900; font-weight: bold;"><?php echo $products[$j]['price']; ?></span>
        <?php } ?>
        <?php } ?>
        <?php /*if ($products[$j]['rating']) { ?>
        <img src="catalog/view/theme/default/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
        <?php }*/ ?>
        <?php } ?></td>
      <?php } ?>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
      <div class="description"><?php echo $welcome; ?></div>
      <?php if ($news_display_on_home) { ?>
      <div class="heading"><?php echo $text_news; ?></div>
      <table>
        <?php foreach ($latest_news as $news_info) { ?>
          <tr><td>
            <?php echo $news_info['date_added']; ?>&nbsp;-&nbsp;<a href="<?php echo $news_info['href']; ?>"><?php echo $news_info['anons']; ?></a><br />
          </td></tr>
        <?php } ?>
      </table>
      <?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?> 