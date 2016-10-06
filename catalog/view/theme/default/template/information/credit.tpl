<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
    <div class="heading"><h1><?php echo $heading_title; ?></h1></div>
    <table>
      <?php foreach ($credits as $credit) { ?>
        <tr><td>
          <a href="<?php echo $credit['href']; ?>"><?php echo $credit['name']; ?></a><br />
        </td></tr>
      <?php } ?>
    </table>
    <?php foreach ($credits as $credit) { ?>
      <br />
      <br />
      <div class="heading_product">
        <a name="<?php echo $credit['anchor_name']; ?>"><?php echo $credit['name']; ?></a><br />
      </div>
      <div class="description" style="margin-top: 15px;">
        <?php echo $credit['description']; ?>
      </div>
    <?php } ?>
    </div>
  </div>
</div>
<?php echo $footer; ?> 