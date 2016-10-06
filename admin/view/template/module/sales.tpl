<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
<div class="tabs"><a tab="#tab_general"><?php echo $tab_general; ?></a></div>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <div id="tab_general" class="page">
    <table class="form">
      <tr>
        <td><?php echo $entry_limit; ?></td>
        <td><input type="text" name="sales_limit" value="<?php echo $sales_limit; ?>" size="1" /></td>
      </tr>
      <tr>
        <td width="25%"><?php echo $entry_position; ?></td>
        <td><select name="sales_position">
            <?php if ($sales_position == 'left') { ?>
            <option value="left" selected="selected"><?php echo $text_left; ?></option>
            <?php } else { ?>
            <option value="left"><?php echo $text_left; ?></option>
            <?php } ?>
            <?php if ($sales_position == 'right') { ?>
            <option value="right" selected="selected"><?php echo $text_right; ?></option>
            <?php } else { ?>
            <option value="right"><?php echo $text_right; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_products; ?></td><td></td>
        </tr>
      <tr>
        <td colspan="2"><table width="100%">
            <tr>
              <td style="padding: 0;" colspan="3"><select id="category" style="margin-bottom: 5px; width: 100%;" onchange="getProducts();">
                  <?php foreach ($categories as $category) { ?>
                  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td width="45%" style="padding: 0;"><select multiple="multiple" id="product" size="10" style="width: 100%;">
                </select></td>
              <td width="10%" align="center" style="vertical-align: middle;"><input type="button" value="--&gt;" onclick="addSales();" />
                <br />
                <input type="button" value="&lt;--" onclick="removeSales();" /></td>
              <td width="45%" style="padding: 0;"><select multiple="multiple" id="sales" size="10" style="width: 100%;">
                </select></td>
            </tr>
          </table>
          <div id="sales_products">
            <?php foreach ($sales_products as $sales_id) { ?>
            <input type="hidden" name="sales_products[]" value="<?php echo $sales_id; ?>" />
            <?php } ?>
          </div></td>
      </tr>
      <tr>
        <td><?php echo $entry_status; ?></td>
        <td><select name="sales_status">
            <?php if ($sales_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
      </tr>
      <tr>
        <td><?php echo $entry_sort_order; ?></td>
        <td><input type="text" name="sales_sort_order" value="<?php echo $sales_sort_order; ?>" size="1" /></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<script type="text/javascript"><!--
  function addSales() {
    $('#product :selected').each(function() {
      $(this).remove();

      $('#sales option[value=\'' + $(this).attr('value') + '\']').remove();

      $('#sales').append('<option value="' + $(this).attr('value') + '">' + $(this).text() + '</option>');

      $('#sales_products input[value=\'' + $(this).attr('value') + '\']').remove();

      $('#sales_products').append('<input type="hidden" name="sales_products[]" value="' + $(this).attr('value') + '" />');
    });
  }

  function removeSales() {
    $('#sales :selected').each(function() {
      $(this).remove();

      $('#sales_products input[value=\'' + $(this).attr('value') + '\']').remove();
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

  function getSales() {
    $('#sales option').remove();

    $.ajax({
      url: 'index.php?route=catalog/product/sales',
      type: 'POST',
      dataType: 'json',
      data: $('#sales_products input'),
      success: function(data) {
        $('#sales_products input').remove();

        for (i = 0; i < data.length; i++) {
          $('#sales').append('<option value="' + data[i]['product_id'] + '">' + data[i]['name'] + '</option>');

          $('#sales_products').append('<input type="hidden" name="sales_products[]" value="' + data[i]['product_id'] + '" />');
        }
      }
    });
  }

  getProducts();
  getSales();
  //--></script>
<?php echo $footer; ?>