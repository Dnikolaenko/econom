<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle">
      <div style="width: 100%; margin-bottom: 30px;">
        <table style="width: 100%; border-collapse: collapse;">
          <tr>
            <td style="text-align: center; width: 42%; vertical-align: top;">
              <div style="position: relative;">
              <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="thickbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" style="margin-bottom: 3px;" /></a><br />
              <span style="font-size: 11px;"><?php echo $text_enlarge; ?></span>
              <?php if ($product_videos) { ?>
              <br /><br />
              <div id="videos">
               <?php foreach ($product_videos as $product_video) { ?>
               <a href="#" title="<?php echo $product_video['name']; ?>" name="basic<?php echo $product_video['video_id']; ?>">
               <img src="<?php echo $video_icon; ?>" title="<?php echo $product_video['name']; ?>" alt="<?php echo $product_video['name']; ?>" />
               </a>
               <div id="video<?php echo $product_video['video_id']; ?>" style="display:none;"><h3><?php echo $product_video['name']; ?></h3><?php echo $product_video['video_code']; ?></div>
               <?php } ?>
               <script type="text/javascript"><!--
               jQuery(function ($) {
                // Load dialog on click
                <?php foreach ($product_videos as $product_video) { ?>
                //$('#videos .basic<?php echo $product_video['video_id']; ?>').click(function (e) {
                $('#videos a[name="basic<?php echo $product_video['video_id']; ?>"]').click(function (e) {
                 $('#video<?php echo $product_video['video_id']; ?>').modal();
                 return false;
                });
                <?php } ?>
               });
               //--></script>
              </div>
              <?php } ?>
              <?php if ($products) { ?>
              <?php if (!$product_videos) { ?>
              <br /><br />
              <?php } ?>
              <div class="related_span"><?php echo $text_related; ?></div>
              <div class="carousel default">
                <a href="#" class="prev">&nbsp</a>
                  <div class="related">
                    <ul><?php foreach ($products as $product) { ?>
                    <li><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name'] .' - '. $product['model']; ?>" alt="<?php echo $product['name'] .' - '. $product['model']; ?>" width="60px;" /></a></li>
                    <?php } ?></ul>
                  </div>
                <a href="#" class="next">&nbsp</a>
                <div class="clear"></div>
              </div>
              <?php } ?>
              <div id="price">
              </div>
                  <?php if ($akcia == TRUE) { ?>
                  <div class="old_price"><?php echo $price; ?></div>
                  <?php } ?>
              </div>
              <div class="description" style="margin-top: 15px;">
                <?php echo $advanced_description; ?>
              </div>
            </td>
            <td style="padding-left: 15px; width: 58%; vertical-align: top;">
              <div class="heading_product">
                <?php /*<a href="<?php echo $back; ?>"><div id="back"><?php echo $text_back; ?></div></a> */?>
                <h1><?php echo $heading_title; ?></h1>
                <?php echo $model; ?>
              </div>
              <?php if ($display_price) { ?>
              <?php if ($discounts) { ?>
              <div class="discount">
                <ul><?php echo $text_discount; ?>
                    <?php foreach ($discounts as $discount) { ?>
                      <li>
                          <?php echo $text_order_quantity .' '. $discount['quantity'] .' '. $text_unit_meas .' '; ?>
                          <?php echo $text_price_per_item .' - '. $discount['price']; ?>
                      </li>
                    <?php } ?>
                </ul>
              </div>
              <?php } ?>
              <?php } ?>

              <?php if ($display_price) { ?>
              <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="product">
               <?php if ($manufacturer) { ?>
               <div><b><?php echo $text_manufacturer; ?></b> <?php echo $manufacturer; ?></div>
              <?php } ?>
                <?php if ($options) { ?>
                <?php /*<b><?php echo $text_options; ?></b><br /> */?>
                <div style="background: #FFFFCC; border: 1px solid #FFCC33; padding: 10px; margin-top: 2px; margin-bottom: 15px;">
                  <table style="width: 100%;">
                    <?php foreach ($options as $option) { ?>
                    <tr>
                      <td><b><?php echo $option['name']; ?>:</b><br />
                        <?php if ($option['color_option']) { ?>
                          <?php if (count($option['option_value']) >= 1) { ?>
                          <input type="hidden" name="option[<?php echo $option['option_id']; ?>]" value="<?php echo $option['option_value'][0]['option_value_id']; ?>" />
                          <div id="color_description<?php echo $option['option_id']; ?>" style="font-size: 10px;"><?php echo $option['option_value'][0]['name'].($option['option_value'][0]['price'] ? $option['option_value'][0]['prefix'].$option['option_value'][0]['price'] : ''); ?></div>
                          <div id="preview<?php echo $option['option_id']; ?>" style="float: left; margin-top: 5px;"><img id="preview_img<?php echo $option['option_id']; ?>" src="<?php echo $option['option_value'][0]['color_image']; ?>" alt="<?php echo $option['option_value'][0]['name'].($option['option_value'][0]['price'] ? $option['option_value'][0]['prefix'].$option['option_value'][0]['price'] : ''); ?>" title="<?php echo $option['option_value'][0]['name'].($option['option_value'][0]['price'] ? $option['option_value'][0]['prefix'].$option['option_value'][0]['price'] : ''); ?>" /></div>
                          <div id="color_picker<?php echo $option['option_id']; ?>" style="float: left; margin-top: 5px; margin-left: 10px; ">
                          <?php if ($option['option_value']) { ?>
                            <?php $first = true; $j = 0; $colorcategory = substr($option['option_value'][0]['name'], 0, strpos($option['option_value'][0]['name'], '->')-1);?>
                            <?php for ($i = 0; $i < sizeof($option['option_value']); $i++) { ?>
                              <?php if (isset($option['option_value'][$i])) { ?>
                                <?php if ($first) { ?>
                                  <b><?php echo substr($option['option_value'][$i]['name'], 0, strpos($option['option_value'][$i]['name'], '->')-1); ?>:</b><a title="<?php echo substr($option['option_value'][$i]['name'], 0, strpos($option['option_value'][$i]['name'], '->')-1); ?>" class="color_cat_tip" colorcategory_id="<?php echo $option['option_value'][$i]['colorcategory_id']; ?>"><img style="position: relative; left: 3px;" src="catalog/view/theme/default/image/qmark.gif" alt="" /></a><span id="colorcategory_id<?php echo $option['option_value'][$i]['colorcategory_id']; ?>" style="display: none;"><?php echo $option['option_value'][$i]['colorcategory_tip']; ?></span><br />
                                <?php } ?>
                                <?php if ($colorcategory != substr($option['option_value'][$i]['name'], 0, strpos($option['option_value'][$i]['name'], '->')-1)) { ?>
                                  <br />
                                  <b><?php echo substr($option['option_value'][$i]['name'], 0, strpos($option['option_value'][$i]['name'], '->')-1); ?>:</b><a title="<?php echo substr($option['option_value'][$i]['name'], 0, strpos($option['option_value'][$i]['name'], '->')-1); ?>" class="color_cat_tip" colorcategory_id="<?php echo $option['option_value'][$i]['colorcategory_id']; ?>"><img style="position: relative; left: 3px;" src="catalog/view/theme/default/image/qmark.gif" alt="" /></a><span id="colorcategory_id<?php echo $option['option_value'][$i]['colorcategory_id']; ?>" style="display: none;"><?php echo $option['option_value'][$i]['colorcategory_tip']; ?></span><br />
                                  <?php $j = 0; $colorcategory = substr($option['option_value'][$i]['name'], 0, strpos($option['option_value'][$i]['name'], '->')-1);?>
                                <?php } ?>
                                <a onclick="$('#preview_img<?php echo $option['option_id']; ?>').attr('src', '<?php echo $option['option_value'][$i]['color_image']; ?>'); $('#preview_img<?php echo $option['option_id']; ?>').attr('alt', this.title); $('#preview_img<?php echo $option['option_id']; ?>').attr('title', this.title); $('#color_description<?php echo $option['option_id']; ?>').html(this.title); $('input[type=\'hidden\'][name=\'option[<?php echo $option['option_id']; ?>]\']').val('<?php echo $option['option_value'][$i]['option_value_id']; ?>'); $('#color_picker<?php echo $option['option_id']; ?> img').removeClass('color_picker_highlight'); $(this).children().addClass('color_picker_highlight');recalculateprice();" title="<?php echo $option['option_value'][$i]['name'].($option['option_value'][$i]['price'] ? $option['option_value'][$i]['prefix'].$option['option_value'][$i]['price'] : ''); ?>" style="margin: 1px;">
                                  <img<?php echo ($first ? ' class="color_picker_highlight" ' : ''); ?> name="<?php echo $option['option_value'][$i]['option_value_id']; ?>" src="<?php echo $option['option_value'][$i]['color_thumb']; ?>" alt="<?php echo $option['option_value'][$i]['name'].($option['option_value'][$i]['price'] ? $option['option_value'][$i]['prefix'].$option['option_value'][$i]['price'] : ''); ?>" title="<?php echo $option['option_value'][$i]['name'].($option['option_value'][$i]['price'] ? $option['option_value'][$i]['prefix'].$option['option_value'][$i]['price'] : ''); ?>" />
                                </a>
                              <?php $first = false; $j++;?>
                              <?php if ((($j%8) == 0) && ($j != 0)) { ?>
                                <br />
                                <?php $j = 0; ?>
                              <?php } ?>
                              <?php } ?>
                            <?php } ?>
                          <?php } ?>
                          </div>
                          <?php } ?>
                        <?php } else { ?>
                          <select name="option[<?php echo $option['option_id']; ?>]" onchange="recalculateprice();">
                            <?php foreach ($option['option_value'] as $option_value) { ?>
                            <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['name']; ?>
                            <?php if ($option_value['price']) { ?>
                            <?php echo $option_value['prefix']; ?><?php echo $option_value['price']; ?>
                            <?php } ?>
                            </option>
                            <?php } ?>
                          </select>
                        <?php } ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                  <?php } ?>
                </div>
                <?php if ($min_order_qty > 1) { ?>
                <div style="font-size: medium; color: #ec7500; margin-bottom: 15px;"><?php echo $text_min_order_qty; ?> <?php echo $min_order_qty; ?></div>
                <?php } ?>
                <div style="background: #F7F7F7; border: 1px solid #DDDDDD; padding: 10px;">
                  <table>
                    <tr>
                      <td align="left"><?php echo $text_qty; ?></td>
                      <?php if ($product_id == 3227) { ?>
                      <td align="left"><input type="text" name="quantity" size="3" value="100" /></td>
                      <?php } else { ?>
                      <td align="left"><input type="text" name="quantity" size="3" value="1" /></td>
                      <?php } ?>
                      <input type="hidden" name="min_order_qty" size="3" value="<?php echo $min_order_qty; ?>" />
                      <td align="center" width="160"><div class="button_buy" onclick="ga('send', 'event', 'buy', 'click', 'button'); setTimeout(function(){ $('#product').submit(); }, 500); return;" id="add_to_cart" /></td>
                      <td align="center" width="160"><div class="buttonOneClick"><span id="contact-forms" class="contact_callback"><?php echo $text_one_click; ?></span></div></td>
                    </tr>
                  </table>
                </div>
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
                <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <input type="hidden" name="form_name" value="fizlico" />
              </form>
              <br />
              <?php if ($show_min_price_warranty > 0) { ?>
              <div style="text-align: center; width: 100%; margin-bottom: 10px;">
                <?php /*<a id="min_price_warranty_id_a" title="<?php echo $text_min_price_warranty; ?>" class="cat_tip" cat_id="min_price_warranty"><img src="image/min_price_warranty.png" alt="" /></a><span id="cat_idmin_price_warranty" style="display: none;"><?php echo $show_min_price_warranty_text; ?></span> */?>
               <a id="min_price_warranty_id_a" href="<?php echo $show_min_price_warranty_href; ?>" title="<?php /*echo $text_min_price_warranty;*/ ?>" target="_blank"><img src="image/min_price_warranty.png" title="<?php /*echo $text_min_price_warranty;*/ ?>" alt="<?php echo $text_min_price_warranty; ?>" /></a>
              </div>
              <?php } ?>
              <div style="text-align: left; vertical-align: top; color: gray; width: 50%; float: left;">
                <?php if ($credit_id > 0) { ?>
                  <a href="<?php echo $credit_href; ?>" title="<?php echo $text_credit .' '. $credit_name; ?>" target="_blank"><img src="<?php echo $credit_image; ?>" title="<?php echo $text_credit .' '. $credit_name; ?>" alt="<?php echo $text_credit .' '. $credit_name; ?>" /></a>
                <?php } ?>
              </div>
              <div style="text-align: right; vertical-align: top; font-size: 14px; width: 50%; float: right;">
                <?php if ($techparams) { ?>
                  <b><?php echo $text_techparam; ?></b><br />
                  <?php foreach ($techparams as $techparam) { ?>
                  <?php echo $techparam['name'].(isset($techparam['unit']) ? ', '.$techparam['unit'].' - ' : ' - ').$techparam['value']; ?><br />
                  <?php } ?>
                <?php } ?>
              </div>
              <br />
              <div class="description" style="clear:both;"><?php echo $description; ?></div>
              <table style="width: 100%; border-collapse: collapse;">
              <tr>
                <td style="text-align: left; width: 50%; vertical-align: top;">
                  <?php /*<div class="info">
                    <?php echo $text_how_to_buy; ?>
                  </div>*/ ?>
                  
                </td>
                <td style="text-align: right; width: 50%; vertical-align: top; color: gray;">
                
                </td>
              </tr>
              </table>
              <?php } ?></td>
          </tr>
        </table>
        <br />
        <div align="right" style="color:#ec7500;"><small><?php echo $text_color_info; ?></small></div>
        <?php if($ga == TRUE) { ?>
        <div style="display:inline;">
        <img height="1" width="1" style="border-style:none;" alt="" src="/googleads.g.doubleclick.net/pagead/viewthroughconversion/933818405/?value=0&amp;guid=ON&amp;script=0"/>
        </div>
        <?php } ?>
      </div>
  <!-- код для Гугл эдвордc -->
<script type="text/javascript" src="/www.googleadservices.com/pagead/conversion.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 933818405;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
  <script type="text/javascript"><!--
  function refreshImage(option){
    $('#color_img').attr('src', option.title);
  }
  //--></script>
  <script type="text/javascript"><!--
      $(function() {
      $(".default .related").jCarouselLite({
          btnNext: ".default .next",
          btnPrev: ".default .prev",
          /*mouseWheel: true,*/
          visible: <?php echo (sizeof($products) >= 4 ? 4 : sizeof($products)) ?>,
          circular: true
      });
  });
  //--></script>
  <script type="text/javascript"><!--
  function recalculateprice(){
    
    display_loading_window();

    $.ajax({
        type: 'post',
        url: 'index.php?route=product/product/recalculateprice',
        dataType: 'html',
        data: $('#product :input'),
        success: function (html) {
            $('#price').html(html);
        },
        complete: function () {
            params = {
                'fontSize' : '14pt'
            };

            $('.price_int').css('font-size', '2em').animate(params, 'slow');
            $('#price').css('padding-top', '23px').animate({'paddingTop' : '25px'}, 'slow');
            $('#loading-layer').css('display', 'none').hide();
          }
    });
  }
  recalculateprice();
  //--></script>
  <script type="text/javascript"><!--
    $('.color_cat_tip').tooltip({
      track: true, 
      delay: 150,
      showURL: false, 
      showBody: " |-| ",
      fade: 500,
      bodyHandler: function() {
         return $('#colorcategory_id' + $(this).attr("colorcategory_id")).html();
       }
    });
  //--></script>
  <script type="text/javascript"><!--
    $('#min_price_warranty_id_a').mouseenter(function(){  
        ga('send', 'event', 'pricemin', 'actions', 'priceminbutton');  
    }); 
  //--></script>
    </div>
</div>
</div>
<script type="text/javascript">
  var google_tag_params = {
    dynx_itemid: "<?php echo $product_id; ?>",
    dynx_pagetype: "product",
  };
</script>

//oneclick
<script type="text/javascript">
jQuery(function ($) {
 var contact = {
  message: null,
  init: function () {
   $('#contact-forms').click(function (e) {
    e.preventDefault();

    
    $.get("index.php?route=callback/oneClick", function(data){

     $(data).modal({
      closeHTML: "<a href='#' title='Close' class='modal-close'>x</a>",
      position: ["15%",],
      overlayId: 'contact-overlay',
      containerId: 'contact-container',
      onOpen: contact.open,
      onShow: contact.show,
      onClose: contact.close
     });
    });
   });
  },
  open: function (dialog) {
   if ($.browser.mozilla) {
    $('#contact-container .contact-button').css({
     'padding-bottom': '2px'
    });
   }

   if ($.browser.safari) {
    $('#contact-container .contact-input').css({
     'font-size': '.9em'
    });
   }

   var h = 140;
   if ($('#contact-subject').length) {
    h += 40;
   }
   
   if ($('#contact-message').length) {
    h += 114;
   }
   
   if ($('#contact-cc').length) {
    h += 22;
   }

   var title = $('#contact-container .contact-title').html();
   $('#contact-container .contact-title').html('<?php echo $text_loading; ?><center><img src=catalog/view/theme/default/image/loading_1.gif></center>');
   dialog.overlay.fadeIn(200, function () {
    dialog.container.fadeIn(200, function () {
     dialog.data.fadeIn(200, function () {
      $('#contact-container .contact-content').animate({
       height: h
      }, function () {
       $('#contact-container .contact-title').html(title);
       $('#contact-container form').fadeIn(200, function () {
        $('#contact-container #contact-name').focus();

        $('#contact-container .contact-cc').click(function () {
         var cc = $('#contact-container #contact-cc');
         cc.is(':checked') ? cc.attr('checked', '') : cc.attr('checked', 'checked');
        });

        if ($.browser.msie && $.browser.version < 7) {
         $('#contact-container .contact-button').each(function () {
          if ($(this).css('backgroundImage').match(/^url[("']+(.*\.png)[)"']+$/i)) {
           var src = RegExp.$1;
           $(this).css({
            backgroundImage: 'none',
            filter: 'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' +  src + '", sizingMethod="crop")'
           });
          }
         });
        }
       });
      });
     });
    });
   });
  },
  show: function (dialog) {
   $('#contact-container .contact-send').click(function (e) {
    e.preventDefault();

    if (contact.validate()) {
     var msg = $('#contact-container .contact-message');
     msg.fadeOut(function () {
      msg.removeClass('contact-error').empty();
     });
     $('#contact-container .contact-title').html('<?php echo $text_sending; ?>');
     $('#contact-container form').fadeOut(200);
     $('#contact-container .contact-content').animate({
      height: '80px'
     }, function () {
      $('#contact-container .contact-loading').fadeIn(200, function () {
       $.ajax({
        url: 'index.php?route=callback/oneClick/send',
        data: $('#contact-container form').serialize(),
        type: 'post',
        cache: false,
        dataType: 'html',
        success: function (data) {
         $('#contact-container .contact-loading').fadeOut(200, function () {
          $('#contact-container .contact-title').html('<?php echo $text_click_thanks; ?>');
          msg.html(data).fadeIn(200);
         });
        },
        error: contact.error
       });
      });
     });
    }
    else {
     if ($('#contact-container .contact-message:visible').length > 0) {
      var msg = $('#contact-container .contact-message div');
      msg.fadeOut(200, function () {
       msg.empty();
       contact.showError();
       msg.fadeIn(200);
      });
     }
     else {
      $('#contact-container .contact-message').animate({
       height: '30px'
      }, contact.showError);
     }
     
    }
   });
  },
  close: function (dialog) {
   $('#contact-container .contact-message').fadeOut();
   $('#contact-container .contact-title').html('<?php echo $text_click_bye; ?>');
   $('#contact-container form').fadeOut(200);
   $('#contact-container .contact-content').animate({
    height: 40
   }, function () {
    dialog.data.fadeOut(200, function () {
     dialog.container.fadeOut(200, function () {
      dialog.overlay.fadeOut(200, function () {
       $.modal.close();
      });
     });
    });
   });
  },
  error: function (xhr) {
   alert(xhr.statusText);
  },
  validate: function () {
   contact.message = '';
   if (!$('#contact-container #contact-name').val()) {
    contact.message += 'Заполните имя! ';
   }

   var phone = $('#contact-container #contact-phone').val();
   if (!phone) {
    contact.message += 'Введите телефон! ';
   }
   else {
    if (!contact.validatephone(phone)) {
     contact.message += 'Неверный телефон! ';
    }
   }
   
   if ($('#contact-container #contact-message').length) {
     if (!$('#contact-container #contact-message').val()) {
      contact.message += 'Введите сообщение! ';
     }
   }

   if (contact.message.length > 0) {
    return false;
   }
   else {
    return true;
   }
  },
  validatephone: function (phone) {
   var at = phone.lastIndexOf("@");

   if (!/^[0-9]{5,12}$/.test(phone))
    return true;

   return true;
  },
  showError: function () {
   $('#contact-container .contact-message')
    .html($('<div class="contact-error"></div>').append(contact.message))
    .fadeIn(200);
  }
 };

 contact.init();

});
</script>
<script>
  var input = document.getElementById('contact-name');
  input.style.display = "none";
</script>

<?php echo $footer; ?> 