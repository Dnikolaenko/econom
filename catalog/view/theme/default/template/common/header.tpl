<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<meta name="google-site-verification" content="Bkb8QV_ka5Mu7tlVVXdlBudfYphyOyV4kV93ojhWB-w" />
<meta name="yandex-verification" content="5ca9c1357b9c1541" />
<meta name="cmsmagazine" content="0225b83d65f5abd3f311ba82859ed3eb" />

<base href="<?php echo $base; ?>" />
<?php if ($icon) { ?>
<link href="image/<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/unitpngfix/unitpngfix.js"></script>
<![endif]-->
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-migrate-1.1.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jcarousellite_1.0.1.pack.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.easing.js.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.mousewheel.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/thickbox/thickbox-compressed.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/thickbox/thickbox.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tab.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/tooltip/jquery.tooltip.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/tooltip/jquery.tooltip.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.simplemodal.1.4.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/callback.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/nivo.slider/jquery.nivo.slider.pack.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/nivo.slider/nivo-slider.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/nivo.slider/themes/default/default.css" />

<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider({
        effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
        pauseTime: <?php echo $config_slideshow_delay; ?>,  // How long each slide will show
        prevText: 'Пред.', // Prev directionNav text
        nextText: 'След.', // Next directionNav text
        controlNav: false // 1,2,3... navigation
    });
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42635325-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
</head>
<body>
<?php /*
<script type="text/javascript">
(function (tos) {
  window.setInterval(function () {
    tos = (function (t) {
      return t[0] == 50 ? (parseInt(t[1]) + 1) + ':00' : (t[1] || '0') + ':' + (parseInt(t[0]) + 10);
    })(tos.split(':').reverse());
    window.pageTracker ? pageTracker._trackEvent('Time', 'Log', tos) : ga('send', 'event', 'Time', 'Log');
  }, 10000);
})('00');
</script>

<!-- Oh My Stats tracker -->
<script type="text/javascript">
  //<![CDATA[
    var _oms = window._oms || [];
    _oms.push(["set_project_id", "mtexigfkpejwvmsmrpyxklfwotwviptdmwxtftby"]);
    _oms.push(["set_domain", ".economtochka.com.ua"]);

    (function() {
      var oms = document.createElement("script");
      oms.type = "text/javascript";
      oms.async = true;
      oms.src = "//ohmystats.com/oms.js";
      var s = document.getElementsByTagName("script")[0];
      s.parentNode.insertBefore(oms, s);
    })();
  //]]>
</script>
*/ ?>
<?php if (count($top_banners) > 0) { ?>
<?php $i = 0; ?>
<div id="top_banners">
<?php foreach ($top_banners as $top_banner) { ?>
<?php if ($top_banner['view_type'] == 's') { ?>
<div style="width: 960px; margin-left: auto; margin-right: auto;">
<div class="slider-wrapper theme-default">
<div id="top_slider_<?php echo $i; ?>" class="nivoSlider">
<?php } ?>
<?php if (isset($top_banner['images'])) { ?>
<?php foreach ($top_banner['images'] as $slide) { ?>
<?php if ($slide['link']) { ?>
<a href="<?php echo $slide['link']; ?>"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>" /></a>
<?php } else { ?>
<img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>" />
<?php } ?>
<?php } ?>
<?php } ?>
<?php if ($top_banner['view_type'] == 's') { ?>
</div></div></div>
<script type="text/javascript">
$(window).load(function() {
    $('#top_slider_<?php echo $i; ?>').nivoSlider({
        effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
        pauseTime: <?php echo $config_slideshow_delay; ?>,  // How long each slide will show
        prevText: 'Пред.', // Prev directionNav text
        nextText: 'След.', // Next directionNav text
        controlNav: false // 1,2,3... navigation
    });
});
</script>
<?php $i++; ?>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="container">
  <div id="header">
    <div class="div1">
      <div class="div2"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $store; ?>" alt="<?php echo $store; ?>" /></a></div>
      <div class="contact">
      <!--<a href="index.php?route=pricelist/price" >Фид</a>-->
        <?php if ($config_telephone_left && $config_telephone_right) { ?>
        <div class="contact_left"><?php echo $config_telephone_left; ?></div>
        <div class="contact_right"><?php echo $config_telephone_right; ?></div>
        <?php } else { ?>
        <div class="contact_single"><?php echo $config_telephone_right; ?></div>
        <?php } ?>
      </div>
      <div id="module_cart">
        <?php if ($count_products > 0) { ?>
        <a href="<?php echo $cart; ?>">
        <div class="cart_image" id="image" onclick="location='<?php echo $cart; ?>'"><img src="catalog/view/theme/default/image/cart_full.png" alt="" /></div>
        <?php } else { ?>
        <div class="cart_image" id="image"><img src="catalog/view/theme/default/image/cart_empty.png" alt="" /></div>
        <?php } ?>
        <div class="cart_contents">
          <?php if ($count_products > 0) { ?>
          <div><span><?php echo $text_cart; ?></span><?php //echo $text_subtotal; ?>&nbsp;<?php echo $subtotal; ?></div>
          <?php } else { ?>
          <div style="color: #ffffff;"><span><?php echo $text_cart; ?></span><?php echo $text_empty; ?></div>
          <?php } ?>
        </div>
        <?php if ($count_products > 0) { ?>
        </a>
        <?php } ?>
<script type="text/javascript"><!--
function display_loading_window(){
  var my_width  = 0;
  var my_height = 0;

  // Getting left, top and Y-offset for window display.
  if ( typeof( window.innerWidth ) == 'number' ) {
    my_width  = window.innerWidth;
    my_height = window.innerHeight;
  }
  else if ( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    my_width  = document.documentElement.clientWidth;
    my_height = document.documentElement.clientHeight;
  }
  else if ( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    my_width  = document.body.clientWidth;
    my_height = document.body.clientHeight;
  }

  var scrollY = 0;

  if ( document.documentElement && document.documentElement.scrollTop ) {
    scrollY = document.documentElement.scrollTop;
  } else if ( document.body && document.body.scrollTop ) {
    scrollY = document.body.scrollTop;
  }
  else if ( window.pageYOffset ) {
    scrollY = window.pageYOffset;
  }
  else if ( window.scrollY ) {
    scrollY = window.scrollY;
  }
  var divheight = $('loading-layer').height();
  var divwidth  = $('loading-layer').width();

  divheight = divheight ? divheight : 50;
  divwidth  = divwidth  ? divwidth  : 200;

  var setX = ( my_width  - divwidth  ) / 2;
  var setY = ( my_height - divheight ) / 2 + scrollY;

  setX = ( setX < 0 ) ? 0 : setX;
  setY = ( setY < 0 ) ? 0 : setY;

  $('#loading-layer').css({'left' : setX + 'px', 'top' : setY + 'px', 'position' : 'absolute', 'display' : 'block', 'z-index' : '99'}).show();
}
//--></script>
<?php if ($ajax) { ?>
<script type="text/javascript"><!--
$(function () {
 //$('#add_to_cart').replaceWith('<a onclick="" id="add_to_cart" class="button">' + $('#add_to_cart').html() + '</a>');
 $('#add_to_cart').replaceWith('<div class="button_buy" onclick="" id="add_to_cart" />');
 $('#add_to_cart').click(function () {
        var qty = $("#product :input[name='quantity']");
        if (isNaN(qty.val())||qty.val()<0||qty.val()==0) {
            alert("<?php echo $text_add_error; ?>");
            return;
        }
        var min_qty = $("#product :input[name='min_order_qty']");
        if(qty.val()%min_qty.val() > 0) {
            alert("<?php echo $text_min_order_qty_error; ?>");
            return;
        }

        display_loading_window();
        
  $.ajax({
   type: 'post',
   url: 'index.php?route=module/cart/newcallback',
   dataType: 'html',
   data: $('#product :input'),
   success: function (html) {
    $('#module_cart').html(html);
   },
   complete: function () {
                <?php // 100203 ALNAUA Fixed bug with animation, mailto, changed price position Begin
                //var image = $('#image').offset();
    //var cart  = $('#module_cart').offset(); ?>
                var image = $('#image').position();
    var cart  = $('#module_cart').position();
                <?php // 100203 ALNAUA Fixed bug with animation, mailto, changed price position End ?>

    $('#image').before('<img src="' + $('#image').attr('src') + '" id="temp" style="position: absolute; top: ' + image.top + 'px; left: ' + image.left + 'px;" />');

    params = {
                    <?php // 100203 ALNAUA Fixed bug with animation, mailto, changed price position Begin
     //top : cart.top + 'px', ?>
                    top : cart.top - 100 + 'px',
                    <?php // 100203 ALNAUA Fixed bug with animation, mailto, changed price position End ?>
                    <?php // 100223 ALNAUA Site redesign Begin ?>
                    //left : cart.left + 'px',
                    left : cart.left - 200 + 'px',
                    <?php // 100223 ALNAUA Site redesign End ?>
     opacity : 0.0,
                    <?php // 100203 ALNAUA Fixed bug with animation, mailto, changed price position Begin
     //width : $('#module_cart').width(),
     //heigth : $('#module_cart').height() ?>
                    width : 50 + 'px',
     heigth : 50 + 'px'
    };

    $('#temp').animate(params, 'slow', false, function () {
     $('#temp').remove();
    });
    $('#loading-layer').css('display', 'none').hide();
    ga('send', 'event', 'buy', 'click', 'button');
   }
  });
 });
});
//--></script>
<?php } ?>
</div>
      <?php /*
      <div class="contact">
          <!-- webim button --><a href="/webim/client.php?locale=ru" target="_blank" onclick="if(navigator.userAgent.toLowerCase().indexOf('opera') != -1 &amp;&amp; window.event.preventDefault) window.event.preventDefault();this.newWindow = window.open('/webim/client.php?locale=ru&amp;url='+escape(document.location.href)+'&amp;referrer='+escape(document.referrer), 'webim', 'toolbar=0,scrollbars=0,location=0,status=1,menubar=0,width=640,height=480,resizable=1');this.newWindow.focus();this.newWindow.opener=window;return false;"><img src="/webim/b.php?i=webim&amp;lang=ru" border="0" width="163" height="61" alt=""/></a><!-- / webim button -->
      </div>
      */ ?>
<?php /*
<div class="div3"><?php echo $language; ?></div>
*/ ?>
</div>
<div class="div4">
<span class="slogan"><?php echo $text_slogan; ?></span>
<span class="work_time"><?php echo $text_work_time; ?></span>
<span id="contact-form" class="contact_callback"><?php echo $text_callback; ?></span>
</div>
<script type="text/javascript"><!--
jQuery(function ($) {
 var contact = {
  message: null,
  init: function () {
   $('#contact-form').click(function (e) {
    e.preventDefault();

    
    $.get("index.php?route=callback/callback", function(data){

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
        url: 'index.php?route=callback/callback/send',
        data: $('#contact-container form').serialize(),
        type: 'post',
        cache: false,
        dataType: 'html',
        success: function (data) {
         $('#contact-container .contact-loading').fadeOut(200, function () {
          $('#contact-container .contact-title').html('<?php echo $text_callback_thanks; ?>');
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
   $('#contact-container .contact-title').html('<?php echo $text_callback_bye; ?>');
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
    return false;

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
//--></script>
    <div class="navi">
      <table class="navigation">
        <tbody>
          <tr>
            <?php /*<td<?php echo ($active == 'discount' ? ' class="active"' : ''); ?>><a class="first" href="<?php echo $discount; ?>"><span><?php echo $text_discount; ?></span></a></td>
            <td class="split"></td> */ ?>
            <?php /*<td<?php echo ($active == 'week_product' ? ' class="active"' : ''); ?>><a class="first" href="<?php echo $week_product; ?>"><span><?php echo $text_week_product; ?></span></a></td>
            <td class="split"></td> */ ?>
            <td<?php echo ($active == 'no_enter' ? ' class="active"' : ''); ?>><a class="first" href="<?php echo $no_enter; ?>"><span><?php echo $text_no_enter; ?></span></a></td>
            <td class="split"></td>
            <td<?php echo ($active == 'freeshipping' ? ' class="active"' : ''); ?>><a class="regular" href="<?php echo $freeshipping; ?>"><span><?php echo $text_freeshipping; ?></span></a></td>
            <td class="split"></td>
            <td<?php echo ($active == 'payment' ? ' class="active"' : ''); ?>><a class="regular" href="<?php echo $payment; ?>"><span><?php echo $text_payment; ?></span></a></td> 
            <?php /*<td class="split"></td>
            <td<?php echo ($active == 'credit' ? ' class="active"' : ''); ?>><a class="regular" href="<?php echo $credit; ?>"><span><?php echo $text_credit; ?></span></a></td> */?>
            <td class="split"></td>
            <td<?php echo ($active == 'advice' ? ' class="active"' : ''); ?>><a class="regular" href="<?php echo $advice; ?>"><span><?php echo $text_advice; ?></span></a></td>
            <td class="split"></td>
            <td<?php echo ($active == 'news' ? ' class="active"' : ''); ?>><a class="regular" href="<?php echo $news; ?>"><span><?php echo $text_news; ?></span></a></td>
            <td class="split"></td>
            <td<?php echo ($active == 'ask' ? ' class="active"' : ''); ?>><a class="regular" href="<?php echo $ask; ?>"><span><?php echo $text_ask; ?></span></a></td>
            <td class="split"></td>
            <td<?php echo ($active == 'contact' ? ' class="active"' : ''); ?>><a class="last" href="<?php echo $contacts; ?>"><span><?php echo $text_contacts; ?></span></a></td>
          </tr>
        </tbody>
      </table>
    </div>
    
  </div>
  <div id="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php } ?>
  </div>

  <div id="loading-layer">
    <div id="loading-layer-text"><?php echo $text_loading; ?></div><br />
    <img src="catalog/view/theme/default/image/loading.gif" alt="<?php echo $text_loading; ?>" />
  </div>