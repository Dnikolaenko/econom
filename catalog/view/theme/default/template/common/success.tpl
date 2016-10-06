<?php echo $header; ?>
<div id="content_columns">
<?php echo $column_left; ?>
<div id="content">
  <div class="middle">
  <div class="heading"><?php echo $heading_title; ?></div>
    
  <?php echo $text_message; ?>
  <a class="hider">Внимание нововведение!!!</a>
  
    
 
    <div id="hidden" style="display: none;">
        <p>   Уважаемые клиенты!</p>
        <br>
        <p>На сайте economtochka.com.ua произошли изменения по работе корзины, а именно, мы ввели «разделение заказов» на заказ№1 и заказ№2. Теперь на сайте имеются 2 группы товаров, на которые выставляются 2 разных счета-фактуры, 2 разных окна для оплаты  электронными платежами.</p>
        <p class="new_blue">Зачем это нужно?</p>
        <p>Такое нововведение позволило расширить ассортимент и представить нашим клиентам более доступные цены и решения. Чтобы работать в рамках действующего законодательства, нам необходимо было внедрить на сайт новый функционал.</p>
        <p class="new_blue">Так что же происходит в корзине? </p>
        <p>При заказе в корзине формируется счет на оплату товара. При наличии в заказе 2 и более единиц товара разных производителей, попавших в разные группы, система сайта может разбить Ваш заказ на 2 счета. Не удивляйтесь!</p>
        <p class="new_blue">Что дальше?</p>
        <ul class="new_rule">
            <li>1.Дальше, после оформления заказа вы увидите страницу «Ваш заказ был успешно оформлен!» и 2 поля: «Заказ №1» и «Заказ №2». </li>
            <li>2.На каждом из полей будут кнопки «Счет-фактура на предоплату», «Счет-фактура» и «Оплата». Вы выбираете нужное поле в зависимости от способа оплаты.</li>
            <li>2.1«Счет-фактура на предоплату» - счет на 50% предоплату безналичным расчетом</li>
            <li>2.2«Счет-фактура» - счет на оплату товаров безналичным расчетом.</li>
            <li>2.3«Оплата» - оплата с помощью электронных платежей.</li>
            <li>3.В зависимости от выбранного способа оплаты, Вы нажимаете нужную кнопку для оплаты «Заказа №1» и «Заказа №2».</li>
            <li>4.Вам нужно оплатить оба счета, для приобретения всех выбранных товаров!</li>
        </ul>
        <br>
        <p>
            Если Вам понадобилась помощь или консультация по оплате счетов, Вы также можете обратиться в наш Call-центр, где менеджеры Вам с удовольствием помогут. 
        </p>
        <br>
        <p>
            Приятных покупок. Спасибо, что Вы с нами.
        </p>
        <br>
        <p class="new_rule_bold">
             С уважением команда интернет-магазина «ЭкономТочка»
        </p>
    </div>
  <?php if ($order_info_one > 0){ ?>
  <h2><?php echo $invoice_one; ?></h2>

    <div class="buttons">
      <table>
        <tr>
          <td align="left" width="33%"><a onclick="window.open('<?php echo $prepayment_nds_invoice; ?>');" class="button"><span><?php echo $button_prepayment_invoice; ?></span></a></td>
          <td align="center" width="33%"><a onclick="window.open('<?php echo $nds_invoice; ?>');" class="button"><span><?php echo $button_nds_invoice; ?></span></a></td>
          <?php if (isset($datas)) { ?>
            <td align="right" width="33%">
            <form method="POST" action="https://www.liqpay.com/api/checkout" id="liqpay" accept-charset="utf-8">
              <input type="hidden" name="data"  value="<?php echo $datas; ?>" />
              <input type="hidden" name="signature" value="<?php echo $signatures; ?>" />
              <a onclick="ga('send', 'event', 'oplata_online', 'click', 'button'); setTimeout(function(){ $('#liqpay').submit(); }, 500); return;" class="button"><span><?php echo $button_pay; ?></span></a>
            </form>
          </td> 
          <?php } ?>
        </tr>
      </table>
    </div>
  <?php } ?>
  <?php if ($order_info_two > 0){ ?>
  <h2><?php echo $invoice_two; ?></h2>
    <div class="buttons">
      <table>
        <tr>
          <td align="left" width="33%"><a onclick="window.open('<?php echo $prepayment_invoice; ?>');" class="button"><span><?php echo $button_prepayment_invoice; ?></span></a></td>
          <td align="center" width="33%"><a onclick="window.open('<?php echo $invoice; ?>');" class="button"><span><?php echo $button_invoice; ?></span></a></td>
          <?php if (isset($data)) { ?>
            <td align="right" width="33%">
            <form method="POST" action="https://www.liqpay.com/api/checkout" id="liqpays" accept-charset="utf-8">
              <input type="hidden" name="data"  value="<?php echo $data; ?>" />
              <input type="hidden" name="signature" value="<?php echo $signature; ?>" />
              <a onclick="ga('send', 'event', 'oplata_online', 'click', 'button'); setTimeout(function(){ $('#liqpays').submit(); }, 500); return;" class="button"><span><?php echo $button_pay; ?></span></a>
            </form>
          </td> 
          <?php } ?>
        </tr>
      </table>
    </div>
  <?php } ?>
    <a onclick="location='<?php echo $continue; ?>'" class="button" id="comebackbro"><span><?php echo $button_continue; ?></span></a>
    <div class="payu"><img src="/image/payu/logos-07.png" width="100%" /></div>
  </div>
</div>
</div>
<?php if ($ga_ecommerce_output) { echo $ga_ecommerce_output; echo $oms_output; } ?>
<script type="text/javascript">
 document.getElementById("liqpay").onsubmit = function(){
     window.open('<?php echo $oplataone; ?>');
     <?php if ($order_info_two > 0){ ?>
     window.open('<?php echo $oplatatwo; ?>');
     <?php } ?>
     return false;
 }   
</script>
<script type="text/javascript">
document.getElementById("liqpays").onsubmit = function(){
     <?php if($order_info_one > 0){ ?>
     window.open('<?php echo $oplataone; ?>');
     <?php } ?>
     window.open('<?php echo $oplatatwo; ?>');
     return false;
 }   
</script>
<script type="text/javascript">// <![CDATA[
$(document).ready(function(){
    $(".hider").click(function(){
        $("#hidden").slideToggle("slow");
        return false;
    });
});
// ]]></script>
<?php echo $footer; ?>
