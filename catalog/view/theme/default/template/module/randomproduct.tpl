<?php if ($products) { ?>
<?php foreach ($products as $product) { ?>
<div class="box">
  <div class="top">
    <span class="promo-head"><?php echo $promo_head; ?></span><br />
    <span class="promo-middle"><?php echo $promo_middle; ?></span><br />
    <span class="promo-bottom"><?php echo $product['name']; ?></span>
  </div>
  <div class="middle" align="center">
    <div style="position: relative;">
      <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['image']; ?>" title="<?php echo $product['name'] .' - '. $product['model']; ?>" alt="<?php echo $product['name'] .' - '. $product['model']; ?>" />
      <div id="price">
        <table><tbody><tr>
          <td><div class="price_int"><?php echo $price_int; ?></div></td>
          <td>
            <div class="price_dec"><?php echo $price_dec; ?></div>
            <div class="price_curr"><?php echo $price_curr; ?></div>
          </td>
        </tr></tbody></table>
      </div></a>
    </div>
  </div>
  <div class="bottom">&nbsp;</div>
</div>
<?php } ?>
<?php } ?>