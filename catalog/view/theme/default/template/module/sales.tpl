<div class="box">
  <div class="top"><img src="catalog/view/theme/default/image/icon_bestsellers.png" alt="" /><?php echo $heading_title; ?></div>
  <div class="middle">
    <?php if ($products) { ?>
    <table cellpadding="2" cellspacing="0" style="width: 100%;">
      <?php foreach ($products as $product) { ?>
        <tr>
          <td>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a><br />
            <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a><br />
            <a href="<?php echo $product['href']; ?>" style="color: #999; font-size: 11px;"><?php echo $product['model']; ?></a><br />
            <?php if ($display_price) { ?>
              <?php if (!$product['special']) { ?>
                <span style="color: #900; font-weight: bold;"><?php echo $product['price']; ?></span><br />
              <?php } else { ?>
                <span style="color: #900; font-weight: bold; text-decoration: line-through;"><?php echo $product['price']; ?></span> <span style="color: #F00;"><?php echo $product['special']; ?></span>
              <?php } ?>
            <?php } ?>
          </td>
        </tr>
      <?php } ?>
      <?php /* small products
      <tr>
        <td valign="top" width="1"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
        <td valign="top"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php if ($display_price) { ?>
          <br />
          <?php if (!$product['special']) { ?>
          <span style="font-size: 11px; color: #900;"><?php echo $product['price']; ?></span>
          <?php } else { ?>
          <span style="font-size: 11px; color: #900; text-decoration: line-through;"><?php echo $product['price']; ?></span> <span style="font-size: 11px; color: #F00;"><?php echo $product['special']; ?></span>
          <?php } ?>
          <?php } ?></td>
      </tr>
      */ ?>
    </table>
    <?php } ?>
  </div>
  <div class="bottom">&nbsp;</div>
</div>
