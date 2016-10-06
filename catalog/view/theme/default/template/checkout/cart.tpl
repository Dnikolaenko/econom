<?php echo $header; ?>
<div id="content_columns">
  <?php echo $column_left; ?>
  <div id="content">
    <div class="middle" style="padding-bottom: 1px;">
      <div class="heading">
        <h1><?php echo $heading_title; ?></h1>
      </div>
      <?php if ($error_warning) { ?>
      <div class="warning"><?php echo $error_warning; ?></div>
      <?php } ?>
      <?php if ($success) { ?>
      <div class="success"><?php echo $success; ?></div>
      <?php } ?>
            <div style="float: right; width: 40%; text-align: right;"><a href="javascript:clear();">Удалить все</a></div>
        <script type="text/javascript">
        function hover_items () {
              $('td.sborka').hover(function(){ $(this).closest('div.cartrow').addClass('hover');
                                               $(this).addClass('sborka-hover');
                                               $(this).closest('tr').children('td:last-child').addClass('delete-hover');
                                             },
                                   function(){ $(this).closest('div.cartrow').removeClass('hover');
                                               $(this).removeClass('sborka-hover')
                                               $(this).closest('tr').children('td:last-child').removeClass('delete-hover');
                                             }
                                  );
              $('td.delete').hover(function(){ $(this).closest('div.cartrow').addClass('hover');
                                               $(this).addClass('delete-hover');
                                               $(this).closest('tr').children('td:first-child').addClass('sborka-hover');
                                             },
                                   function(){ $(this).closest('div.cartrow').removeClass('hover');
                                               $(this).removeClass('delete-hover')
                                               $(this).closest('tr').children('td:first-child').removeClass('sborka-hover');
                                             }
                                  );
             
        };
          
        function hover_itemss () {
              $('td.sborka').hover(function(){ $(this).closest('div.cartrows').addClass('hover');
                                               $(this).addClass('sborka-hover');
                                               $(this).closest('tr').children('td:last-child').addClass('delete-hover');
                                             },
                                   function(){ $(this).closest('div.cartrows').removeClass('hover');
                                               $(this).removeClass('sborka-hover')
                                               $(this).closest('tr').children('td:last-child').removeClass('delete-hover');
                                             }
                                    );
              $('td.delete').hover(function(){ $(this).closest('div.cartrows').addClass('hover');
                                               $(this).addClass('delete-hover');
                                               $(this).closest('tr').children('td:first-child').addClass('sborkas-hover');
                                             },
                                   function(){ $(this).closest('div.cartrows').removeClass('hover');
                                               $(this).removeClass('delete-hover')
                                               $(this).closest('tr').children('td:first-child').removeClass('sborkas-hover');
                                             }
                                    );
             
            };
          
         function remove_product(pk) {
            $.ajax({
                type: 'post',
                url: 'index.php?route=checkout/cart/remove_refresh',
                data: ({product_key : pk, buy_credit : $('#buy_credit').is(':checked')}),
                success: function (html) {
                    $('#cart_contents').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                        }
                    });
                    hover_items ();
                location.reload();
                }
            });
         };
         
        function remove_products(pk) {
            $.ajax({
                type: 'post',
                url: 'index.php?route=checkout/cart/remove_refresh_second_order',
                data: ({product_key : pk, buy_credit : $('#buy_credit').is(':checked')}),
                success: function (html) {
                    $('#cart_contentss').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                        }
                    });
                    hover_itemss ();
                location.reload();
                }
            });
         };
         
        function update_sborka(box, pk) {
            $.ajax({
                type: 'get',
                url: 'index.php?route=checkout/cart/update_sborka',
                data: ({product_key : pk, checked : box.checked, buy_credit : $('#buy_credit').is(':checked')}),
                success: function (html) {
                    $('#cart_contents').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                        }
                    });
                    hover_items ();
                    //location.reload();
                }
            });
         };
         
        function update_sborkas(box, pk) {
            $.ajax({
                type: 'get',
                url: 'index.php?route=checkout/cart/update_sborka_second_order',
                data: ({product_key : pk, checked : box.checked, buy_credit : $('#buy_credit').is(':checked')}),
                success: function (html) {
                    $('#cart_contentss').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                        }
                    });
                    hover_itemss ();
                    //location.reload(); 
                }
            });
         };
         
         function check_sborka() {
           $.ajax({
                type: 'get',
                data: ({buy_credit :  $('#buy_credit').is(':checked')}),
                url: 'index.php?route=checkout/cart/check_sborka',
                success: function (html) {
                   $('#cart_contents').html(html);
                   $.ajax({
                      type: 'get',
                      url: 'index.php?route=module/cart/newcallback',
                      dataType: 'html',
                      success: function (html) {
                          $('#module_cart').html(html);
                          $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                      }
                  });
                  hover_items ();
                  //location.reload();
               }
            });
        };
         
        function check_sborkas() {
           $.ajax({
                type: 'get',
                data: ({buy_credit :  $('#buy_credit').is(':checked')}),
                url: 'index.php?route=checkout/cart/check_sborka_second_order',
                success: function (html) {
                   $('#cart_contentss').html(html);
                   $.ajax({
                      type: 'get',
                      url: 'index.php?route=module/cart/newcallback',
                      dataType: 'html',
                      success: function (html) {
                          $('#module_cart').html(html);
                          $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                      }
                  });
                  hover_itemss ();
                  //location.reload();
               }
            });
           
         };
    function clear() {
            $.ajax({
                type: 'get',
                data: ({buy_credit :  $('#buy_credit').is(':checked')}),
                url: 'index.php?route=checkout/cart/clear',
                success: function (html) {
                    $('#cart_contents').html(html);
                    $('#cart_contentss').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipment_detail_f').html(html);
                                            $('#shipment_detail_j').html(html);
                                        }
                                    });
                                }
                            });
                        location.reload();
                        }
                    });
                }
            });
         };
         
         function update_door_delivery(object) {
          if ($("#door_delivery_"+object).is(":checked")) {
           $('input[name=address_1]').each(function() {
               $(this).parent().addClass("zirka");
           });
           $('#shipment_detail_f').closest('tr').hide();
           $('#shipment_detail_j').closest('tr').hide();
          } else {
           $('input[name=address_1]').each(function() {
               $(this).parent().removeClass("zirka");
           });
           $('#shipment_detail_f').closest('tr').show();
           $('#shipment_detail_j').closest('tr').show();
          }
         };
         function update_cash_on_delivery(object) {
          if (object == 'f') {
           if ($('#cash_on_delivery_f').is(':checked')) {
            $('#cash_on_delivery_j').attr("checked", "checked");
            $("#shipment_f option[cash_on_delivery=0]").each(function() {
             $(this).attr("disabled", "disabled");
            });
            $("#shipment_j option[cash_on_delivery=0]").each(function() {
             $(this).attr("disabled", "disabled");
            });
           } else {
            $("#shipment_f option[cash_on_delivery=0]").each(function() {
             $(this).removeAttr("disabled");
            });
            $("#shipment_j option[cash_on_delivery=0]").each(function() {
             $(this).removeAttr("disabled");
            $('#cash_on_delivery_j').removeAttr("checked");
            });
           }
          } else {
           if ($('#cash_on_delivery_j').is(':checked')) {
            $('#cash_on_delivery_f').attr("checked", "checked");
            $("#shipment_j option[cash_on_delivery=0]").each(function() {
             $(this).attr("disabled", "disabled");
            });
            $("#shipment_f option[cash_on_delivery=0]").each(function() {
             $(this).attr("disabled", "disabled");
            });
           } else {
            $("#shipment_j option[cash_on_delivery=0]").each(function() {
             $(this).removeAttr("disabled");
            });
            $("#shipment_f option[cash_on_delivery=0]").each(function() {
             $(this).removeAttr("disabled");
            $('#cash_on_delivery_f').removeAttr("checked");
            });
           }
          }
         };
         
        function update_shipment(object) {
            if ($("#shipment_"+object+" option:selected").attr("cash_on_delivery") == 1) {
             $('#cash_on_delivery_f').removeAttr("disabled");
             $('#cash_on_delivery_j').removeAttr("disabled");
            } else {
             $('#cash_on_delivery_f').attr("disabled", "disabled");
             $('#cash_on_delivery_j').attr("disabled", "disabled");
            }
            if ($("#shipment_"+object+" option:selected").attr("door_delivery") == 1) {
             $('#door_delivery_f').removeAttr("disabled");
             $('#door_delivery_j').removeAttr("disabled");
            } else {
             $('#door_delivery_f').attr("disabled", "disabled");
             $('#door_delivery_j').attr("disabled", "disabled");
            }
            $.ajax({
                type: 'get',
                data: ({buy_credit :  $('#buy_credit').is(':checked'), shipment_id : $("#shipment_"+object).val()}),
                url: 'index.php?route=checkout/cart/update_shipment',
                success: function (html) {
                    $('#cart_contents').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                    update_cash_on_delivery('f');
                                    update_cash_on_delivery('j');
                                    $.ajax({
                                        type: 'get',
                                        url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                        dataType: 'html',
                                        success: function (html) {
                                            if(html) {
                                             $('#shipment_detail_f').closest('tr').show();
                                             $('#shipment_detail_j').closest('tr').show();
                                             $('#shipment_detail_f').html(html);
                                             $('#shipment_detail_j').html(html);
                                              update_shipment_detail(object);
                                             if ($("#shipment_"+object+" option:selected").attr("door_delivery") == 1) {
                                              $('#door_delivery_f').removeAttr("disabled");
                                              $('#door_delivery_j').removeAttr("disabled");
                                              $('#door_delivery_f').removeAttr("checked");
                                              $('#door_delivery_j').removeAttr("checked");
                                              $('input[name=address_1]').each(function() {
                                               $(this).parent().removeClass("zirka");
                                               });
                                              } else {
                                              $('#door_delivery_f').removeAttr("checked");
                                              $('#door_delivery_j').removeAttr("checked");
                                              $('input[name=address_1]').each(function() {
                                              $(this).parent().removeClass("zirka");
                                               });
                                              }     
                                            } else {
                                             $('#shipment_detail_f').closest('tr').hide();
                                             $('#shipment_detail_j').closest('tr').hide();
                                             $('#door_delivery_f').attr("disabled", "disabled");
                                             $('#door_delivery_f').attr("checked", "checked");
                                             $('#door_delivery_j').attr("disabled", "disabled");
                                             $('#door_delivery_j').attr("checked", "checked");
                                             $('input[name=address_1]').each(function() {
                                              $(this).parent().addClass("zirka");
                                             });
                                            }
                                        }
                                    });
                                }
                            });
                        }
                    });
                }
            });
        if (object == 'f') {
         $("#shipment_j [value='"+$( "#shipment_f" ).val()+"']").attr("selected", "selected");
         } else {
         $("#shipment_f [value='"+$( "#shipment_j" ).val()+"']").attr("selected", "selected");
        }
    };
         
        function update_shipments(object) {
            if ($("#shipment_"+object+" option:selected").attr("cash_on_delivery") == 1) {
             $('#cash_on_delivery_f').removeAttr("disabled");
             $('#cash_on_delivery_j').removeAttr("disabled");
            } else {
             $('#cash_on_delivery_f').attr("disabled", "disabled");
             $('#cash_on_delivery_j').attr("disabled", "disabled");
            }
            if ($("#shipment_"+object+" option:selected").attr("door_delivery") == 1) {
             $('#door_delivery_f').removeAttr("disabled");
             $('#door_delivery_j').removeAttr("disabled");
            } else {
             $('#door_delivery_f').attr("disabled", "disabled");
             $('#door_delivery_j').attr("disabled", "disabled");
            }
            $.ajax({
                type: 'get',
                data: ({buy_credit :  $('#buy_credit').is(':checked'), shipment_id : $("#shipment_"+object).val()}),
                url: 'index.php?route=checkout/cart/update_shipment_second',
                success: function (html) {
                    $('#cart_contentss').html(html);
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=module/cart/newcallback',
                        dataType: 'html',
                        success: function (html) {
                            $('#module_cart').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_f').html(html);
                                    $('#shipment_j').html(html);
                                        update_cash_on_delivery('f');
                                        update_cash_on_delivery('j');
                                        $.ajax({
                                            type: 'get',
                                            url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                            dataType: 'html',
                                            success: function (html) {
                                                if(html) {
                                                 $('#shipment_detail_f').closest('tr').show();
                                                 $('#shipment_detail_j').closest('tr').show();
                                                 $('#shipment_detail_f').html(html);
                                                 $('#shipment_detail_j').html(html);
                                                 update_shipment_detail(object);
                                                    if ($("#shipment_"+object+" option:selected").attr("door_delivery") == 1) {
                                                     $('#door_delivery_f').removeAttr("disabled");
                                                     $('#door_delivery_j').removeAttr("disabled");
                                                     $('#door_delivery_f').removeAttr("checked");
                                                     $('#door_delivery_j').removeAttr("checked");
                                                     $('input[name=address_1]').each(function() {
                                                      $(this).parent().removeClass("zirka");
                                                     });
                                                    } else {
                                                     $('#door_delivery_f').removeAttr("checked");
                                                     $('#door_delivery_j').removeAttr("checked");
                                                     $('input[name=address_1]').each(function() {
                                                     $(this).parent().removeClass("zirka");
                                                     });
                                                    }     
                                                } else {
                                                 $('#shipment_detail_f').closest('tr').hide();
                                                 $('#shipment_detail_j').closest('tr').hide();
                                                 $('#door_delivery_f').attr("disabled", "disabled");
                                                 $('#door_delivery_f').attr("checked", "checked");
                                                 $('#door_delivery_j').attr("disabled", "disabled");
                                                 $('#door_delivery_j').attr("checked", "checked");
                                                 $('input[name=address_1]').each(function() {
                                                 $(this).parent().addClass("zirka");
                                                 });
                                                }
                                            }
                                        });
                                    }
                            });
                        }
                    });
                }
            });
        if (object == 'f') {
         $("#shipment_j [value='"+$( "#shipment_f" ).val()+"']").attr("selected", "selected");
        } else {
         $("#shipment_f [value='"+$( "#shipment_j" ).val()+"']").attr("selected", "selected");
        }
    };
           
         function update_shipment_detail(object) {
            if (object == 'f') {
             $("#shipment_detail_j [value='"+$( "#shipment_detail_f" ).val()+"']").attr("selected", "selected");
            } else {
             $("#shipment_detail_f [value='"+$( "#shipment_detail_j" ).val()+"']").attr("selected", "selected");
            }
            $.ajax({
                type: 'get',
                data: ({shipment_detail_id : $("#shipment_detail_"+object ).val()}),
                url: 'index.php?route=checkout/cart/update_shipment_detail',
            });
         };
         
        function update_credit(box) {
            $.ajax({
                type: 'get',
                data: ({buy_credit : box.checked}),
                url: 'index.php?route=checkout/cart/update_credit',
                success: function (html) {
                    $('#cart_contents').html(html);   
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=checkout/cart/update_shipment_combo',
                        dataType: 'html',
                        success: function (html) {
                            $('#shipment_f').html(html);
                            $('#shipment_j').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_detail_f').html(html);
                                    $('#shipment_detail_j').html(html);
                                }
                            });
                        }
                    });
                    hover_items ();
                }
            });
        }
        
        function update_credits(box) {
            $.ajax({
                type: 'get',
                url: 'index.php?route=checkout/cart/update_credit_second',
                data: ({buy_credit : box.checked}),
                success: function (html) {
                    $('#cart_contentss').html(html);    
                    $.ajax({
                        type: 'get',
                        url: 'index.php?route=checkout/cart/update_shipment_combo',
                        dataType: 'html',
                        success: function (html) {
                            $('#shipment_f').html(html);
                            $('#shipment_j').html(html);
                            $.ajax({
                                type: 'get',
                                url: 'index.php?route=checkout/cart/update_shipment_detail_combo',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipment_detail_f').html(html);
                                    $('#shipment_detail_j').html(html);
                                }
                            });
                        }
                    });
                    hover_items ();
                }
            });
        } 
       </script>
        <script type="text/javascript">

          // -- fizlico
          var dataFromClients = new Array(
                                    '<?php echo ($email == $text_email ? '' : $email); ?>',
                                    '<?php echo ($fio == $text_fio ? '' : $fio); ?>',
                                    '<?php echo ($telephone == $text_telephone ? '' : $telephone); ?>',
                                    '<?php echo ($address_1 == $text_address_1 ? '' : $address_1); ?>',
                                    ''
                                  );
          var startValueInput = new Array();
          var startText = new Array(
                            '<?php echo $text_email; ?>',
                            '<?php echo $text_fio; ?>',
                            '<?php echo $text_telephone; ?>',
                            '<?php echo $text_address_1; ?>'
                          );

          // -- urlico
          var dataFromClientsUr = new Array(
                                    '<?php echo ($email == $text_email ? '' : $email); ?>',
                                    '<?php echo ($company == $text_company ? '' : $company); ?>',
                                    '<?php echo ($postcode == $text_postcode ? '' : $postcode); ?>',
                                    '<?php echo ($address_1 == $text_address_1 ? '' : $address_1); ?>',
                                    '<?php echo ($address_2 == $text_address_2 ? '' : $address_2); ?>',
                                    '<?php echo ($telephone == $text_telephone ? '' : $telephone); ?>',
                                    ''
                                  );
          var startValueInputUr = new Array();
          var startTextUr = new Array(
                            '<?php echo $text_email; ?>',
                            '<?php echo $text_company; ?>',
                            '<?php echo $text_postcode; ?>',
                            '<?php echo $text_address_1; ?>',
                            '<?php echo $text_address_2; ?>',
                            '<?php echo $text_telephone; ?>'
                          );
      </script>
