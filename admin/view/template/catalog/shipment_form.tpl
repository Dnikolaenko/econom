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
           <td><span class="required">*</span> <?php echo $entry_name; ?></td>
           <td><input type="text" name="name" value="<?php echo $name; ?>" size="80" />
             <?php if ($error_name) { ?>
             <span class="error"><?php echo $error_name; ?></span>
             <?php } ?></td>
         </tr>
         <tr>
           <td><?php echo $entry_rates; ?></td>
           <td><textarea name="rates" cols="80" rows="3" ><?php echo $rates; ?></textarea>
         </tr>
         <tr>
           <td><?php echo $entry_sort_order; ?></td>
           <td><input name="sort_order" value="<?php echo $sort_order; ?>" size="1" /></td>
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
         <tr>
           <td><?php echo $entry_door_delivery; ?></td>
           <td><?php if ($door_delivery) { ?>
             <input type="radio" name="door_delivery" value="1" checked="checked" />
             <?php echo $text_yes; ?>
             <input type="radio" name="door_delivery" value="0" />
             <?php echo $text_no; ?>
             <?php } else { ?>
             <input type="radio" name="door_delivery" value="1" />
             <?php echo $text_yes; ?>
             <input type="radio" name="door_delivery" value="0" checked="checked" />
             <?php echo $text_no; ?>
             <?php } ?></td></tr>
         <tr>
           <td><?php echo $entry_cash_on_delivery; ?></td>
           <td><?php if ($cash_on_delivery) { ?>
             <input type="radio" name="cash_on_delivery" value="1" checked="checked" />
             <?php echo $text_yes; ?>
             <input type="radio" name="cash_on_delivery" value="0" />
             <?php echo $text_no; ?>
             <?php } else { ?>
             <input type="radio" name="cash_on_delivery" value="1" />
             <?php echo $text_yes; ?>
             <input type="radio" name="cash_on_delivery" value="0" checked="checked" />
             <?php echo $text_no; ?>
             <?php } ?></td></tr>
         </tr>
       </table>
       <table id="shipment_details" class="list">
         <thead>
           <tr>
             <td class="left"><?php echo $column_warehouse_paramters; ?></td>
             <td class="left"><?php echo $column_s_order; ?></td>
             <td class="right"><?php echo $column_action; ?></td>
           </tr>
         </thead>
         <?php $shipment_detail_row = 0; ?>
         <?php foreach ($shipment_details as $shipment_detail) { ?>
         <tbody id="shipment_detail-row<?php echo $shipment_detail_row; ?>">
          <tr>
            <td class="left">
              <?php echo $entry_region; ?>&nbsp;
              <input type="text" name="shipment_detail[<?php echo $shipment_detail_row; ?>][region]" value="<?php echo $shipment_detail['region']; ?>" size="50" /></br>
              <?php echo $entry_city; ?>&nbsp;
              <input type="text" name="shipment_detail[<?php echo $shipment_detail_row; ?>][city]" value="<?php echo $shipment_detail['city']; ?>" size="50" /></br>
              <?php echo $entry_address; ?>&nbsp;
              <input type="text" name="shipment_detail[<?php echo $shipment_detail_row; ?>][address]" value="<?php echo $shipment_detail['address']; ?>" size="50" /></br>
              <?php echo $entry_phone; ?>&nbsp;
              <input type="text" name="shipment_detail[<?php echo $shipment_detail_row; ?>][phone]" value="<?php echo $shipment_detail['phone']; ?>" size="50" /></br>
              <?php echo $entry_map_link; ?>&nbsp;
              <input type="text" name="shipment_detail[<?php echo $shipment_detail_row; ?>][map_link]" value="<?php echo $shipment_detail['map_link']; ?>" size="50" /></br>
              <?php echo $entry_information; ?>&nbsp;
              <input type="text" name="shipment_detail[<?php echo $shipment_detail_row; ?>][information]" value="<?php echo $shipment_detail['information']; ?>" size="50" /></br>
             </td>
             <td class="left"><input name="shipment_detail[<?php echo $shipment_detail_row; ?>][sort_order]" value="<?php echo $shipment_detail['sort_order']; ?>" size="1" /></td>
             <td class="right">
              <a onclick="$('#shipment_detail-row<?php echo $shipment_detail_row; ?>').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a>
             </td>
           </tr>           
         </tbody>
         <?php $shipment_detail_row++; ?>
         <?php } ?>
         <tfoot>
           <tr>
             <td colspan="2"></td>
             <td class="right">
               <a onclick="addShipmentDetail();" class="button"><span class="button_left button_insert"></span><span class="button_middle"><?php echo $button_add_shipment_detail; ?></span><span class="button_right"></span></a>
             </td>
           </tr>
         </tfoot>
       </table>
  </div>
</form>
<script type="text/javascript"><!--
var shipment_detail_row = <?php echo $shipment_detail_row; ?>;

function addShipmentDetail() {
html  = '<tbody id="shipment_detail-row' + shipment_detail_row + '">';
html += '<tr>';
html += '<td class="left">';
html += '<?php echo $entry_region; ?>&nbsp;';
html += '<input type="text" name="shipment_detail[' + shipment_detail_row + '][region]" value="" size="50" /></br>';
html += '<?php echo $entry_city; ?>&nbsp;';
html += '<input type="text" name="shipment_detail[' + shipment_detail_row + '][city]" value="" size="50" /></br>';
html += '<?php echo $entry_address; ?>&nbsp;';
html += '<input type="text" name="shipment_detail[' + shipment_detail_row + '][address]" value="" size="50" /></br>';
html += '<?php echo $entry_phone; ?>&nbsp;';
html += '<input type="text" name="shipment_detail[' + shipment_detail_row + '][phone]" value="" size="50" /></br>';
html += '<?php echo $entry_map_link; ?>&nbsp;';
html += '<input type="text" name="shipment_detail[' + shipment_detail_row + '][map_link]" value="" size="50" /></br>';
html += '<?php echo $entry_information; ?>&nbsp;';
html += '<input type="text" name="shipment_detail[' + shipment_detail_row + '][information]" value="" size="50" /></br>';
html += '</td>';
html += '<td class="left"><input name="shipment_detail[' + shipment_detail_row  + '][sort_order]" value="0" size="1" /></td>'
html += '<td class="right"><a onclick="$(\'#shipment_detail-row' + shipment_detail_row  + '\').remove();" class="button"><span class="button_left button_delete"></span><span class="button_middle"><?php echo $button_remove; ?></span><span class="button_right"></span></a></td>';
html += '</tr>';
html += '</tbody>'; 

$('#shipment_details tfoot').before(html);

shipment_detail_row++;
}
//--></script>
<script type="text/javascript"><!--
$.tabs('.tabs a'); 
//--></script>
<?php echo $footer; ?>