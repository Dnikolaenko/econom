<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="middle">
    <h1><?php echo $heading_title; ?></h1>
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
    <table class="list">
      <?php for ($i = 0; $i < sizeof($products); $i = $i + 4) { ?>
      <tr>
        <?php for ($j = $i; $j < ($i + 4); $j++) { ?>
        <td width="25%"><?php if (isset($products[$j])) { ?>
          <a href="<?php echo $products[$j]['href']; ?>"><img src="<?php echo $products[$j]['thumb']; ?>" title="<?php echo $products[$j]['name']; ?>" alt="<?php echo $products[$j]['name']; ?>" /></a><br />
          <a href="<?php echo $products[$j]['href']; ?>"><?php echo $products[$j]['name']; ?></a><br />
          <span style="color: #999; font-size: 11px;"><?php echo $products[$j]['model']; ?></span><br />
          <?php if ($display_price) { ?>
          <?php if ($products[$j]['akcia'] == TRUE) { ?>
          <span style="color: #900; text-decoration: line-through;"><?php echo $products[$j]['price']; ?></span>
          <span style="color: #F00; font-weight: bold;"><?php echo $products[$j]['special']; ?></span>
          <?php } else { ?>
          <span style="color: #900; font-weight: bold;"><?php echo $products[$j]['price']; ?></span>
          <?php } ?>
          <?php } ?>
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
  </div>
  <div class="bottom">&nbsp;</div>
</div>
<?php echo $footer; ?>