<?php if ($products_count > 0) { ?>
<?php if($nds_sub_total > 0) { ?>
<div id="order_nds">
    <div class="offer">
        <h2><?php echo $offer_nds; ?></h2>
    </div>
    <div style="height: 20px;">
      <div style="float: left; width: 40%;"><img src="catalog/view/theme/default/image/cart-sborka-icon.png" width="13px" height="13px" /><a href="javascript:check_sborka();">Все со сборкой</a></div>
    </div>
    <?php } ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="cart">
<div id="cart_contents">
    <input type="hidden" value="cart" name="form_name" />
<?php foreach ($products as $product) { ?>
    <?php if ($product['nds'] == 1) { ?>
              <div class="cartrow" id="<?php echo $product['key']; ?>">
                  <table class="carttable">
                      <tr>
                          <?php if ($product['sborka'] == 1) { ?>
                          <td class="sborka" align="center" title="<?php echo $text_sborka; ?>"><input id="<?php echo $product['key']; ?>" onclick="update_sborka(this,'<?php echo $product['key']; ?>');" class="sborkachkbox" type="checkbox" name="sborka[<?php echo $product['key']; ?>]" checked /></td>
                          <?php } else { ?>
                          <td class="sborka" align="center" title="<?php echo $text_sborka; ?>"><input id="<?php echo $product['key']; ?>" onclick="update_sborka(this,'<?php echo $product['key']; ?>');" class="sborkachkbox" type="checkbox" name="sborka[<?php echo $product['key']; ?>]" /></td>
                          <?php } ?>
                          <td width="75px"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
                          <td width="47%">
                              <a href="<?php echo $product['href']; ?>"><b><?php echo $product['name']; ?></b></a>&nbsp;<span style="font-size: x-small;"><?php echo $product['model']; ?></span>
                              <div>
                                  <?php if ($buy_credit && $product['credit_id'] > 0) { ?>
                                  - <small><span style="color: black;"><b><?php echo $text_credit; ?></b></span> <?php echo $product['credit_name']; ?></small><br />
                                  <?php } ?>
                                  <?php foreach ($product['option'] as $option) { ?>
                                  - <small><span style="color: black;"><b><?php echo $option['name']; ?>:</b></span> <?php echo html_entity_decode($option['value'], ENT_NOQUOTES, 'UTF-8'); ?></small><br />
                                  <?php } ?>
                              </div>
                          </td>
                          <td align="center">
                              <input class="quantity" type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="3" /><br /><small><?php echo $text_quantity; ?></small>
                              <input class="quantity" type="hidden" name="min_order_qty[<?php echo $product['key']; ?>]" size="3" value="<?php echo $product['min_order_qty']; ?>" />
                              <input class="quantity" type="hidden" name="product_name[<?php echo $product['key']; ?>]" value="<?php echo $product['name']; ?>" />
                          </td>
                          <td align="right"><?php echo $product['price']; ?></td>
                          <td align="right"><?php echo $product['total']; ?></td>
                          <td class="delete" title="<?php echo $text_delete; ?>">
                              <div class="cartdelete" onclick="remove_product('<?php echo $product['key']; ?>');">&nbsp;</div>
                          </td>
                      </tr>
                  </table> 
              </div>
    <?php } ?>
  <?php } ?> 
  <?php if($nds_sub_total > 0) { ?>
                <div style="margin-right: 24px;" align="right"><b><?php echo $text_sborka_only; ?></b> <?php echo $sborka_only; ?></div>
                <div style="margin-right: 24px;" align="right"><b><?php echo $text_sub_total; ?></b> <?php echo $nds_sub_total; ?></div>
                <div style="margin-right: 24px;" align="right"><b><?php echo $text_total_nds; ?></b> <?php echo $nds; ?></div>
                <div style="margin-right: 24px;" align="right"><b><?php echo $text_order_discount; ?></b> <?php echo $order_discount; ?></div>
                <div style="margin-right: 24px;" align="right"><b><?php echo $text_shipment; ?></b> <?php echo $shipment_cost; ?></div>
                <div style="margin-right: 24px; margin-bottom: 15px;" align="right"><b><?php echo $text_total; ?></b> <?php echo $nds_total; ?></div>   
                <table width="100%">
                  <tr>
                      <td align="right"><a id="button_update" class="button"><span><?php echo $button_update; ?></span></a></td>
                  </tr>
                </table>
        <script type="text/javascript">
                    $('#button_update').click(function () {
                      //console.log($('#button_update').click(function(){}));
                        var ok = true;
                        $(".cartrow").each(function() {
                            var pk = $(this).attr('id');
                            var qty = $("input[name='quantity\[" + pk + "\]']").val();
                            var min_qty = $("input[name='min_order_qty\[" + pk + "\]']").val();
                            if(qty%min_qty > 0) {
                                alert("<?php echo $text_min_order_qty_error; ?><?php echo $text_good; ?>" +  $("input[name='product_name\[" + pk + "\]']").val() + "<?php echo $text_min_order_qty; ?>" + min_qty);
                                ok = false;
                                return;
                            }
                            //console.log($("input[name='quantity\[" + pk + "\]']").val());
                            //console.log($("input[name='min_order_qty\[" + pk + "\]']").val());
                        });
                        if (!ok) { return false; }
                        $('#cart').submit();
                    });
        </script>
    </div>  
  </form>                       
  </div>
    <?php } ?>
<?php if($totsal > 0) { ?>                     
    <div id="order_no_nds">
    <div class="offer">
    <h2><?php echo $offer_no_nds; ?></h2>
    </div>          
    <div style="height: 20px;">
    <div style="float: left; width: 40%;"><img src="catalog/view/theme/default/image/cart-sborka-icon.png" width="13px" height="13px" /><a href="javascript:check_sborkas();">Все со сборкой</a></div>
  <!--  <div style="float: right; width: 40%; text-align: right;"><a href="javascript:clears();">Удалить все</a></div> -->
    </div>  
<?php } ?>
<?php foreach ($products as $product) { ?>
    <?php if ($product['nds'] == 0) { ?>
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="carts">
    <div id="cart_contentss">
            <input type="hidden" value="cart" name="form_name" />
        <div class="cartrows" id="<?php echo $product['key']; ?>">
            <table class="carttable">
                <tr>
                    <?php if ($product['sborka'] == 1) { ?>
                    <td class="sborka" align="center" title="<?php echo $text_sborka; ?>"><input id="<?php echo $product['key']; ?>" onclick="update_sborkas(this,'<?php echo $product['key']; ?>');" class="sborkachkbox" type="checkbox" name="sborka[<?php echo $product['key']; ?>]" checked /></td>
                    <?php } else { ?>
                    <td class="sborka" align="center" title="<?php echo $text_sborka; ?>"><input id="<?php echo $product['key']; ?>" onclick="update_sborkas(this,'<?php echo $product['key']; ?>');" class="sborkachkbox" type="checkbox" name="sborka[<?php echo $product['key']; ?>]" /></td>
                    <?php } ?>
                    <td width="75px"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></td>
                    <td width="47%">
                        <a href="<?php echo $product['href']; ?>"><b><?php echo $product['name']; ?></b></a>&nbsp;<span style="font-size: x-small;"><?php echo $product['model']; ?></span>
                        <div>
                            <?php foreach ($product['option'] as $option) { ?>
                            - <small><span style="color: black;"><b><?php echo $option['name']; ?>:</b></span> <?php echo html_entity_decode($option['value'], ENT_NOQUOTES, 'UTF-8'); ?></small><br />
                            <?php } ?>
                        </div>
                    </td>
                    <td align="center">
                        <input class="quantity" type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" size="3" /><br /><small><?php echo $text_quantity; ?></small>
                        <input class="quantity" type="hidden" name="min_order_qty[<?php echo $product['key']; ?>]" size="3" value="<?php echo $product['min_order_qty']; ?>" />
                        <input class="quantity" type="hidden" name="product_name[<?php echo $product['key']; ?>]" value="<?php echo $product['name']; ?>" />
                    </td>
                    <td align="right"><?php echo $product['price']; ?></td>
                    <td align="right"><?php echo $product['total']; ?></td>
                    <td class="delete" title="<?php echo $text_delete; ?>">
                        <div class="cartdelete" onclick="remove_products('<?php echo $product['key']; ?>');">&nbsp;</div>
                    </td>
                </tr>
            </table>
        </div>
    <?php } ?>
 <?php } ?>
 <?php if($totsal > 0) { ?>
                      <div style="margin-right: 24px;" align="right"><b><?php echo $text_sborka_only; ?></b> <?php echo $sborka_two; ?></div>
                      <div style="margin-right: 24px;" align="right"><b><?php echo $text_sub_total; ?></b> <?php echo $totsal; ?></div>
                      <div style="margin-right: 24px;" align="right"><b><?php echo $text_order_discount; ?></b> <?php echo $order_discount; ?></div>
                      <div style="margin-right: 24px;" align="right"><b><?php echo $text_shipment; ?></b> <?php echo $shipment_cost; ?></div>
                      <div style="margin-right: 24px; margin-bottom: 15px;" align="right"><b><?php echo $text_total; ?></b> <?php echo $no_nds_total; ?></div>
                      <table width="100%">
                          <tr>
                              <td align="right"><a id="button_updates" class="button"><span><?php echo $button_update; ?></span></a></td>
                          </tr>
                      </table>

        <script type="text/javascript">
                    $('#button_updates').click(function () {
                      //console.log($('#button_updates').click(function(){}));
                        var ok = true;
                        $(".cartrows").each(function() {
                            var pk = $(this).attr('id');
                            var qty = $("input[name='quantity\[" + pk + "\]']").val();
                            var min_qty = $("input[name='min_order_qty\[" + pk + "\]']").val();
                            if(qty%min_qty > 0) {
                                alert("<?php echo $text_min_order_qty_error; ?><?php echo $text_good; ?>" +  $("input[name='product_name\[" + pk + "\]']").val() + "<?php echo $text_min_order_qty; ?>" + min_qty);
                                ok = false;
                                return;
                            }
                            //console.log($("input[name='quantity\[" + pk + "\]']").val());
                            //console.log($("input[name='min_order_qty\[" + pk + "\]']").val());
                        });
                        if (!ok) { return false; }
                        $('#carts').submit();
                    });
        </script>      
    </div>                  
   </form>
                          </div>
    <?php } ?>

      <div class="tabs" style="margin-top: 25px;"><a tab="#tab_fizlico"><?php echo $tab_fizlico; ?></a><a tab="#tab_urlico"><?php echo $tab_urlico; ?></a></div>
        <div id="tab_fizlico" class="tab_page">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
          <input type="hidden" value="fizlico" name="form_name" />
          <input type="hidden" value="220" name="country_id" />
          <input type="hidden" value="3487" name="zone_id" />
          <input type="hidden" value="Бесплатная доставка" name="shipping_method" />
          <input type="hidden" value="Оплата при доставке" name="payment_method" />

          <table class="form" style="width: 100%">
            <tr>
              <td colspan="2">
                <?php if ($error_email_fiz) { ?>
                <span class="error"><?php echo $error_email_fiz; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $email; ?>" name="email" title="<?php echo $text_email; ?> " required /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_fio) { ?>
                <span class="error"><?php echo $error_fio; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $fio; ?>" name="fio" title="<?php echo $text_fio; ?> " required /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_telephone_fiz) { ?>
                <span class="error"><?php echo $error_telephone_fiz; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $telephone; ?>" name="telephone" title="<?php echo $text_telephone; ?>" required /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input id="cash_on_delivery_f" onclick="update_cash_on_delivery('f');" type="checkbox" name="cash_on_delivery" value="1" <?php echo ($cash_on_delivery ? ' checked' : ''); ?>  /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_cash_on_delivery; ?></span>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_address_1_fiz) { ?>
                <span class="error"><?php echo $error_address_1_fiz; ?></span>
                <?php } ?>
                <div class="input<?php echo ($door_delivery ? ' zirka' : ''); ?>">
                  <div class="left"></div><input type="text" value="<?php echo $address_1; ?>" name="address_1" title="<?php echo $text_address_1; ?>" required/><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_shipment; ?></td>
              <td><?php if (isset($shipments)) { ?>

    <?php if($totsal > 0 && $nds_sub_total > 0) { ?>
    <select name="shipment_id" id="shipment_f" onchange="update_shipment('f'); update_shipments('f');" onkeyup="update_shipment('f'); update_shipments('f');">
            <?php foreach ($products as $product) { ?>
                              <?php } ?>
    <?php } elseif ($product['nds'] == 0) { ?>
    <select name="shipment_id" id="shipment_f" onchange="update_shipments('f'); " onkeyup="update_shipments('f');">
    <?php } elseif ($product['nds'] == 1) { ?>
    <select name="shipment_id" id="shipment_f" onchange="update_shipment('f'); " onkeyup="update_shipment('f');">
    <?php } ?> 
                    <?php foreach ($shipments as $shipment) { ?>
                    <option value="<?php echo $shipment['shipment_id']; ?>"<?php echo ($shipment_id == $shipment['shipment_id'] ? ' selected="selected"' :'')?> door_delivery="<?php echo $shipment['door_delivery']; ?>" cash_on_delivery="<?php echo $shipment['cash_on_delivery']; ?>">
                      <?php echo $shipment['name']; ?>
                      <?php if ($shipment['cost']) { ?>
                       (<?php echo $shipment['cost']; ?>)
                      <?php } ?>
                     </option>
                     <?php } ?>
                    </select>
                <?php } ?>

              </td>
            </tr>
            <tr>
              <td><?php echo $entry_shipment_detail; ?></td>
              <td>
                  <select name="shipment_detail_id" id="shipment_detail_f" onchange="update_shipment_detail('f');" onkeyup="update_shipment_detail('f');">
                    <?php if (isset($shipment_details) && count($shipment_details) > 0) { ?>
                    <?php foreach ($shipment_details as $shipment_detail) { ?>
                    <option value="<?php echo $shipment_detail['shipment_detail_id']; ?>"<?php echo ($shipment_detail_id == $shipment_detail['shipment_detail_id'] ? ' selected="selected"' :'')?>>
                     <?php echo ($shipment_detail['region'].', '.$shipment_detail['city'].': '.$shipment_detail['address'].($shipment_detail['phone'] ? ', '.$shipment_detail['phone'] : '')); ?>
                    </option>
                    <?php } ?>
                    <?php } ?>
                 </select>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input id="door_delivery_f" onclick="update_door_delivery('f');" type="checkbox" name="door_delivery" value="1" <?php echo ($door_delivery ? ' checked' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_door_delivery; ?></span>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_buy_credit) { ?>
                <span class="error"><?php echo $error_buy_credit; ?></span>
                <?php } ?>
            <?php if($totsal > 0 && $nds_sub_total > 0) { ?>
                <input id="buy_credit" onclick="update_credit(this); update_credits(this);" type="checkbox" name="buy_credit" value="1" <?php echo ($buy_credit ? 'checked' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_buy_credit; ?></span>
            <?php foreach ($products as $product) { ?>
            <?php } ?>
            <?php } elseif ($product['nds'] == 0) { ?>
            <input id="buy_credit" onclick="update_credits(this);" type="checkbox" name="buy_credit" value="1" <?php echo ($buy_credit ? 'checked' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_buy_credit; ?></span>
            <?php } elseif ($product['nds'] == 1) { ?>
            <input id="buy_credit" onclick="update_credit(this);" type="checkbox" name="buy_credit" value="1" <?php echo ($buy_credit ? 'checked' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_buy_credit; ?></span>
            <?php } ?>  
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_agreement) { ?>
                <span class="error"><?php echo $error_agreement; ?></span>
                <?php } ?>
                <input type="checkbox" name="agreement" value="1" <?php echo ($agreement ? 'checked="checked"' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$entry_agreement; ?></span>
              </td>
            </tr>
            <tr>
              <td width="50%">
                <span style="color: #ec7500">* </span><span style="color: #919294"><?php echo $text_mandatory; ?></span>
              </td>
              <td width="50%" align="right">
                 <a onclick="$('#form').submit();" class="button"><span><?php  echo $button_checkout; ?></span></a>
              </td>
            </tr>
          </table>
        </form>
        </div>
        <div id="tab_urlico" class="tab_page">
          <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form1">
          <input type="hidden" value="urlico" name="form_name" />
          <input type="hidden" value="220" name="country_id" />
          <input type="hidden" value="3487" name="zone_id" />
          <input type="hidden" value="Бесплатная доставка" name="shipping_method" />
          <input type="hidden" value="Оплата при доставке" name="payment_method" />

          <table class="form" style="width: 100%">
            <tr>
              <td colspan="2">
                <?php if ($error_email_ur) { ?>
                <span class="error"><?php echo $error_email_ur; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $email; ?>" name="email" title="<?php echo $text_email; ?>"/><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_company) { ?>
                <span class="error"><?php echo $error_company; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $company; ?>" name="company" title="<?php echo $text_company; ?>" /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_postcode) { ?>
                <span class="error"><?php echo $error_postcode; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $postcode; ?>" name="postcode" title="<?php echo $text_postcode; ?>" /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_address_1_ur) { ?>
                <span class="error"><?php echo $error_address_1_ur; ?></span>
                <?php } ?>
                <div class="input<?php echo ($door_delivery ? ' zirka' : ''); ?>">
                  <div class="left"></div><input type="text" value="<?php echo $address_1; ?>" name="address_1" title="<?php echo $text_address_1; ?>" /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_address_2) { ?>
                <span class="error"><?php echo $error_address_2; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $address_2; ?>" name="address_2" title="<?php echo $text_address_2; ?>" /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_telephone_ur) { ?>
                <span class="error"><?php echo $error_telephone_ur; ?></span>
                <?php } ?>
                <div class="input zirka">
                  <div class="left"></div><input type="text" value="<?php echo $telephone; ?>" name="telephone" title="<?php echo $text_telephone; ?>" /><div class="right"></div>
                </div>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input id="cash_on_delivery_j" onclick="update_cash_on_delivery('j');" type="checkbox" name="cash_on_delivery" value="1" <?php echo ($cash_on_delivery ? ' checked' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_cash_on_delivery; ?></span>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_shipment; ?></td>
              <td><?php if (isset($shipments)) { ?>
                  <?php if($totsal > 0 && $nds_sub_total > 0) { ?>
    <select name="shipment_id" id="shipment_j" onchange="update_shipment('j'); update_shipments('j');" onkeyup="update_shipment('j'); update_shipments('j');">
            <?php foreach ($products as $product) { ?>
                              <?php } ?>
    <?php } elseif ($product['nds'] == 0) { ?>
    <select name="shipment_id" id="shipment_j" onchange="update_shipments('j'); " onkeyup="update_shipments('j');">
    <?php } elseif ($product['nds'] == 1) { ?>
    <select name="shipment_id" id="shipment_j" onchange="update_shipment('j'); " onkeyup="update_shipment('j');">
    <?php } ?> 

<!--                   <select name="shipment_id" id="shipment_j" onchange="update_shipment('j');" onkeyup="update_shipment('j');"> -->
                    <?php foreach ($shipments as $shipment) { ?>
                    <option value="<?php echo $shipment['shipment_id']; ?>"<?php echo ($shipment_id == $shipment['shipment_id'] ? ' selected="selected"' :'')?>>
                      <?php echo $shipment['name']; ?>
                      <?php if ($shipment['cost']) { ?>
                       (<?php echo $shipment['cost']; ?>)
                      <?php } ?>
                     </option>
                     <?php } ?>
                    </select>
                  <?php } ?>
              </td>
            </tr>
            <tr>
              <td><?php echo $entry_shipment_detail; ?></td>
              <td>
                  <select name="shipment_detail_id" id="shipment_detail_j" onchange="update_shipment_detail('j');" onkeyup="update_shipment_detail('j');">
                    <?php if (isset($shipment_details) && count($shipment_details) > 0) { ?>
                    <?php foreach ($shipment_details as $shipment_detail) { ?>
                    <option value="<?php echo $shipment_detail['shipment_detail_id']; ?>"<?php echo ($shipment_detail_id == $shipment_detail['shipment_detail_id'] ? ' selected="selected"' :'')?>>
                      <?php echo ($shipment_detail['region'].', '.$shipment_detail['city'].': '.$shipment_detail['address'].($shipment_detail['phone'] ? ', '.$shipment_detail['phone'] : '')); ?>
                     </option>
                     <?php } ?>
                  </select>
                  <?php } ?>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input id="door_delivery_j" onclick="update_door_delivery('j');" type="checkbox" name="door_delivery" value="1" <?php echo ($door_delivery ? ' checked' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$text_door_delivery; ?></span>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <?php if ($error_agreement) { ?>
                <span class="error"><?php echo $error_agreement; ?></span>
                <?php } ?>
                <input type="checkbox" name="agreement" value="1" <?php echo ($agreement ? 'checked="checked"' : ''); ?> /><span style="margin-bottom: 5px;"><?php echo ' ' .$entry_agreement; ?></span>
              </td>
            </tr>
            <tr>
                <td width="100%">
                    <span style="color: #ec7500">* </span><span style="color: #919294"><?php echo $text_mandatory; ?></span>
                </td>
                <td width="50%" align="right">
                    <a onclick="$('#form1').submit();" class="button"><span><?php echo $button_checkout; ?></span></a>
              </td>
            </tr>
          </table>
        </form>
        </div>
      <?php } ?>
      <div class="payu"><img src="/image/payu/logos-07.png" width="100%" /></div>
  </div>
</div>
<script type="text/javascript"><!--
  $.tabs('.tabs a', '<?php echo $active_tab; ?>');
  update_cash_on_delivery('f');
  if ($("#shipment_f option:selected").attr("cash_on_delivery") == 1) {
   $('#cash_on_delivery_f').removeAttr("disabled");
   $('#cash_on_delivery_j').removeAttr("disabled");
  } else {
   $('#cash_on_delivery_f').attr("disabled", "disabled");
   $('#cash_on_delivery_j').attr("disabled", "disabled");
  }
  if ($("#shipment_f option:selected").attr("door_delivery") == 1) {
   $('#door_delivery_f').removeAttr("disabled");
   $('#door_delivery_j').removeAttr("disabled");
  } else {
   $('#door_delivery_f').attr("disabled", "disabled");
   $('#door_delivery_j').attr("disabled", "disabled");
  }
  <?php if($door_delivery) { ?>
  $('#shipment_detail_f').closest('tr').hide();
  $('#shipment_detail_j').closest('tr').hide();
  <?php } ?>
  <?php if (!isset($shipment_details) || count($shipment_details) == 0) { ?>
  $('#shipment_detail_f').closest('tr').hide();
  $('#shipment_detail_j').closest('tr').hide();
  $('#door_delivery_f').attr("disabled", "disabled");
  $('#door_delivery_f').attr("checked", "checked");
  $('#door_delivery_j').attr("disabled", "disabled");
  $('#door_delivery_j').attr("checked", "checked");
  $('input[name=address_1]').each(function() {
    $(this).parent().addClass("zirka");
  });
  <?php } ?>
  // -- fizlico
  $('#form input[type=text]').each(
      function(){
          var position = $('#form input[type=text]').index(this);
          //alert(position);
          if (!dataFromClients[position]) {
            startValueInput.push(this.value);
          }
          else {
            startValueInput.push(this.value);
            $(this).addClass('active');
          }

          if (dataFromClients[position]) $(this).attr('value', dataFromClients[position]);
      }
    );
 $('#form input[type=text]').focus(
     function(){
   var position = $('#form input[type=text]').index(this);
   //if (startValueInput[position] == $.trim($(this).attr('value'))) {
            if (startValueInput[position] == startText[position]) {
                if (!dataFromClients[position]) {
                  $(this).attr({value: ""}).toggleClass('active');
                }
   }
  }
 );
 $('#form input[type=text]').blur(
     function(){
   var position = $('#form input[type=text]').index(this);

            if ($.trim($(this).attr('value')) == '') {
    $(this).attr({value: startValueInput[position]}).toggleClass('active');
   }
            if ($.trim($(this).attr('value')) != startText[position])
              dataFromClients[position] = $.trim($(this).attr('value'));
  }
 );
      
    // -- urlico
    $('#form1 input[type=text]').each(
      function(){
          var position = $('#form1 input[type=text]').index(this);
          //alert(position);
          if (!dataFromClientsUr[position]) {
            startValueInputUr.push(this.value);
          }
          else {
            startValueInputUr.push(this.value);
            $(this).addClass('active');
          }

          if (dataFromClientsUr[position]) $(this).attr('value', dataFromClientsUr[position]);
      }
    );
 $('#form1 input[type=text]').focus(
     function(){
   var position = $('#form1 input[type=text]').index(this);
   //if (startValueInput[position] == $.trim($(this).attr('value'))) {
            if (startValueInputUr[position] == startTextUr[position]) {
                if (!dataFromClientsUr[position]) {
                  $(this).attr({value: ""}).toggleClass('active');
                }
   }
  }
 );
 $('#form1 input[type=text]').blur(
     function(){
   var position = $('#form1 input[type=text]').index(this);

            if ($.trim($(this).attr('value')) == '') {
    $(this).attr({value: startValueInputUr[position]}).toggleClass('active');
   }
            if ($.trim($(this).attr('value')) != startTextUr[position])
              dataFromClientsUr[position] = $.trim($(this).attr('value'));
  }
 );
//--></script>
</div>
<?php echo $footer; ?>