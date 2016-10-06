<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
    <div class="heading"><h1><?php echo $heading_title; ?></h1></div>
    <table>
      <?php foreach ($news as $news_info) { ?>
        <tr><td>
          <?php echo $news_info['date_added']; ?>&nbsp;-&nbsp;<a href="<?php echo $news_info['href']; ?>"><?php echo $news_info['anons']; ?></a><br />
        </td></tr>
      <?php } ?>
    </table>
    </div>
  </div>
</div>
<?php echo $footer; ?> 