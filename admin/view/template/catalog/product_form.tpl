<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a class="button" id="buton" onclick="location='<?php echo $action; ?>';"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a><a tab="#tab_data"><?php echo $tab_data; ?></a><a tab="#tab_option"><?php echo $tab_option; ?></a><a tab="#tab_techparam"><?php echo $tab_techparam; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
    <table class="form">
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="4" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_serial_no; ?></td>
        <td><input type="text" name="serial_no" value="<?php echo $serial_no; ?>" size="80" /></td>
      </tr>
      <?php foreach ($languages as $language) { ?>
      <tr>
        <td width="180"><span class="required">*</span> <?php echo $entry_name; ?></td>
        <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['name'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
          <?php if (isset($error_name[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_page_title; ?></td>
        <td><textarea name="product_description[<?php echo $language['language_id']; ?>][page_title]" cols="77" rows="1"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['page_title'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_description; ?></td>
        <td><textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" cols="77" rows="3"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_meta_keywords; ?></td>
        <td><textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keywords]" cols="77" rows="3"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keywords'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td width="180"><span class="required">*</span> <?php echo $entry_model; ?></td>
        <td><input type="text" name="product_description[<?php echo $language['language_id']; ?>][model]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['model'] : ''; ?>" size="80" />
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /><br />
          <?php if (isset($error_model[$language['language_id']])) { ?>
          <span class="error"><?php echo $error_model[$language['language_id']]; ?></span>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_description; ?></td>
        <td><textarea name="product_description[<?php echo $language['language_id']; ?>][description]" id="description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_advanced_description; ?></td>
        <td><textarea name="product_description[<?php echo $language['language_id']; ?>][advanced_description]" id="advanced_description<?php echo $language['language_id']; ?>"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['advanced_description'] : ''; ?></textarea>
          <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" style="vertical-align: top;" /></td>
      </tr>
      <?php } ?>
    </table>
  </div>
  <div id="tab_data" class="page">
    <table class="form">
      <tr>
        <td><?php echo $entry_keyword; ?></td>
        <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="80" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_image; ?></td>
        <td><input type="file" name="image" size="80" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_manufacturer; ?></td>
        <td><select name="manufacturer_id">
            <option value="0" selected="selected"><?php echo $text_none; ?></option>
            <?php foreach ($manufacturers as $manufacturer) { ?>
            <?php if ($manufacturer['manufacturer_id'] == $manufacturer_id) { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>" selected="selected"><?php echo $manufacturer['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $manufacturer['manufacturer_id']; ?>"><?php echo $manufacturer['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td></td>
        <td><img src="<?php echo $preview; ?>" alt="" style="margin: 4px 0px; border: 1px solid #EEEEEE;" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_shipping; ?></td>
        <td><?php if ($shipping) { ?>
          <input type="radio" name="shipping" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="shipping" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="shipping" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="shipping" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_random_display; ?></td>
        <td><?php if ($random_display) { ?>
          <input type="radio" name="random_display" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="random_display" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="random_display" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="random_display" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_date_available; ?></td>
        <td><input type="text" name="date_available" value="<?php echo $date_available; ?>" size="12" class="date" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_stock_status; ?></td>
        <td><select name="stock_status_id">
            <?php foreach ($stock_statuses as $stock_status) { ?>
            <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>
            <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="status">
            <?php if ($status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_tax_class; ?></td>
        <td><select name="tax_class_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($tax_classes as $tax_class) { ?>
            <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>
            <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_prepayment; ?></td>
        <td><select name="prepayment">
            <?php if ($prepayment == 50) { ?>
              <option value="50" selected="selected">50%</option>
              <option value="100">100%</option>
            <?php } else { ?>
              <option value="50">50%</option>
              <option value="100" selected="selected">100%</option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_use_in_order_discount; ?></td>
        <td><?php if ($use_in_order_discount) { ?>
          <input type="radio" name="use_in_order_discount" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="use_in_order_discount" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="use_in_order_discount" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="use_in_order_discount" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_is_24_hour_delivery; ?></td>
        <td><?php if ($is_24_hour_delivery) { ?>
          <input type="radio" name="is_24_hour_delivery" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="is_24_hour_delivery" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="is_24_hour_delivery" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="is_24_hour_delivery" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_is_5_days_delivery; ?></td>
        <td><?php if ($is_5_days_delivery) { ?>
          <input type="radio" name="is_5_days_delivery" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="is_5_days_delivery" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="is_5_days_delivery" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="is_5_days_delivery" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_is_new_item; ?></td>
        <td><?php if ($is_new_item) { ?>
          <input type="radio" name="is_new_item" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="is_new_item" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="is_new_item" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="is_new_item" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_show_min_price_warranty; ?></td>
        <td><?php if ($show_min_price_warranty) { ?>
          <input type="radio" name="show_min_price_warranty" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="show_min_price_warranty" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="show_min_price_warranty" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="show_min_price_warranty" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_price; ?></td>
        <td><input type="text" name="price" value="<?php echo $price; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_special; ?></td>
        <td><input type="text" name="special" value="<?php echo $special; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_power; ?></td>
        <td><?php if ($power) { ?>
          <input type="radio" name="power" value="1" checked="checked" />
          <?php echo $text_yes; ?>
          <input type="radio" name="power" value="0" />
          <?php echo $text_no; ?>
          <?php } else { ?>
          <input type="radio" name="power" value="1" />
          <?php echo $text_yes; ?>
          <input type="radio" name="power" value="0" checked="checked" />
          <?php echo $text_no; ?>
          <?php } ?></td>
      </tr>
      <tr>
        <td><?php echo $entry_nds; ?></td>
        <?php if($nds) { ?>
        <td><input type="checkbox" name="nds" id="nds" value="1" checked="checked" />  </td>
        <?php } else { ?>
        <td><input type="checkbox" name="nds" id="nds" value="0" />  </td>
        <?php } ?>
      </tr>
      <tr>
        <td><?php echo $entry_sborka; ?></td>
        <td><input type="text" name="sborka" value="<?php echo $sborka; ?>" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_min_order_qty; ?></td>
        <td><input type="text" name="min_order_qty" value="<?php echo $min_order_qty; ?>" size="2" /></td>
      </tr>
      <tr>
        <td><?php echo $entry_credit; ?></td>
        <td><select name="credit_id">
            <option value="0"><?php echo $text_none; ?></option>
            <?php foreach ($credits as $credit) { ?>
            <?php if ($credit['credit_id'] == $credit_id) { ?>
            <option value="<?php echo $credit['credit_id']; ?>" selected="selected"><?php echo $credit['name']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $credit['credit_id']; ?>"><?php echo $credit['name']; ?></option>
            <?php } ?>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_category; ?></td>
        <td><div class="scrollbox">
            <?php $class = 'odd'; ?>
            <?php foreach ($categories as $category) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <div class="<?php echo $class; ?>">
              <?php if (in_array($category['category_id'], $product_category)) { ?>
              <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" checked="checked" />
              <?php echo $category['name']; ?>
              <?php } else { ?>
              <input type="checkbox" name="product_category[]" value="<?php echo $category['category_id']; ?>" />
              <?php echo $category['name']; ?>
              <?php } ?>
            </div>
            <?php } ?>
          </div></td>
      </tr>
      <tr>
        <td><?php echo $entry_download; ?></td>
        <td><div class="scrollbox">
            <?php $class = 'odd'; ?>
            <?php foreach ($downloads as $download) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <div class="<?php echo $class; ?>">
              <?php if (in_array($download['download_id'], $product_download)) { ?>
              <input type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" checked="checked" />
              <?php echo $download['name']; ?>
              <?php } else { ?>
              <input type="checkbox" name="product_download[]" value="<?php echo $download['download_id']; ?>" />
              <?php echo $download['name']; ?>
              <?php } ?>
            </div>
            <?php } ?>
          </div></td>
      </tr>
      <tr>
        <td><?php echo $entry_related; ?></td>
        <td><table>
            <tr>
              <td style="padding: 0;" colspan="3"><select id="category" style="margin-bottom: 5px;" onchange="getProducts();">
                  <?php foreach ($categories as $category) { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td style="padding: 0;"><select multiple="multiple" id="product" size="10" style="width: 200px;">
                </select></td>
              <td style="vertical-align: middle;"><input type="button" value="--&gt;" onclick="addRelated();" />
                <br />
                <input type="button" value="&lt;--" onclick="removeRelated();" /></td>
              <td style="padding: 0;"><select multiple="multiple" id="related" size="10" style="width: 200px;">
                </select></td>
            </tr>
          </table>
          <div id="product_related">
            <?php foreach ($product_related as $related_id) { ?>
            <input type="hidden" name="product_related[]" value="<?php echo $related_id; ?>" />
            <?php } ?>
          </div></td>
      </tr>
      <tr>
        <td><?php echo $entry_video; ?></td>
        <td><div class="scrollbox">
            <?php $class = 'odd'; ?>
            <?php foreach ($videos as $video) { ?>
            <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
            <div class="<?php echo $class; ?>">
              <?php if (in_array($video['video_id'], $product_video)) { ?>
              <input type="checkbox" name="product_video[]" value="<?php echo $video['video_id']; ?>" checked="checked" />
              <?php echo $video['name']; ?>
              <?php } else { ?>
              <input type="checkbox" name="product_video[]" value="<?php echo $video['video_id']; ?>" />
              <?php echo $video['name']; ?>
              <?php } ?>
            </div>
            <?php } ?>
          </div></td>
      </tr>
    </table>
  </div>
  <div id="tab_option" class="page">
   <?php $php2javascript = 'var lang_product_option_value = ['; ?>
    <?php $first = true; ?>
    <?php foreach ($colors_lang as $color_lang) { ?>
      <?php $php2javascript .= ($first ? '' : ',').'"'.($color_lang['category_name'] != '' ? $color_lang['category_name']. ' -> ' : '') . $color_lang['name'].'"'; ?>
      <?php if ($first) ?>
        <?php $first = false; ?>
    <?php } ?>
    <?php $php2javascript .= '];'; ?>
    <?php $option_row = 0; ?>
    <?php $option_value_row = 0; ?>
    <?php foreach ($product_options as $product_option) { ?>
    <div id="option_row<?php echo $option_row; ?>">
      <div class="green">
        <table class="form">
          <tr>
            <td width="180"><?php echo $entry_option; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <input type="text" name="product_option[<?php echo $option_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option['language'][$language['language_id']]['name']; ?>" size="50" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php } ?></td>
            <td rowspan="2"><a onclick="$('#option_row<?php echo $option_row; ?>').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>
          </tr>
          <tr>
            <td><?php echo $entry_color_option; ?></td>
            <td><input type="hidden" name="product_option[<?php echo $option_row; ?>][color_option]" value="<?php echo $product_option['color_option']; ?>" size="1" />
                <?php if (isset($product_option['product_option_value']) && count($product_option['product_option_value']) > 0) { ?>
                  <?php if ($product_option['color_option']) { ?>
                    <input type="radio" value="1" name="color_option[<?php echo $option_row; ?>]" onclick="setColorOption('<?php echo $option_row; ?>', this);" checked="checked" disabled="disabled" />
                    <?php echo $text_yes; ?>
                    <input type="radio" value="0" name="color_option[<?php echo $option_row; ?>]" onclick="setColorOption('<?php echo $option_row; ?>', this);" disabled="disabled" />
                    <?php echo $text_no; ?>
                  <?php } else { ?>
                    <input type="radio" value="1" name="color_option[<?php echo $option_row; ?>]" onclick="setColorOption('<?php echo $option_row; ?>', this);" disabled="disabled" />
                    <?php echo $text_yes; ?>
                    <input type="radio" value="0" name="color_option[<?php echo $option_row; ?>]" onclick="setColorOption('<?php echo $option_row; ?>', this);" checked="checked" disabled="disabled" />
                    <?php echo $text_no; ?>
                  <?php } ?>
                <?php } else { ?>
                  <input type="radio" value="1" name="color_option[<?php echo $option_row; ?>]" onclick="setColorOption('<?php echo $option_row; ?>', this);" />
                  <?php echo $text_yes; ?>
                  <input type="radio" value="0" name="color_option[<?php echo $option_row; ?>]" onclick="setColorOption('<?php echo $option_row; ?>', this);" checked="checked" />
                  <?php echo $text_no; ?>
                <?php } ?>
            </td>
          </tr>
          <tr>
            <td><?php echo $entry_sort_order; ?></td>
            <td><input type="text" name="product_option[<?php echo $option_row; ?>][sort_order]" value="<?php echo $product_option['sort_order']; ?>" size="5" /></td>
          </tr>
        </table>
      </div>
      <?php if ($product_option['color_option']) { ?>
        <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
        <div id="option_value_row<?php echo $option_value_row; ?>">
          <div class="green">
            <table class="form">
              <tr>
                <td width="180"><?php echo $entry_option_value; ?></td>
                <td><div id="hidden_fields<?php echo $option_row; ?>_<?php echo $option_value_row; ?>"><?php foreach ($languages as $language) { ?>
                  <input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option_value['language'][$language['language_id']]['name']; ?>" size="50" />
                  <?php } ?></div>
                  <select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][color_id]" onchange="refreshOptionValueDesc('<?php echo $option_row; ?>', '<?php echo $option_value_row ?>', this.options[this.selectedIndex]);">
                    <?php foreach ($colors as $color) { ?>
                    <?php if ($color['color_id'] == $product_option_value['color_id']) { ?>
                    <option value="<?php echo $color['color_id']; ?>" selected="selected"><?php echo ($color['category_name'] != '' ? $color['category_name']. ' -> ' : '') . $color['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $color['color_id']; ?>"><?php echo ($color['category_name'] != '' ? $color['category_name']. ' -> ' : '') . $color['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </td>
                <td rowspan="6" style="white-space: nowrap;" width="120"><a onclick="removeOptionValue('<?php echo $option_row; ?>', '<?php echo $option_value_row; ?>');" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>
              </tr>
              <tr>
                <td><?php echo $entry_quantity; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" size="2" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_subtract; ?></td>
                <td><?php if ($product_option_value['subtract']) { ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="1" checked="checked" />
                  <?php echo $text_yes; ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="0" />
                  <?php echo $text_no; ?>
                  <?php } else { ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="1" />
                  <?php echo $text_yes; ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="0" checked="checked" />
                  <?php echo $text_no; ?>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_price; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_prefix; ?></td>
                <td><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][prefix]">
                    <?php  if ($product_option_value['prefix'] != '-') { ?>
                    <option value="+" selected="selected"><?php echo $text_plus; ?></option>
                    <option value="-"><?php echo $text_minus; ?></option>
                    <?php } else { ?>
                    <option value="+"><?php echo $text_plus; ?></option>
                    <option value="-" selected="selected"><?php echo $text_minus; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $entry_sort_order; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][sort_order]" value="<?php echo $product_option_value['sort_order']; ?>" size="5" style="margin-top: 3px;" /></td>
              </tr>
            </table>
          </div>
        </div>
        <?php $option_value_row++; ?>
        <?php } ?>
        <a id="add_option_value<?php echo $option_row; ?>" onclick="addOptionValue('<?php echo $option_row; ?>');" style="margin-bottom: 15px;" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option_value; ?></span><span class="button_right"></span></a>
        <a id="add_option_value_color_group<?php echo $option_row; ?>" onclick="addOptionValueColorGroup('<?php echo $option_row; ?>');" style="margin-bottom: 15px;" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option_value_group_color; ?></span><span class="button_right"></span></a>
        <select id="color_categories<?php echo $option_row; ?>" class="button" style="position: relative; top: -25px;">
          <option value="0"><?php echo $text_select;?></option>
          <?php foreach ($color_categories as $color_category) { ?>
            <option value="<?php echo $color_category['colorcategory_id'];?>"><?php echo $color_category['name'];?></option>
          <?php } ?>
        </select>
        <input type="text" style="position: relative; top: -25px;" id="color_group_price<?php echo $option_row; ?>" value="0.0000" size="9"/>
        </div>
      <?php } else { ?>
        <?php if (isset($product_option['product_option_value'])) { ?>
        <?php foreach ($product_option['product_option_value'] as $product_option_value) { ?>
        <div id="option_value_row<?php echo $option_value_row; ?>">
          <div class="green">
            <table class="form">
              <tr>
                <td width="180"><?php echo $entry_option_value; ?></td>
                <td><input type="hidden" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][color_id]" value="" />
                  <?php foreach ($languages as $language) { ?>
                  <input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $product_option_value['language'][$language['language_id']]['name']; ?>" size="50" />
                  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
                  <?php } ?></td>
                <td rowspan="6"><a onclick="removeOptionValue('<?php echo $option_row; ?>', '<?php echo $option_value_row; ?>');" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>
                <?php /*<td rowspan="6"><a onclick="$('#option_value_row<?php echo $option_value_row; ?>').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td> */?>
              </tr>
              <tr>
                <td><?php echo $entry_quantity; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][quantity]" value="<?php echo $product_option_value['quantity']; ?>" size="2" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_subtract; ?></td>
                <td><?php if ($product_option_value['subtract']) { ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="1" checked="checked" />
                  <?php echo $text_yes; ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="0" />
                  <?php echo $text_no; ?>
                  <?php } else { ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="1" />
                  <?php echo $text_yes; ?>
                  <input type="radio" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][subtract]" value="0" checked="checked" />
                  <?php echo $text_no; ?>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_price; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][price]" value="<?php echo $product_option_value['price']; ?>" /></td>
              </tr>
              <tr>
                <td><?php echo $entry_prefix; ?></td>
                <td><select name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][prefix]">
                    <?php  if ($product_option_value['prefix'] != '-') { ?>
                    <option value="+" selected="selected"><?php echo $text_plus; ?></option>
                    <option value="-"><?php echo $text_minus; ?></option>
                    <?php } else { ?>
                    <option value="+"><?php echo $text_plus; ?></option>
                    <option value="-" selected="selected"><?php echo $text_minus; ?></option>
                    <?php } ?>
                  </select></td>
              </tr>
              <tr>
                <td><?php echo $entry_sort_order; ?></td>
                <td><input type="text" name="product_option[<?php echo $option_row; ?>][product_option_value][<?php echo $option_value_row; ?>][sort_order]" value="<?php echo $product_option_value['sort_order']; ?>" size="5" style="margin-top: 3px;" /></td>
              </tr>
            </table>
          </div>
        </div>
        <?php $option_value_row++; ?>
        <?php } ?>
      <?php } ?>
    <a id="add_option_value<?php echo $option_row; ?>" onclick="addOptionValue('<?php echo $option_row; ?>');" style="margin-bottom: 15px;" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option_value; ?></span><span class="button_right"></span></a>
    <a id="add_option_value_color_group<?php echo $option_row; ?>" onclick="addOptionValueColorGroup('<?php echo $option_row; ?>');" style="margin-bottom: 15px; display: none;" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option_value_group_color; ?></span><span class="button_right"></span></a></div>
    <select id="color_categories<?php echo $option_row; ?>" class="button" style="position: relative; top: -25px; display: none;">
      <option value="0"><?php echo $text_select;?></option>
      <?php foreach ($color_categories as $color_category) { ?>
        <option value="<?php echo $color_category['colorcategory_id'];?>"><?php echo $color_category['name'];?></option>
      <?php } ?>
    </select>
  <input type="text" style="position: relative; top: -25px; display: none;" id="color_group_price<?php echo $option_row; ?>" value="0.0000" size="9" />
    <?php } ?>
    <?php $option_row++; ?>
    <?php } ?>
    <a id="add_option" onclick="addOption();" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option; ?></span><span class="button_right"></span></a></div>
    <div id="tab_techparam" class="page">
    <div id="techparam">
      <?php $techparam_row = 0; ?>
      <?php foreach ($product_techparams as $product_techparam) { ?>
      <table width="100%" class="green" id="techparam_row<?php echo $techparam_row; ?>">
        <tr>
          <td><?php echo $entry_techparam; ?><br />
            <select name="product_techparam[<?php echo $techparam_row; ?>][techparam_id]" style="margin-top: 3px;">
              <?php foreach ($techparams as $techparam) { ?>
              <?php if ($techparam['techparam_id'] == $product_techparam['techparam_id']) { ?>
              <option value="<?php echo $techparam['techparam_id']; ?>" selected="selected"><?php echo $techparam['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $techparam['techparam_id']; ?>"><?php echo $techparam['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><?php echo $entry_techparam_measurement; ?><br />
            <select name="product_techparam[<?php echo $techparam_row; ?>][measurement_class_id]" style="margin-top: 3px;">
              <option value="0"><?php echo $text_none; ?></option>
              <?php foreach ($measurement_classes as $measurement_class) { ?>
              <?php if ($measurement_class['measurement_class_id'] == $product_techparam['measurement_class_id']) { ?>
              <option value="<?php echo $measurement_class['measurement_class_id']; ?>" selected="selected"><?php echo $measurement_class['title']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $measurement_class['measurement_class_id']; ?>"><?php echo $measurement_class['title']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><?php echo $entry_techparam_value; ?><br />
            <input type="text" name="product_techparam[<?php echo $techparam_row; ?>][value]" value="<?php echo $product_techparam['value']; ?>" style="margin-top: 3px;" /></td>
          <td rowspan="2"><a onclick="$('#techparam_row<?php echo $techparam_row; ?>').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>
        </tr>
      </table>
      <?php $techparam_row++; ?>
      <?php } ?>
    </div>
    <a onclick="addTechParam();" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_techparam; ?></span><span class="button_right"></span></a>
  </div>
</form>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script>
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('description<?php echo $language['language_id']; ?>');
CKEDITOR.replace('advanced_description<?php echo $language['language_id']; ?>');
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function addRelated() {
    $('#product :selected').each(function() {
        $(this).remove();

        $('#related option[value=\'' + $(this).attr('value') + '\']').remove();

        $('#related').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');

        $('#product_related input[value=\'' + $(this).attr('value') + '\']').remove();

        $('#product_related').append('<input type="hidden" name="product_related[]" value="' + $(this).attr('value') + '" />');
    });
}

function removeRelated() {
    $('#related :selected').each(function() {
        $(this).remove();

        $('#product_related input[value=\'' + $(this).attr('value') + '\']').remove();
    });
}

function getProducts() {
    $('#product option').remove();

    $.ajax({
        url: 'index.php?route=catalog/product/category&category_id=' + $('#category').attr('value'),
        dataType: 'json',
        success: function(data) {
            for (i = 0; i < data.length; i++) {
                 $('#product').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + '</option>');
            }
        }
    });
}

function getRelated() {
    $('#related option').remove();

    $.ajax({
        url: 'index.php?route=catalog/product/related',
        type: 'POST',
        dataType: 'json',
        data: $('#product_related input'),
        success: function(data) {
            $('#product_related input').remove();

            for (i = 0; i < data.length; i++) {
                 $('#related').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + '</option>');

                $('#product_related').append('<input type="hidden" name="product_related[]" value="' + data[i]['product_id'] + '" />');
            }
        }
    });
}

getProducts();
getRelated();
//--></script>
<script type="text/javascript"><!--
var option_row = <?php echo $option_row; ?>;

function addOption() {
    html  = '<div id="option_row' + option_row + '">';
    html += '<div class="green">';
    html += '<table class="form">';
    html += '<tr>';
    html += '<td width="180"><?php echo $entry_option; ?></td>';
    html += '<td>';
    <?php foreach ($languages as $language) { ?>
    html += '<input type="text" name="product_option[' + option_row + '][language][<?php echo $language['language_id']; ?>][name]" value="" size="50" />&nbsp;';
    html += '<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
    <?php } ?>
    html += '</td>';
    html += '<td rowspan="2"><a onclick="$(\'#option_row' + option_row + '\').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_color_option; ?></td>';
    html += '<td><input type="hidden" name="product_option[' + option_row + '][color_option]" value="0" size="1" />';
    html += '<input type="radio" name="color_option['+option_row+']" value="1" onclick="setColorOption(\'' + option_row + '\', this);" />';
    html += '<?php echo $text_yes; ?>';
    html += '<input type="radio" name="color_option['+option_row+']" value="0" checked="checked" onclick="setColorOption(\'' + option_row + '\', this);" />';
    html += '<?php echo $text_no; ?>';
    html += '</td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_sort_order; ?></td>';
    html += '<td><input type="text" name="product_option[' + option_row + '][sort_order]" value="" size="5" /></td>';
    html += '</tr>';
    html += '</table>';
    html += '</div>';
    html += '<a id="add_option_value' + option_row + '" onclick="addOptionValue(\'' + option_row + '\');" style="margin-bottom: 15px;" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option_value; ?></span><span class="button_right"></span></a>';
    html += '<a id="add_option_value_color_group' + option_row + '" onclick="addOptionValueColorGroup(\'' + option_row + '\');" style="margin-bottom: 15px; display: none;" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_option_value_group_color; ?></span><span class="button_right"></span></a>';
    html += '<select id="color_categories' + option_row + '" class="button" style="position: relative; top: -25px; display: none;">';
    html += '<option value="0"><?php echo $text_select;?></option>';
    <?php foreach ($color_categories as $color_category) { ?>
    html += '<option value="<?php echo $color_category['colorcategory_id'];?>"><?php echo $color_category['name'];?></option>';
    <?php } ?>
    html += '</select>';
    html += '<input type="text" style="position: relative; top: -25px; display: none;" id="color_group_price' + option_row + '" value="0.0000" size="9" />';
    html += '</div>';

    $('#add_option').before(html);

    option_row++;
}

var option_value_row = <?php echo $option_value_row; ?>;

function addOptionValue(option_id) {
    if ($('#option_row'+option_id+' :input[type=radio]:checked').val()==1) {
      html  = '<div id="option_value_row' + option_value_row + '">';
      html += '<div class="green">';
      html += '<table class="form">';
      html += '<tr>';
      html += '<td width="180"><?php echo $entry_option_value; ?></td>';
      html += '<td><div id="hidden_fields' + option_id + '_'+option_value_row+'">';
      <?php $counter = 0; ?>
      <?php foreach ($languages as $language) { ?>
      html += '<input type="hidden" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][language][<?php echo $language['language_id']; ?>][name]" value="<?php echo $colors_lang[$counter]['name']; ?>" size="50" />&nbsp;';
      <?php $counter = $counter + 1; ?>
      <?php } ?>
      html += '</div><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][color_id]" onchange="refreshOptionValueDesc(' + option_id + ', ' + option_value_row + ', this.options[this.selectedIndex]);">';
      <?php foreach ($colors as $color) { ?>
      html += '<option value="<?php echo $color['color_id']; ?>"><?php echo ($color['category_name'] != '' ? $color['category_name']. ' -> ' : '') . $color['name']; ?></option>';
      <?php } ?>
      html += '</select>';
      html += '</td>';
      html += '<td rowspan="6" style="white-space: nowrap;" width="120"><a onclick="removeOptionValue('+ option_id + ', ' + option_value_row + ');" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_quantity; ?></td>';
      html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][quantity]" value="" size="2" /></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_subtract; ?></td>';
      html += '<td>';
      html += '<input type="radio" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][subtract]" value="1" />&nbsp;';
      html += '<?php echo $text_yes; ?>&nbsp;';
      html += '<input type="radio" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][subtract]" value="0" checked="checked" />&nbsp;';
      html += '<?php echo $text_no; ?>';
      html += '</td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_price; ?></td>';
      html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][price]" value="" /></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_prefix; ?></td>';
      html += '<td><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][prefix]">';
      html += '<option value="+"><?php echo $text_plus; ?></option>';
      html += '<option value="-" selected="selected"><?php echo $text_minus; ?></option>';
      html += '</select></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_sort_order; ?></td>';
      html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][sort_order]" value="" size="5" /></td>';
      html += '</tr>';
      html += '</table>';
      html += '</div>';
      html += '</div>';
    } else {
      html  = '<div id="option_value_row' + option_value_row + '">';
      html += '<div class="green">';
      html += '<table class="form">';
      html += '<tr>';
      html += '<td width="180"><?php echo $entry_option_value; ?></td>';
      html += '<td>';
      html += '<input type="hidden" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][color_id]" />';
      <?php foreach ($languages as $language) { ?>
      html += '<input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][language][<?php echo $language['language_id']; ?>][name]" value="" />&nbsp;';
      html += '<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />';
      <?php } ?>
      html += '</td>';
      html += '<td rowspan="6" style="white-space: nowrap;" width="120"><a onclick="removeOptionValue('+ option_id + ', ' + option_value_row + ');" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_quantity; ?></td>';
      html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][quantity]" value="" size="2" /></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_subtract; ?></td>';
      html += '<td>';
      html += '<input type="radio" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][subtract]" value="1" />&nbsp;';
      html += '<?php echo $text_yes; ?>&nbsp;';
      html += '<input type="radio" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][subtract]" value="0" checked="checked" />&nbsp;';
      html += '<?php echo $text_no; ?>';
      html += '</td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_price; ?></td>';
      html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][price]" value="" /></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_prefix; ?></td>';
      html += '<td><select name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][prefix]">';
      html += '<option value="+"><?php echo $text_plus; ?></option>';
      html += '<option value="-" selected="selected"><?php echo $text_minus; ?></option>';
      html += '</select></td>';
      html += '</tr>';
      html += '<tr>';
      html += '<td><?php echo $entry_sort_order; ?></td>';
      html += '<td><input type="text" name="product_option[' + option_id + '][product_option_value][' + option_value_row + '][sort_order]" value="" size="5" /></td>';
      html += '</tr>';
      html += '</table>';
      html += '</div>';
      html += '</div>';
    }

    $('#add_option_value' + option_id).before(html);

    if ($('#option_row' + option_id + ' > div .green').size() > 0) {
      $('#option_row'+option_id+' :input[type=radio][name=color_option['+option_id+']]').attr('disabled', true);
    }

    option_value_row++;
}

function addOptionValueColorGroup(option_id) {
  var colorcategory_id = $('#color_categories'+option_id+' option:selected').val();

  if (colorcategory_id != 0) {
    $.blockUI({fadeIn: 1000, message: '<H1><?php echo $text_loading ?> </H1>'});

    $.ajax({
          url: 'index.php?route=catalog/product/colorsbycolorcategory',
          type: 'POST',
          dataType: 'json',
          data: {colorcategory_id: colorcategory_id},
          success: function(data) {

              for (i = 0; i < data.length; i++) {
                  addOptionValue(option_id);
                  $("select[name='product_option[" + option_id + "][product_option_value][" + (option_value_row-1) + "][color_id]'] option[value=" + data[i]['color_id'] + "]").attr('selected', 'selected')
                  //console.log($("select[name='product_option[" + option_id + "][product_option_value][" + (option_value_row-1) + "][color_id]'] option[value=" + data[i]['color_id'] + "]").attr('selected', 'selected'));
                  $('#option_row'+option_id+' :input[type=text][name="product_option['+option_id+'][product_option_value][' + (option_value_row-1) + '][price]"]').val($('#color_group_price'+option_id).val());
                  $('#option_row'+option_id+' :input[type=text][name="product_option['+option_id+'][product_option_value][' + (option_value_row-1) + '][sort_order]"]').val(data[i]['sort_order']);
                  $("select[name='product_option[" + option_id + "][product_option_value][" + (option_value_row-1) + "][prefix]'] option[value=+]").attr('selected', 'selected');
              }

              $.unblockUI();
          }
      });
  }


}

function removeOptionValue(option_id, option_value_id) {
  $('#option_value_row' + option_value_id).remove();
  if ($('#option_row' + option_id + ' > div .green').size() == 0)
    $('#option_row'+option_id+' :input[type=radio][name=color_option['+option_id+']]').attr('disabled', false);
}

<?php $php2javascript = 'var lang = ['; ?>
<?php $first = true; ?>
<?php foreach ($languages as $language) { ?>
  <?php $php2javascript .= ($first ? '' : ',').''.$language['language_id']; ?>
  <?php if ($first) ?>
    <?php $first = false; ?>
<?php } ?>
<?php $php2javascript .= '];'; ?>

function refreshOptionValueDesc(option_id, option_value_id, option){
  <?php echo $php2javascript; ?>
  $.each(lang, function(index, value) {
    $.ajax({
        type: 'get',
        url: 'index.php?route=catalog/product/getcolordesc',
        dataType: 'html',
        data: {language_id:value, color_id:option.value},
        success: function (html) {
            $('#hidden_fields'+option_id+'_'+option_value_id+' :hidden[name*=['+value+'][name]]').val(html);
        }
    });
});
}

function setColorOption(option_id ,radio){
  $('#option_row'+option_id+' :input[type=hidden][name*=color_option]').val(radio.value);
  if (radio.value == 1) {
    $('#add_option_value_color_group'+option_id).show();
    $('#color_categories'+option_id).show();
    $('#color_group_price'+option_id).show();
  } else {
    $('#add_option_value_color_group'+option_id).hide();
    $('#color_categories'+option_id).hide();
    $('#color_group_price'+option_id).hide();
  }
}
//--></script>
<!-- <script type="text/javascript"><!--
var discount_row = <?php // echo $discount_row; ?>;

function addDiscount() {
    html  = '<table class="green" id="discount_row' + discount_row + '">';
    html += '<tr>';
    html += '<td><?php echo $entry_customer_group; ?><br /><select name="product_discount[' + discount_row + '][customer_group_id]" style="margin-top: 3px;">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';
    html += '<td><?php echo $entry_quantity; ?><br /><input type="text" name="product_discount[' + discount_row + '][quantity]" value="" size="2" style="margin-top: 3px;" /></td>';
    html += '<td><?php echo $entry_priority; ?><br /><input type="text" name="product_discount[' + discount_row + '][priority]" value="" size="2" style="margin-top: 3px;" /></td>';
    html += '<td><?php echo $entry_price; ?><br /><input type="text" name="product_discount[' + discount_row + '][price]" value="" style="margin-top: 3px;" /></td>';
    html += '<td rowspan="2"><a onclick="$(\'#discount_row' + discount_row + '\').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td><?php echo $entry_date_start; ?><br /><input type="text" name="product_discount[' + discount_row + '][date_start]" value="" class="date" style="margin-top: 3px;" /></td>';
    html += '<td colspan="3"><?php echo $entry_date_end; ?><br /><input type="text" name="product_discount[' + discount_row + '][date_end]" value="" class="date" style="margin-top: 3px;" /></td>';
    html += '</tr>';
    html += '</table>';

    $('#discount').append(html);

    //$('#discount .date').datepicker({dateFormat: 'yy-mm-dd'});

    discount_row++;
}
//--></script> -->
<script type="text/javascript"><!--
var techparam_row = <?php echo $techparam_row; ?>;

function addTechParam() {
    html  = '<table class="green" id="techparam_row' + techparam_row + '">';
    html += '<tr>';
    html += '<td><?php echo $entry_techparam; ?><br /><select name="product_techparam[' + techparam_row + '][techparam_id]" style="margin-top: 3px;">';
    <?php foreach ($techparams as $techparam) { ?>
    html += '<option value="<?php echo $techparam['techparam_id']; ?>"><?php echo $techparam['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';
    html += '<td><?php echo $entry_techparam_measurement; ?><br /><select name="product_techparam[' + techparam_row + '][measurement_class_id]" style="margin-top: 3px;">';
    html += '<option value="0"><?php echo $text_none; ?></option>';
    <?php foreach ($measurement_classes as $measurement_class) { ?>
    html += '<option value="<?php echo $measurement_class['measurement_class_id']; ?>"><?php echo $measurement_class['title']; ?></option>';
    <?php } ?>
    html += '</select></td>';
    html += '<td><?php echo $entry_techparam_value; ?><br />';
    html += '<input type="text" name="product_techparam[' + techparam_row + '][value]" value="" style="margin-top: 3px;" /></td>';
    html += '<td rowspan="2"><a onclick="$(\'#techparam_row' + techparam_row + '\').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
    html += '</tr>';
    html += '</table>';

    $('#techparam').append(html);

    techparam_row++;
}
//--></script>
<script type="text/javascript"><!--
var special_row = <?php echo $special_row; ?>;

function addSpecial() {
	html  = '<table class="green" id="special_row' + special_row + '">';
	html += '<tr>';
    html += '<td><?php echo $entry_customer_group; ?><br /><select name="product_special[' + special_row + '][customer_group_id]" style="margin-top: 3px;">';
    <?php foreach ($customer_groups as $customer_group) { ?>
    html += '<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';
    <?php } ?>
    html += '</select></td>';
    html += '<td><?php echo $entry_priority; ?><br /><input type="text" name="product_special[' + special_row + '][priority]" value="" size="2" style="margin-top: 3px;" /></td>';
	html += '<td><?php echo $entry_price; ?><br /><input type="text" name="product_special[' + special_row + '][price]" value="" style="margin-top: 3px;" /></td>';
	html += '<td rowspan="2"><a onclick="$(\'#special_row' + special_row + '\').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
	html += '</tr>';
	html += '<tr>';
    html += '<td><?php echo $entry_date_start; ?><br /><input type="text" name="product_special[' + special_row + '][date_start]" value="" class="date" style="margin-top: 3px;" /></td>';
	html += '<td colspan="2"><?php echo $entry_date_end; ?><br /><input type="text" name="product_special[' + special_row + '][date_end]" value="" class="date" style="margin-top: 3px;" /></td>';
	html += '</tr>';
    html += '</table>';

	$('#special').append(html);

	$//('#special .date').datepicker({dateFormat: 'yy-mm-dd'});

	special_row++;
}
//--></script>
<link rel="stylesheet" type="text/css" href="view/stylesheet/datepicker.css" />
<script type="text/javascript" src="view/javascript/jquery/ui/ui.core.min.js"></script>
<script type="text/javascript" src="view/javascript/jquery/ui/ui.datepicker.min.js"></script>
<script type="text/javascript">
    $("#buton").click(function(){
     $('#form').submit();
    });
</script>
<script type="text/javascript"><!--
//$(document).ready(function() {
//    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
//});
//--></script>
<script type="text/javascript"><!--
    $.tabs('.tabs a');
//--></script>

<script type="text/javascript"><!--
    $("#nds").change(function(){
      $(this).is(":checked") ? $(this).val(1) : $(this).val(0);
    })
</script>
<?php echo $footer; ?>
