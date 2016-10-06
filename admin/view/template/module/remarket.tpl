<?php echo $header; ?>
<div class="heading">
  <h1><?php echo $heading_title; ?></h1>
  <div class="buttons"><a onclick="$('#form').submit();" class="button"><span class="button_left button_save"></span><span class="button_middle"><?php echo $button_save; ?></span><span class="button_right"></span></a><a onclick="location='<?php echo $cancel; ?>';" class="button"><span class="button_left button_cancel"></span><span class="button_middle"><?php echo $button_cancel; ?></span><span class="button_right"></span></a></div>
</div>
  <div class="box">
  <div class="tabs"><a tab="#tab_general"><?php echo "Ремаректинг"; ?></a></div>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
  <table class="form">
  <tr>
  <td><?php echo $unloads; ?></td>
  <td><button id="unload" name="unload">Выгрузка</button></td>
  </tr>
  <tr>
  <td><?php echo $entry_status; ?></td>
        <td><select name="remarket_status">
            <?php if ($remarket_status) { ?>
            <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
            <option value="0"><?php echo $text_disabled; ?></option>
            <?php } else { ?>
            <option value="1"><?php echo $text_enabled; ?></option>
            <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
            <?php } ?>
          </select></td>
  </tr>
  </form>
<!--  <form action="<?php echo $action; ?>" method="POST" enctype="multipart/form-data" id="forms">
  <tr>
  <td><?php echo $upload_price; ?></td>
  <td><input type="file" name="file"></td><td><input type="submit" value="Загрузить"></td>
  </tr>
  </form>
  <tr>
  <td><?php echo $file_name; ?></td>
  <td>
    <select>
      <option>Название файла</option>
    </select>
  </td>
  <td><button id="compare" name="compare">Перезаписать</td>
  </tr>
  <tr>
  <td><?php echo $update; ?></td>
  <td><button id="update" name="update">Обновить</button></td>
  </tr> -->
  </table>
  </div>
</div>  
<?php echo $footer; ?>