<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
<div id="content">
  <div class="middle">
  <div class="heading"><h1><?php echo $heading_title; ?></h1></div>
    <b><?php echo $text_critea; ?></b>
    <div id="content_search" style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-top: 3px; margin-bottom: 10px;">
      <table>
        <tr>
          <td><?php echo $entry_search; ?></td>
          <td><?php if ($keyword) { ?>
            <input type="text" name="keyword" value="<?php echo $keyword; ?>" id="keyword" size="50" />
            <?php } else { ?>
            <input type="text" name="keyword" value="<?php echo $text_keywords; ?>" id="keyword" size="50" />
            <?php } ?></td>
        </tr>
        <tr>
          <td colspan="2"><?php if ($description) { ?>
            <input type="checkbox" name="description" id="description" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="description" id="description" />
            <?php } ?>
            <?php echo $entry_description; ?></td>
        </tr>
      </table>
    </div>
    <div class="buttons">
      <table>
        <tr>
          <td align="right"><a onclick="contentSearch();" class="button"><span><?php echo $button_search; ?></span></a></td>
        </tr>
      </table>
    </div>
    <div class="manu">
      <div class="div3">
        <select name="man" id="man">
          <option value=""><?php echo $text_select; ?></option>
          <?php foreach ($manf as $manu) { ?>
          <?php if ($manufacturer == $manu['manufacturer_id']) { ?>
          <option value="<?php echo $manu['manufacturer_id']; ?>" selected="selected"><?php echo $manu['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $manu['manufacturer_id']; ?>"><?php echo $manu['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </div>
      <div class="div4"><?php echo $text_man; ?></div>
    </div>
    <div class="heading"><?php echo $text_search; ?></div>
    <?php if (isset($products)) { ?>
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
          <?php if ($products[$j]['rating']) { ?>
          <img src="catalog/view/theme/default/image/stars_<?php echo $products[$j]['rating'] . '.png'; ?>" alt="<?php echo $products[$j]['stars']; ?>" />
          <?php } ?>
          <?php } ?>
          <?php } ?></td>
        <?php } ?>
      </tr>
      <?php } ?>
    </table>
    <div class="pagination"><?php echo $pagination; ?></div>
    <?php } else { ?>
    <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px; margin-top: 3px; margin-bottom: 15px;"><?php echo $text_empty; ?></div>
    <?php }?>
  </div>
  <script type="text/javascript">
$('#content_search input').keydown(function(e) {
	if (e.keyCode == 13) {
		contentSearch();
	}
});

function contentSearch() {
	url = 'index.php?route=product/search';
	
	var keyword = $('#keyword').attr('value');
    var manufacturer = $('#man').attr('value');
	
	if (keyword) {
		url += '&keyword=' + encodeURIComponent(keyword);
	}
	
	if ($('#description').attr('checked')) {
		url += '&description=1';
	}

	location = url;
}
</script>
  <script>
    $("#man").change(function(){
      if($(this).val() == 0) return false;
      url = 'index.php?route=product/search';

      var manufacturer = $('#man').attr('value');
      var desc = $("#description").attr('checked');
      var man = $("#man option:selected").text();
      var keyword = $('#keyword').attr('value');

      if (keyword) {
        url += '&keyword=' + encodeURIComponent(keyword);
      }

      if (desc) {
        url += '&description=1';
      }

      if (manufacturer) {
        url += '&manufacturer_id=' + encodeURIComponent(manufacturer);
      }

      location = url;
    });
  </script>
</div>
</div>
<?php echo $footer; ?> 